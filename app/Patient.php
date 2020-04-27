<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number'
    ];

     /**
     * Get the site that owns the department.
     */
    public function status()
    {
        return $this->belongsTo('App\Status');
    }

}
