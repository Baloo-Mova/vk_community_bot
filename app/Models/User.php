<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int                                                                                                            $id
 * @property string                                                                                                         $name
 * @property string|null                                                                                                    $email
 * @property string                                                                                                         $password
 * @property string|null                                                                                                    $remember_token
 * @property \Carbon\Carbon|null                                                                                            $created_at
 * @property \Carbon\Carbon|null                                                                                            $updated_at
 * @property string                                                                                                         $vk_token
 * @property int                                                                                                            $vk_id
 * @property int                                                                                                            $expiresIn
 * @property boolean                                                                                                        $trial_used
 * @property string                                                                                                         $avatar
 * @property string                                                                                                         $FIO
 * @property string                                                                                                         $balance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserGroups[]                                         $groups
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentLogs[]                                        $payments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFIO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereVkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereVkToken($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vk_token',
        'vk_id',
        'expiresIn',
        'avatar',
        'FIO',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function groups()
    {
        return $this->hasMany(UserGroups::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentLogs::class);
    }

}
