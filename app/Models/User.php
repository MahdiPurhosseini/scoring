<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'mobile_verified_at',
        'mobile_activation_code',
        'time_activation_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'mobile_activation_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mobile_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $appends = ['cover_url'];

    /**
     * @return mixed
     */
    public function scopeConfirmed(): mixed
    {
        return static::whereNotNull('mobile_verified_at');
    }


    public function getRoleAttribute()
    {
        $role = null;
        $roles = Role::all();
        foreach ($roles as $item){
            if ($this->score >= $item->from_rate and $this->score <= $item->to_rate){
                $role = $item->name;
                break;
            }
        }
        return $this->attributes['role'] = $role;
    }
}
