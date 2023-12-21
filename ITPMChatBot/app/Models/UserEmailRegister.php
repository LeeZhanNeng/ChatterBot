<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmailRegister extends Model
{
    use HasFactory;

    public $count = 0;
    protected $table = 'user_email_registers';

    protected $fillable = [
        'id',
        'user_name',
        'user_email',
        'user_type'
    ];

    public function getUserEmailRegister($id)
    {
        $userCount = UserEmailRegister::where('id', $id)->count();
        $this->count = $userCount;
        return $this->count;
    }
}
