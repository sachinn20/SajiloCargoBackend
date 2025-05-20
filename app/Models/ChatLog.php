<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    //
    protected $fillable = ['user_id', 'sender', 'message'];

}
