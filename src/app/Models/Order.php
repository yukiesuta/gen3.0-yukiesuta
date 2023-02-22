<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Order extends Model
{
    use SoftDeletes;

    const DATE_FORMAT = 'Y/m/d';

    protected $fillable = [
        'user_id',
        'delivery_address_id',
        'delivery_date',
        'is_am',
        'delivery_method_id',
        'delivery_status_id',
        'total_price',
        'truck_id',
        'regular',
        'canceled_at',
    ];

    protected $dates = [
        'delivery_date',
        'canceled_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function delivery_address()
    {
        return $this->belongsTo('App\Models\DeliveryAddress');
    }

    public function delivery_method()
    {
        return $this->belongsTo('App\Models\DeliveryMethod');
    }

    public function delivery_status()
    {
        return $this->belongsTo('App\Models\DeliveryStatus');
    }

    public function truck()
    {
        return $this->belongsTo('App\Models\Truck');
    }

    public function order_details()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function getFullFormatDeliveryDateAttribute()
    {
        return self::getFullFormatDeliveryDate($this->delivery_date, $this->is_am);
    }

    public static function getDeliveryDateWhen(Carbon $delivery_date)
    {

        $today=Carbon::today();
        $tomorrow=Carbon::today()->addDay(1);
        $day_after_tomorrow=Carbon::today()->addDay(2);
        if ($today->isSameDay($delivery_date)) {
            return '今日';
        } elseif ($tomorrow->isSameDay($delivery_date)) {
            return '明日';
        } elseif ($day_after_tomorrow->isSameDay($delivery_date)) {
            return '明後日';
        }

        return '';
    }

    public static function getFormatDeliveryDate(Carbon $delivery_date)
    {
        return $delivery_date->format(self::DATE_FORMAT);
    }

    public static function getAmOrPm(bool $is_am)
    {
        return $is_am ? 'AM' : 'PM';
    }

    public static function getFullFormatDeliveryDate(Carbon $delivery_date, bool $is_am)
    {
        $delivery_date_when = self::getDeliveryDateWhen($delivery_date);
        $format_delivery_date = self::getFormatDeliveryDate($delivery_date);
        $am_or_pm = self::getAmOrPm($is_am);

        return "{$delivery_date_when}({$format_delivery_date}) {$am_or_pm}";
    }
}
