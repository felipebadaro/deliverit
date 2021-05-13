<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'run_id',
        'runner_id',
    ];

    public $timestamps = false;


    /**
     * check if is possible another subscription, considering the date (only one run per day)
     * @param  int $run_id
     * @param  int $runner_id
     * @return boolean
     */
    public static function isPossible($run_id, $runner_id){

        $run = Run::find($run_id);
        $theDate = date('Y-m-d', strtotime($run->happened_at));

        $subscriptions = DB::select('SELECT s.* FROM subscriptions s
            inner join runs r
            on s.run_id = r.id
            where date(r.happened_at) = :happened_at and s.runner_id = :runner_id', ['happened_at' => $theDate, 'runner_id' => $runner_id]);

        if ($subscriptions) {
            return false;
        }
        else{
            return true;
        }
    }
}
