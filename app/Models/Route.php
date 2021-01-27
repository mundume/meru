<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'pick_up' => 'array'
    ];
    public function agent() {
        return $this->belongsToMany(User::class, 'agent_routes');
    }
}
