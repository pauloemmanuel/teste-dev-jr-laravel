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

    public function handlePaginateGetError($page){
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

    public function handleNotFoundItemsError(){
        return response()->json([
            'success' => false,
            'message' => Controller::MESSAGE_NOT_RETRIEVED_INFO,
         ],404);
    }
}
