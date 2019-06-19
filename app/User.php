<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rollApiKey()
    {
        do {
            $this->api_token = Str::random(60);
        } while($this->where('api_token', $this->api_token)->exists());

        $this->save();
    }

    public function dropApiKey()
    {
        $this->api_token = null;
        $this->save();
    }

    public function cards()
    {
        return $this->hasMany('App\Entity\Card\Card', 'owner_id');
    }
}
