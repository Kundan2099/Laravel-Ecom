<?php

namespace App\Models;

use App\Traits\ProfileImage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class ProductImage extends Model
{
    use HasFactory, HasUuids, ProfileImage, Notifiable;


    // public function product(): HasOne
    // {
    //     return $this->hasOne(Product::class, 'id', 'product_id');
    // }
}
