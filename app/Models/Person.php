<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {
    protected $table = 'persons';
    protected $fillable = ['name','age','location'];
    public function pictures(){ return $this->hasMany(Picture::class); }
    public function likes(){ return $this->hasMany(Like::class); }
    public function likesCount(){ return $this->likes()->where('is_like', true)->count(); }
}