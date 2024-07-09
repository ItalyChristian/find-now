<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
    public function image(): MorphOne
    {

        return $this->morphOne(Image::class, 'images');
    }
    public function rating(): MorphMany
    {

        return $this->morphMany(Rating::class, 'ratings');
    }
    public function settingProfileUser()
    {
        return $this->hasOne(SettingProfileUser::class);
    }
    public function address(): MorphMany
    {

        return $this->morphMany(Address::class, 'address');
    }
}
