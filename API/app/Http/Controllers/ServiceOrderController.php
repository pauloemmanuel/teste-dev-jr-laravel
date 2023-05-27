<?php

namespace App\Http\Controllers;

use App\Models\serviceOrder;
use App\Models\ValidationMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceOrderController extends Controller
{
    public function getAllServiceOrders(){
        $serviceOrders = serviceOrder::getAllServicesOrders();  
        if($serviceOrders->count() > 0){
            return response()->json([ 'success' => true,'service_orders' => $serviceOrders],200);
        }else{
            return $this->handleNotFoundItemsError();
        }
    }

    public function getServiceOrders($page = 1,$vehiclePlate = null){
        
        $validator = Validator::make(['page' => $page,'vehiclePlate' => $vehiclePlate], [
            'page' => 'nullable|numeric',
            'vehiclePlate' => 'nullable|alpha_dash:ascii',
        ],
        [
            'numeric' => ValidationMessages::NUMERIC,
            'alpha_dash' => ValidationMessages::ALPHA_DASH,
        ]);

        if($validator->fails()){
            return response()->json(['success' => false,'msg_erro' =>  $validator->errors()->first()],422);
        }

        $serviceOrders = serviceOrder::getServicesOrdersByPage($page,$vehiclePlate);  
        
        if($vehiclePlate !== false){
            $serviceOrders->where('vehiclePlate',$vehiclePlate);
        }
        
            Log::debug($serviceOrders);
        if($serviceOrders->count() > 0){
            return response()->json([ 'success' => true, 'service_orders' => $serviceOrders, 'page' => $page],200);
        }else{
            return $this->handlePaginateGetError($page);
        }

    }
}
