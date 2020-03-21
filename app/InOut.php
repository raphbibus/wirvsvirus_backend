<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InOut extends Model
{

    protected $table = 'inouts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    protected $hidden = [
        'id', 'client_id'
    ];

    protected $dates = [
        'entered', 'left',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

}
