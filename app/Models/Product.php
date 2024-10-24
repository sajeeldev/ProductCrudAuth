<?php

namespace App\Models;

use App\Enum\Productstatus;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'variant',
        'price',
        'qty',
        'status'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'status' => Productstatus::class,
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
