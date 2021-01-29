<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'c_name',
        'mobile',
        'c_mobile',
        'id_no',
        'c_county',
        'email',
        'password',
        'suspend',
        'handle'
    ];

    protected $dates = [
        'suspend'
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function agent_parcels() {
        return $this->belongsToMany(Parcel::class, 'parcel_users');
    }
    public function agent_booking() {
        return $this->belongsToMany(Booking::class, 'booking_users')->where('is_paid', 1);
    }
    public function agent_routes() {
        return $this->belongsToMany(Route::class, 'agent_routes', 'user_id', 'route_id')->where([['admin_suspend', 0]]);
    }
    // public function agent_parcels() {
    //     return $this->belongsToMany(Parcel::class, 'parcel_users');
    // }
}
