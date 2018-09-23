<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ScheduleTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($day) : array
    {
        $lang = App::getLocale();

        return [
            'id'            => (int) $day->id,
            'date'          => $day->session_date,
            'day_name'      =>  ($lang == 'en') ? dayName($day->session_date) : translateWeekDays(dayName($day->session_date)),
            'start_time'    =>  $day->start_time,
            'end_time'      =>  $day->end_time
        ];
    }
}