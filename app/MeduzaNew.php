<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeduzaNew extends Model
{
    //
    protected $fillable = [
        'id', 'date', 'title', 'url', 'image', 'document_type', 'json'
    ];

    public $incrementing = false;

    protected $casts = [
        'json' => 'array'
    ];
}
