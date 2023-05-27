<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vehiclePlate',
        'entryDateTime',
        'exitDateTime',
        'priceType',
        'price',
        'userId'
    ];

    public const SERVICES_ORDER_BY_PAGE = 5;

    public static function getAllServicesOrders(){
        return ServiceOrder::all();
    }

    public static function getServicesOrdersByPage($page,$vehiclePlate = null){
        $itensToJump = self::SERVICES_ORDER_BY_PAGE * ($page - 1);
        
        return ServiceOrder::skip($itensToJump)
                            ->take(self::SERVICES_ORDER_BY_PAGE)
                            ->join('users', 'service_orders.userId', '=', 'users.id')
                            ->select('service_orders.*', 'users.name as user_name')
                            ->where(function(Builder $query) use ($vehiclePlate){
                                if($vehiclePlate != null){
                                    $query->where('vehiclePlate',$vehiclePlate);
                                }
                            })
                            ->orderBy('entryDateTime','desc')
                            ->get();
    }
}
