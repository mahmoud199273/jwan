<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlayerId extends Model
{
    protected $table = 'user_player_ids';

    protected $fillable = ['user_id', 'player_id'];
}
