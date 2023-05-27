<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public const  MESSAGE_NOT_RETRIEVED_INFO = 'Não foi encontrado nenhuma informação na consulta';

    public const MESSAGE_NOT_RETRIEVED_INFO_THIS_PAGE = "Não foi encontrado nenhuma informação nessa página";

    public static function handlePaginateNotFoundError($page){
        if($page > 1){
            return response()->json([
               'success' => false,
               'message' => Controller::MESSAGE_NOT_RETRIEVED_INFO_THIS_PAGE,
            ],404);
        }else{
            return response()->json([
               'success' => false,
               'message' => Controller::MESSAGE_NOT_RETRIEVED_INFO,
            ],404);
        }
    }

    public static function handleNotFoundItemsError(){
        return response()->json([
            'success' => false,
            'message' => Controller::MESSAGE_NOT_RETRIEVED_INFO,
         ],404);
    }

    public static function handleValidationError($validator){
        return response()->json(['success' => false,'msg_erro' =>  $validator->errors()->first()],422);
    }

    public static function handleSucess($payload){
        return response()->json(['success' => true,...$payload],200);
    }
    public static function handleSucessPaginate($payload,$page){
        $page = intval($page);
        $nextPage = $page + 1;
        if($page > 1){
            $previousPage = $page - 1;
        }else{
            $previousPage = null;
        }
        
        return response()->json([
           'success' => true,
            ...$payload,
            'page' => $page,
            'next_page' => $nextPage, 
            'previous_page' => $previousPage
        ],200);
    }

    public static function handleUnexpectedError($payload){
        return response()->json([
           'success' => false,
           ...$payload
        ],500);
    }
}
