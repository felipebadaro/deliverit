<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB as DB;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'run_id',
        'runner_id',
        'begin_at',
        'end_at',
    ];

    public $timestamps = false;


    /**
     * Results by a given run
     * @param  int $run_id
     * @return array
     */
    public static function generalResult($run_id){

        $results = DB::select('SELECT
            rn.type,
            ru.name,
            @rownum := @rownum + 1 as position,
            YEAR(CURRENT_TIMESTAMP) - YEAR(ru.birth_date) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(ru.birth_date, 5)) as age,
            TIMEDIFF(re.end_at, re.begin_at) as time
            FROM results re
            inner join runs rn
            on re.run_id = rn.id
            inner join runners ru
            on re.runner_id = ru.id
            cross join (select @rownum := 0) c
            where re.run_id = :run_id
            order by TIMEDIFF(re.end_at, re.begin_at)', ['run_id' => $run_id]);

        return $results;
    }


    /**
     * All results for a given run per age range
     * @param  int $run_id
     * @return array
     */
    public static function perAgeResult($run_id){

        $results['18 – 25 age'] = Result::getPerAgeResult($run_id, 18, 25);
        $results['25 – 35 age'] = Result::getPerAgeResult($run_id, 25, 35);
        $results['35 – 45 age'] = Result::getPerAgeResult($run_id, 35, 45);
        $results['45 – 55 age'] = Result::getPerAgeResult($run_id, 45, 55);
        $results['above 55 age'] = Result::getPerAgeResult($run_id, 55, 200);

        return $results;
    }


    /**
     * Result by an age range
     * @param  int $run_id
     * @param  int $beginAge
     * @param  int $endAge
     * @return array
     */
    public static function getPerAgeResult($run_id, $beginAge, $endAge){
        $results = DB::select('SELECT
            rn.type,
            ru.name,
            @rownum := @rownum + 1 as position,
            YEAR(CURRENT_TIMESTAMP) - YEAR(ru.birth_date) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(ru.birth_date, 5)) as age,
            TIMEDIFF(re.end_at, re.begin_at) as time
            FROM results re
            inner join runs rn
            on re.run_id = rn.id
            inner join runners ru
            on re.runner_id = ru.id
            cross join (select @rownum := 0) c
            where re.run_id = :run_id and YEAR(CURRENT_TIMESTAMP) - YEAR(ru.birth_date) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(ru.birth_date, 5)) >= :beginAge and YEAR(CURRENT_TIMESTAMP) - YEAR(ru.birth_date) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(ru.birth_date, 5)) < :endAge
            order by TIMEDIFF(re.end_at, re.begin_at)', ['run_id' => $run_id, 'beginAge' => $beginAge, 'endAge' => $endAge]);

        return $results;
    }
}
