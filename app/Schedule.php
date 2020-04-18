<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    const WEEK_DAYS = [
        '0' => 'Ahad',
        '1' => 'Senin',
        '2' => 'Selasa',
        '3' => 'Rabo',
        '4' => 'Kamis',
        '5' => 'Jumat',
        '6' => 'Sabtu',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day', 'start_time', 'end_time'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    function course() {
        return $this->belongsTo(Course::class);
    }

    public function getDay() {
        switch($this->day) {
            case '0':
                return 'Ahad';
            break;
            case '1':
                return 'Senin';
            break;
            case '2':
                return 'Selasa';
            break;
            case '3':
                return 'Rabo';
            break;
            case '4':
                return 'Kamis';
            break;
            case '5':
                return 'Jumat';
            break;
            case '6':
                return 'Sabtu';
            break;
            default:
            return 'Ahad';
        }
    }

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->end_time)->diffInMinutes($this->start_time);
    }
}
