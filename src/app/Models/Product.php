<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'version',
        'name',
        'description',
        'thumbnail',
        'image1',
        'quantity',
        'price',
        'is_active',
    ];

    public function order_details()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function getFormatPriceAttribute()
    {
        return '¥' . number_format($this->price);
    }

    public function deleteProduct($product_id) {
        $delete = $this->where('id',$product_id)->delete();

        if($delete > 0){
            $message = 'カートから一つの商品を削除しました';
        }else{
            $message = '削除に失敗しました';
        }
        return $message;
    }
}
