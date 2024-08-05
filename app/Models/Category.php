<?php

namespace App\Models;

use App\Traits\ProfileImage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes, ProfileImage, Notifiable;


    public function sub_categories(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
