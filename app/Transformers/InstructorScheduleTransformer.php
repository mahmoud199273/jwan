<?php

namespace App\Transformers;

use App\Course;
use App\Transformers\BaseTransformer as Transformer;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class InstructorScheduleTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($day) : array
    {
        $lang = App::getLocale();
        $instructor =  User::find($day->instructor_id);
        $course     =  Course::find($day->course_id);
        return [
            'id'            => (int) $day->id,
            'instructor'    =>  ['id' =>  $instructor->id , 'name' => $instructor->name ,
                                'profession'=> $instructor->profession ,'image' => config('app.url').$instructor->instructor_image ],
            'course'        =>  ['id' => $course->id , 'name' => $course->name , 
                                    'description'=> $course->description ,'image' => config('app.url').$course->image],
            'date'          =>  Carbon::parse($day->session_date)->format('d D,M Y'),
            'start_time'    => $day->start_time,
            'end_time'      => $day->end_time,
        ];
    }
}