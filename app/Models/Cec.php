<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cec extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function route() {
        return $this->hasMany(Route::class, 'fleet_unique', 'fleet_id');
    }
}
