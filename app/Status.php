<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

        public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function patient()
    {
        return $this->hasMany('App\Patient');
    }

}
