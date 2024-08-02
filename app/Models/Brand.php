<?php

namespace App\Models;

use App\Traits\ProfileImage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Brand extends Model
{
    use HasApiTokens, HasFactory, HasUuids, ProfileImage;

    protected $table = 'brands';

    protected $primarykey = 'id';

    protected $fillable = [
        'name',
        'slug',
    ];

    // function products(): HasMany
    // {
    //     return $this->HasMany(Product::class, 'brand_id', 'id');
    // }


    public function products(): HasMany
    {
        return $this->HasMany(Product::class);
    }
}
