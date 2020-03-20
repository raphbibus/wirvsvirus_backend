<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'display_name', 'points', 'seconds',
    ];

    protected $hidden = [
        'id',
    ];

}
