<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    const PER_PAGE = 20;

    protected $fillable = ['url', 'thumb'];
}
