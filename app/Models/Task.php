<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Task extends Model
{
    use HasFactory;

    protected $casts = [
        'status_history' => AsArrayObject::class, // Use the AsArrayObject cast
    ];

    protected $fillable = [
        'title',
        'description',
        'status',
        'category_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
