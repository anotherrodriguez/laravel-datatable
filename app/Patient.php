<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_service'
    ];

     /**
     * Get the site that owns the department.
     */
    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function email()
    {
        return $this->hasMany('App\Email');
    }

    public function phoneNumber()
    {
        return $this->hasMany('App\PhoneNumber');
    }

}