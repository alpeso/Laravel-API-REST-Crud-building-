<?php

namespace Building;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'building';
    protected $fillable = array('first_name','last_name','address','email','phone','birth_date');
}
