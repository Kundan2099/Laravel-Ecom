<?php

namespace App\Models;

use App\Traits\ProfileImage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class SubCategory extends Model
{
    use HasFactory, HasUuids, SoftDeletes, ProfileImage, Notifiable;

    protected $table = 'sub_categories';
    protected $primarykey = 'id';

    protected $fillable = ['name','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
