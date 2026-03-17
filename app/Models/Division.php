<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable =[
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}
