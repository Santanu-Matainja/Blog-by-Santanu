<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'image',
        'description',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function categories()
    {
        return [
            1 => 'Technical',
            2 => 'Business',
            3 => 'Lifestyle',
            4 => 'Education',
        ];
    }

    public function getCategoryNameAttribute()
    {
        return self::categories()[$this->category] ?? 'Unknown';
    }
}
