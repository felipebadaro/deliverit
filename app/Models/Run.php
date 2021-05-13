<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'happened_at',
    ];

    public $timestamps = false;

    public function runners()
    {
        return $this->belongsToMany(Runner::class, 'subscriptions');
    }

}
