<?php

namespace App\Http\Controllers;

use QrCode;
use stdClass;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Enums\Removed;
use App\Models\OrdenPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Support\Renderable;

class EventController extends Controller
{
    
    
    public function listarOrganizacion()
    {   $eventos = Event::get();
        
        return view('evento.organizacion.index',compact('eventos'));
    }
    
    public function crear()
    {
        $evento = new Event;
        $title = __("Crear evento");
        $action = route("evento.store");
        $date = Carbon::now();
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
        session()->flash("success", __("El evento ha sido creado correctamente"));
        return redirect(route("organizacion.eventos"));
    }
    
    
    public function edit(Event $evento): Renderable {
        
        $title = __("Actualizar evento");
        $action = route("evento.update", ["evento" => $evento]);
        return view("evento.organizacion.form", compact("evento", "title", "action"));
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
        $evento->delete();
        session()->flash("success", __("El evento ha sido eliminado correctamente"));
        return redirect(route("organizacion.eventos"));
    }
}
