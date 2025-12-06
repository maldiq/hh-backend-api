<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model {
    protected $table = 'pictures';
    protected $fillable = ['person_id','url'];
    public function person(){ return $this->belongsTo(Person::class); }
}
