<?php

namespace App\Models;

use App\Traits\ProfileImage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Brand extends Model
{
    use  HasFactory, HasUuids, ProfileImage;


    // function products(): HasMany
    // {
    //     return $this->HasMany(Product::class, 'brand_id', 'id');
    // }

}
