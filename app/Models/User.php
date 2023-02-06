<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Для отправки писем восстановления пароля
    public function sendPasswordResetNotification($token): void
    {
        $notification = new ResetPassword($token);
        $notification->createUrlUsing(function ($user, $token) {
            return url(route('user.password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]));
        });
        $this->notify($notification);
    }

    /**
     * Преобразует дату и время регистрации пользователя из UTC в Asia/Yekaterinburg
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getCreatedAtAttribute($value): bool|\Carbon\Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Asia/Yekaterinburg');
    }

    /**
     * Преобразует дату и время обновления пользователя из UTC в Asia/Yekaterinburg
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getUpdatedAtAttribute($value): bool|\Carbon\Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Asia/Yekaterinburg');
    }

    /**
     * Связь «один ко многим» таблицы `users` с таблицей `profiles`
     *
     * @return HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
