<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GitToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'token',
    ];
}
