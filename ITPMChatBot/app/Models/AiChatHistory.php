<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiChatHistory extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'message', 'chat_id', 'chat_title', 'source'];
}
