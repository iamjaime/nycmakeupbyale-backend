<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    public $table = 'portfolio';

    protected $fillable = [
        'title',
        'description',
        'url',
        'category',
        'box_size'
    ];
}
