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
            $payload = [ 'success' => true,'service_orders' => $serviceOrders];
            return $this->handleSucess($payload);
        }else{
            return $this->handleNotFoundItemsError();
        }
    }

    public function getServiceOrders($page = 1,$vehiclePlate = null){
        
        $validator = Validator::make(['page' => $page,'vehiclePlate' => $vehiclePlate], [
            'page' => 'nullable|numeric',
            'vehiclePlate' => 'nullable|alpha_dash:ascii|max_digits:7',
        ],
        [
            'numeric' => ValidationMessages::NUMERIC,
            'alpha_dash' => ValidationMessages::ALPHA_DASH,
            'max_digits' => ValidationMessages::MAX_DIGITS
        ]);

        if($validator->fails()){
           return $this->handleValidationError($validator);
        }

        $serviceOrders = serviceOrder::getServicesOrdersByPage($page,$vehiclePlate);  
        
        if($vehiclePlate != null){
            $serviceOrders->where('vehiclePlate',$vehiclePlate);
        }

        if($serviceOrders->count() > 0){
            $payload = ['service_orders' => $serviceOrders];
            return $this->handleSucessPaginate($payload,$page);
        }else{
            return $this->handlePaginateNotFoundError($page);
        }

    }
}
