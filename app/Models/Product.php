<?php

namespace App\Models;

use App\Traits\ProfileImage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes, ProfileImage, Notifiable;

    protected $table = 'products';

    protected $primarykey = 'id';

    // function category(): HasOne
    // {
    //     return $this->hasOne(Category::class, 'id', 'category_id');
    // }

    // function sub_category(): HasOne
    // {
    //     return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    // }

    // function brand(): HasOne
    // {
    //     return $this->hasOne(Brand::class, 'id', 'brand_id');
    // }



    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function sub_category(): HasOne
    {
        return $this->hasOne(SubCategory::class);
    }

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class);
    }
}
