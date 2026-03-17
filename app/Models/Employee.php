<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable =[
        'position_id',
        'name',
        'salary',
        'nip',
        'address',
        'phone',
        'email',
        'join_date',
        'profile_picture',
    ];

    protected $casts = [
        'join_date' => 'date',
        'salary' => 'decimal:2',
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
