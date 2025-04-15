<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'title', 'message', 'read_at', 'actor_id'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // For the recipient
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ For the person who triggered the action
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
