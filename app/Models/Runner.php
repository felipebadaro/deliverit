<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
    ];

    public $timestamps = false;

    public function runs()
    {
        return $this->belongsToMany(Run::class, 'subscriptions');
    }

    public static function isUnderAge($birth_date)
    {
        $createDate = new \DateTime($birth_date);
        $strip = $createDate->format('Y-m-d');
        $now = new \DateTime();
        $difference = $now->diff($createDate, true)->y;

        if($difference < 18){
            return true;
        }

        return false;
    }

}
