<?php

namespace App\Models;

use App\Traits\ProfileImage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes, ProfileImage, Notifiable;

    protected $table = 'categories';
    protected $primarykey = 'id';

    protected $fillable = ['name'];


    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
