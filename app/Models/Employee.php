<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable =[
        'name',
        'salary',
        'nip',
        'address',
        'phone',
        'email',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }


}
