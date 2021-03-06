<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

     /**
     * Get the site that owns the department.
     */
    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function patient()
    {
        return $this->hasMany('App\Patient');
    }

    public function status()
    {
        return $this->hasMany('App\Status');
    }
}