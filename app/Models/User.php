<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_photo',
        'user_type',
    ];


    // protected $guarded = [];
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function hasLikedBlog($blogId)
    {
        $liked = $this->liked_blogs ? json_decode($this->liked_blogs, true) : [];
        return in_array($blogId, $liked);
    }
}
