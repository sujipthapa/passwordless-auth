<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LoginAttempt extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'login_attempts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'token',
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }

    /**
     * @param $token
     */
    public static function userFromToken($token)
    {
        $query = self::where('token', $token)
            ->where('created_at', '>', Carbon::parse('-15 minutes'))
            ->first();

        return $query->user ?? null;
    }
}
