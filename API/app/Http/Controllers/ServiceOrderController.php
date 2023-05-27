<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceOrdersPostRequest;
use App\Models\ServiceOrder;
use App\Models\User;
use App\Models\ValidationMessages;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceOrderController extends Controller
{
    public const ERROR_USER_NOT_FOUND = 'Usuário não encontrado, favor informar um userID válido';
    public function getAllServiceOrders(){
        $serviceOrders = ServiceOrder::getAllServicesOrders();  
        if($serviceOrders->count() > 0){
            $payload = ['service_orders' => $serviceOrders];
            return $this->handleSucess($payload);
        }else{
            return $this->handleNotFoundItemsError();
        }
    }

    public function getServiceOrders($page = 1,$vehiclePlate = null){
        
        $validator = Validator::make(['page' => $page,'vehiclePlate' => $vehiclePlate], [
            'page' => 'nullable|numeric',
            'vehiclePlate' => 'nullable|alpha_dash:ascii|max:7',
        ],
        [
            'numeric' => ValidationMessages::NUMERIC,
            'alpha_dash' => ValidationMessages::ALPHA_DASH,
            'max' => ValidationMessages::MAX_DIGITS
        ]);

        if($validator->fails()){
           return $this->handleValidationError($validator);
        }

        $serviceOrders = ServiceOrder::getServicesOrdersByPage($page,$vehiclePlate);  
        
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

    public function addServiceOrder(Request $request){
        $validator = Validator::make($request->all(), ServiceOrdersPostRequest::RULES,ServiceOrdersPostRequest::MESSAGES);
        
        if($validator->fails()){
            return $this->handleValidationError($validator);
         }

        $validatedData = $validator->validated();
        
        try{
            $user = User::find($validatedData['userId']);
            if(!empty($user->id)){
                $service_order = ServiceOrder::create($validatedData);
                $payload = ['service_order_id' => $service_order->id];
                return $this->handleSucess($payload);
            }else{
                $payload = ['error' => self::ERROR_USER_NOT_FOUND];
                return $this->handleUnexpectedError($payload);
            }
        }catch(Exception $exception){
            Log::error($exception);
            $payloadException = ['error' => $exception->getMessage()];
            return $this->handleUnexpectedError($payloadException);
        }     
        
    }
}
