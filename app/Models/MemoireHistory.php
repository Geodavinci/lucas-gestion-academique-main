<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoireHistory extends Model
{
    protected $table = 'memoire_history';

    protected $fillable = [
        'memoire_id',
        'user_id',
        'action',
        'old_status',
        'new_status',
        'notes',
    ];

    public function memoire()
    {
        return $this->belongsTo(Memoire::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
