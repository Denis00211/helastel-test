<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    public function getTable(): string
    {
        return 'user_info';
    }

    protected $fillable = [
        'user_id', 'name', 'surname', 'patronymic', 'email', 'phone'
    ];
}
