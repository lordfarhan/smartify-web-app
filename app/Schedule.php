<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
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

    public function course() {
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
}
