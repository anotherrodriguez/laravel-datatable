<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //
    protected $fillable = [
        'email'
    ];

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

}

