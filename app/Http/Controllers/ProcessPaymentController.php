<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProcessPaymentController extends Controller
{
    public function index(Plan $plan){
        $token = Str::uuid();

        if(!auth()->user()){
            return redirect(url("/login"));
        }else{
            return redirect(route("pagar", ["token" => $token , "plan" => $plan, "user_id" => auth()->user()->id, "orden_id" => 0]));
        }
        
    }
}
