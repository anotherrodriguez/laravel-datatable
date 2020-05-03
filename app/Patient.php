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
        'email_1',
        'email_2',
        'email_3',
        'phone_number_1',
        'phone_number_2',
        'phone_number_3',
        'date_of_service'
    ];

     /**
     * Get the site that owns the department.
     */
    public function status()
    {
        return $this->belongsTo('App\Status');
    }

}