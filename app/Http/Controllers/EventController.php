<?php

namespace App\Http\Controllers;

use QrCode;
use stdClass;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Photo;
use App\Enums\Removed;
use App\Models\Client;
use App\Mail\Invitacion;
use App\Models\OrdenPlan;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Support\Renderable;

class EventController extends Controller
{
    
    public function listaEventosApi()
    {   
        $eventos = Event::get();
        $listado = array();

        $urlImagenes = env('URI_EVENPHER_PUBLIC');
        foreach ($eventos as $evento) {
            $eventObject = new stdClass();
            $eventObject->id = $evento->id;
            $eventObject->nombre = $evento->nombre;
            $eventObject->imagen = $urlImagenes . $evento->imagen;
            array_push($listado, $eventObject);
        }
        return response()->json($listado);
    }
    
    public function listaFotosApi($id)
    {
        $fotos = Photo::where('event_id',$id)->get();
        $listado = array();

        $urlImagenes = env('URI_EVENPHER_PUBLIC');
        foreach ($fotos as $foto) {
            $eventObject = new stdClass();
            $eventObject->id = $foto->id;
            $eventObject->imagen = $urlImagenes . $foto->imagen;
            array_push($listado, $eventObject);
        }
        return response()->json($listado);
    }

    public function login(Request $request)
    {
        $cliente = Client::where('email',$request->email)->where('password',$request->password)->first();
        if($cliente){
            return response()->json($cliente);
        }
        return response()->json(null);
    }

    public function listarOrganizacion()
    {   if(auth()->user()->organizacion_id or (auth()->user()->organizacion_id == null and auth()->user()->role == 'Organizacion' ) ){
            $eventos = Event::with('user_event.user')->whereHas('user_event.user', function ($query) {
                return $query->where('id', '=', auth()->user()->id);
            })->get();
        }else{
            $eventos = [];
        }
        return view('evento.organizacion.index',compact('eventos'));
    }
    
    public function crear()
    {
        $evento = new Event;
        $title = __("Crear evento");
        $action = route("evento.store");
        $date = Carbon::now();
        $estaSuscribido = OrdenPlan::where('user_id',auth()->user()->id)->where('start_date','<=',$date)->where('end_date','>=',$date)->get(); 
        if(!(count($estaSuscribido) > 0)){
            session()->flash("success", __("Tienes que sucribirte primero"));
            return redirect(route("dashboard"));
        }
        return view('evento.organizacion.form',compact('evento','title','action'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'type_event_id' => 'required',
            'hora_fin' => 'required',
            'imagen' => 'required',
        ]);
        $input = $request->all();
        if ($image = $request->file('imagen')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['imagen'] = "$profileImage";
        }
        
        $event = new Event ;
        $event->nombre = $input['nombre'];
        $event->fecha = $input['fecha'];
        $event->hora_inicio = $input['hora_inicio'];
        $event->type_event_id = $input['type_event_id'];
        $event->hora_fin = $input['hora_fin'];
        $event->imagen = $input['imagen'];
        $event->direccion = $input['direccion'];
        $event->cantidad_personas = $input['cantidad_personas'];
        $event->detalle = $input['detalle'];
        $event->save();
        $userEvent = new UserEvent;
        $userEvent->user_id=auth()->user()->id;
        $userEvent->event_id=$event->id;
        $userEvent->removed=Removed::Activado;
        $userEvent->save();
        session()->flash("success", __("El evento ha sido creado correctamente"));
        return redirect(route("organizacion.eventos"));
    }
    
    public function storeFotografo(Request $request, $event_id)
    {
        $request->validate([
            'correo' => 'required'
        ]);
        // $existe =  UserEvent::where('removed',Removed::Activado)->where('event_id',$event_id)->where('user_id',$request->fotografo_id)->first() ;
        // $evento = Event::findOrFail($event_id);
        // if($existe){
        //     session()->flash("success", __("El fotografo ya ha sido agregado a este evento."));
        //     return redirect(route("evento.add.fotografos", ["evento" => $evento]));
        // }
        // $input = $request->all();
        // $userEvent = new UserEvent ;
        // $userEvent->user_id = $input['fotografo_id'];
        // $userEvent->event_id = $event_id;
        // $userEvent->removed = 'Activado';
        // $userEvent->save();
        Mail::to($request->correo)->send(new Invitacion);
        session()->flash("success", __("El fotografo ha sido creado correctamente"));
        return redirect(route("evento.add.fotografos", ["evento" => $evento]));
    }

    public function edit(Event $evento): Renderable {
        $estaSuscribido = OrdenPlan::where('user_id',auth()->user()->id)->where('start_date','<=',$date)->where('end_date','>=',$date)->get(); 
        if(!(count($estaSuscribido) > 0)){
            session()->flash("success", __("Tienes que sucribirte primero"));
            return redirect(route("dashboard"));
        }
        $title = __("Actualizar evento");
        $action = route("evento.update", ["evento" => $evento]);
        return view("evento.organizacion.form", compact("evento", "title", "action"));
    }
    public function addFotografo(Event $evento): Renderable {
        $title = __("Agregar fotografo al evento : ".$evento->nombre);
        $action = route("evento.store.fotografos", ["event_id" => $evento->id]);
        // $fotografos = User::with('user_event')->whereHas('user_event', function ($query) use($evento) {
        //     return $query->where('event_id', '=', $evento->id)->where('removed', '=', Removed::Activado)->where('user_id', '!=', auth()->user()->id);
        // })->get();
        // $fotografos = User::with('user_event')->with(['user_event' => function ($query)  use($evento) {
        //     $query->where('event_id', '=', $evento->id)->where('removed', '=', Removed::Activado)->where('user_id', '!=', auth()->user()->id);
        //     }])->get();
        $fotografos = UserEvent::with('user')->where('event_id', '=', $evento->id)->where('removed', '=', Removed::Activado)->where('user_id', '!=', auth()->user()->id)->get();
        $fotografosSelect = User::where('organizacion_id',auth()->user()->id)->with('user_event')->get();
        return view("evento.organizacion.fotografos", compact("fotografosSelect","evento","fotografos", "title", "action"));
    }
    public function update(Request $request, Event $evento) {
        $request->validate([
            'nombre' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'type_event_id' => 'required',
            'hora_fin' => 'required',
        ]);
        
        $input = $request->all();
        if ($image = $request->file('imagen')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['imagen'] = "$profileImage";
        }else{
            unset($input['imagen']);
        }
          
        $evento->update($input);
        session()->flash("success", __("El evento ha sido actualizado correctamente"));
        return redirect(route("organizacion.eventos"));
    }
    public function destroy(Event $evento) {
        $estaSuscribido = OrdenPlan::where('user_id',auth()->user()->id)->where('start_date','<=',$date)->where('end_date','>=',$date)->get(); 
        if(!(count($estaSuscribido) > 0)){
            session()->flash("success", __("Tienes que sucribirte primero"));
            return redirect(route("dashboard"));
        }
        $evento->delete();
        session()->flash("success", __("El evento ha sido eliminado correctamente"));
        return redirect(route("organizacion.eventos"));
    }

    public function destroyFotografo($user_event) {
        $userEvent = UserEvent::findOrFail($user_event);
        $evento = Event::findOrFail($userEvent->event_id);
        $userEvent->removed = Removed::Eliminado;
        $userEvent->delete();
        session()->flash("success", __("El fotografo ha sido eliminado correctamente"));
        return redirect(route("evento.add.fotografos", ["evento" => $evento]));
    }
}
