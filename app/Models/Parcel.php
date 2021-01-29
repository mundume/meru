<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = ['provider' => 'array'];
    public function dropoff() {
        return $this->hasOne(Dropoff::class, 'id', 'destination');
    }
    public function fleet() {
        return $this->hasOne(Fleet::class, 'id', 'fleet_id');
    }
    // public function agent_parcels() {
    //     return $this->belongsToMany(User::class, 'parcel_users')->withTimestamps();
    // }
}
