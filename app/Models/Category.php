<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function calendarial() {
        return $this->hasMany(Calendarial::class)->where('user_id', auth()->user()->id);
    }
}
