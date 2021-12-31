<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Teamwork\Traits\UsedByTeams;

class Task extends Model
{
    use UsedByTeams;

    protected $fillable = ['user_id', 'team_id', 'name'];
}
