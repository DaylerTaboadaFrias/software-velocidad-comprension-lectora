<?php

namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Order;
use App\Models\Factura;
use App\Models\OrdenPlan;
use App\Models\Cybersource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class PagoController extends Controller
{
  
    
    public function index(Request $request,$token,$plan,$user_id,$orden_id)
    {
        //$factura = Factura::obtenerFacturaPorToken($token);
        $token = Str::uuid();
        session()->put('token', $token);
        $merchant_id = Cybersource::getMerchantId();
        $df_org_id = Cybersource::getOrgId();
        $profile_id = Cybersource::getProfileId();
        $access_key_secure_acceptance = Cybersource::getAccessKeySecureAcceptance();
        $secret_key_secure_acceptance = Cybersource::getSecretKeySecureAcceptance();

        $payment_url = Cybersource::getPaymentUrl();
        $create_token_url = Cybersource::getCreateTokenUrl();
        $update_token_url = Cybersource::getUpdateTokenUrl();


        $customer_ip_address = $request->ip();
        $signed_data_time = gmdate("Y-m-d\TH:i:s\Z");
        $session_id = Cybersource::getIdentificador();
        $plancito = new Plan;
        $price =0;
        if($orden_id == 0 ){
            $plancito = Plan::findOrFail($plan);
            $price = $plancito->cost;
        }else if($plan == 0){
            $plancito = Plan::findOrFail($plan);
            $price = $plancito->cost;
        }
        return view('pago.index', [
                    //dd"factura"=>$factura,           
                    "profile_id"=>$profile_id,
                    "access_key_secure_acceptance"=>$access_key_secure_acceptance,
                    "secret_key_secure_acceptance"=>$secret_key_secure_acceptance,
                    "payment_url"=>$payment_url,
                    "create_token_url"=>$create_token_url,
                    "update_token_url"=>$update_token_url,
                    "customer_ip_address"=>$customer_ip_address,
                    "transaction_uuid"=> uniqid(),
                    "signed_data_time" => $signed_data_time,
                    "merchant_id"=> $merchant_id,
                    "df_org_id"=> $df_org_id,
                    "session_id"=> $session_id,
                    "token"=>$token,
                    "identificador"=>$token,
                    'plan'=>$plancito,
                    'price'=>$price,
                    'user_id'=> $user_id,
                    'orden_id'=> $orden_id
                    //"identificador"=>$factura->id
                ]);
    }

    
    public function confirmar(Request $request)
    {
        $token = session()->get('token');

        $card_number = preg_replace('/\D/', '',trim($request->card_number));
        $request->request->add(['card_number' => $card_number]);
        $card_expiry_date = str_replace(' ', '', $request->card_expiry_date);
        $expiracion = explode('/', $card_expiry_date);
        $mes = $expiracion[0];
        $year = $expiracion[1];
        $type_card_number = "";
        if(Cybersource::verificarNumberCardLuhn($request->card_number)){
            
            if(Cybersource::validateDate($mes,$year)){
                if(Cybersource::verificarExpiracion($mes,$year)){
                    $type_card_number = Cybersource::getCardType($request->card_number);
                    if($type_card_number=="001" || $type_card_number=="002"){
                        $request->request->add(['card_type' => $type_card_number]);
                        $request->request->add(['card_expiry_date' => $mes.'-'.$year]);
                        $payment_url = Cybersource::getPaymentUrl();
                       $endpoint_url = $payment_url;
                        $sign = Cybersource::sign($request->all());
                        
                        $date = Carbon::now();
                        // if($request->merchant_defined_data23){
                        //     $estaSuscribido = OrdenPlan::where('user_id',$request->user_id)->where('start_date','<=',$date)->where('end_date','>=',$date)->get(); 
                        //     if((count($estaSuscribido) > 0)){
                        //         session()->flash("suscrito", __("Tienes un suscripción vigente."));
                        //         return redirect(route("dashboard"));
                        //     }
                        // }
                        
                        return view("pago.confirmar",[
                            "endpoint_url"=>$endpoint_url,
                            "sign"=>$sign,
                            "token"=>$token,
                            "plan"=>$request->plan,
                            "user_id"=>$request->user_id,
                            "orden_id"=>$request->orden_id,
                            "params"=>$request->all()
                        ]);
                    }else{
                        session()->flash('message', 'Tipo de tarjeta no permitida, se permite solo tarjetas visa y mastercard');
                        return $this->index($request,$token);
                    }
                }else{
                    session()->flash('message', 'La fecha de expiración ingresada se encuentra vencida.');
                    return $this->index($request,$token);
                }
            }else{
                session()->flash('message', 'La fecha de expiración ingresada no es valida.');
                return $this->index($request,$token);
            }

        }else{
            session()->flash('message', 'Número de tarjeta invalida');
            return $this->index($request,$token);
        }
    }



    public function callback(Request $request,$token)
    {
        $message = "";
        $response = $request->all();
        if($response['reason_code']=="100" && $response['decision']=="ACCEPT"){   
            $identificador =$response['transaction_id'];
            $message = "Transacción realizada exitosamente";
            $dateStart = Carbon::now();
            $dateEnd = Carbon::now();
            $dateEnd = $dateEnd->addMonth();
            
                $ordenPlan = new OrdenPlan ;
                $ordenPlan->plan_id = $request->req_merchant_defined_data23 ;
                $ordenPlan->user_id = $request->req_merchant_defined_data24 ;
                $ordenPlan->start_date = $dateStart->format('Y-m-d');
                $ordenPlan->end_date = $dateEnd->format('Y-m-d');
                $ordenPlan->state = 'Activado';
                $ordenPlan->save();
                session()->flash("suscrito", __("Tienes un suscripción vigente."));
                return view('pago.finalizar',['mensaje'=>$message]);
            
            

        }else{
            $message = $response['message'];
            return view('pago.finalizar',['mensaje'=>$message]);
        }
    }


}
