<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    protected $table = 'users';

    private const USERS_BY_PAGE = 5;
    public static function getAllUsers(){
        return User::all();
    }

    public static function getUsersByPage($page){
        $itensToJump = self::USERS_BY_PAGE * ($page - 1);
        
        return User::skip($itensToJump)
                            ->take(self::USERS_BY_PAGE)
                            ->orderBy('name','asc')
                            ->get();
    }
}
