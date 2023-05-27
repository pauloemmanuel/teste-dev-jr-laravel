<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ValidationMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    public function getAllUsers(){
        $users = User::getAllUsers();  
        if($users->count() > 0){
            return response()->json([ 'success' => true,'users' => $users],200);
        }else{
            return $this->handleNotFoundItemsError();
        }
    }

    public function getUsers($page = 1){
        
        $validator = Validator::make(['page' => $page], [
            'page' => 'nullable|numeric'
        ],
        [
            'numeric' => ValidationMessages::NUMERIC,
        ]);

        if($validator->fails()){
            return $this->handleValidationError($validator);
        }

        $users = User::getUsersByPage($page);  
        
        if($users->count() > 0){
            $payload = ['users' => $users];
            return $this->handleSucessPaginate($payload,$page);
        }else{
            return $this->handlePaginateNotFoundError($page);
        }

    }
}
