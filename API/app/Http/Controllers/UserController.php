<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ValidationMessages;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    public function getAllUsers(){
        $users = User::getAllUsers();  
        if($users->count() > 0){
            $payload = ['users' => $users];
            return $this->handleSucess($payload);
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

    public function addUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ],
        [
            'required' => ValidationMessages::REQUIRED,
            'max_digits' => ValidationMessages::MAX_DIGITS,
            'string' => ValidationMessages::STRING,
        ]);

        if($validator->fails()){
            return $this->handleValidationError($validator);
        }

        $validatedData = $validator->validated();
        Log::debug($validatedData);
        Log::debug($validatedData['name']);
        try{
            $user = User::create([
                'name' => $validatedData['name'],
            ]);
            $payload = ['user_id' => $user->id];
            return $this->handleSucess($payload);
        }catch(Exception $exception){
            $payloadException = ['error' => $exception->getMessage()];
            return $this->handleUnexpectedError($payloadException);
        }        
        
    }
}
