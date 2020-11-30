<?php

namespace mobisoft\blog\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable
        = ['comment',
           'user_id',
           'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
