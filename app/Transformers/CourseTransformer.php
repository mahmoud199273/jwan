<?php

namespace App\Transformers;

use App\Course;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\CategoryTransformer;
use App\Transformers\InstructorTransformer;
use App\Transformers\ScheduleTransformer;


class CourseTransformer extends Transformer
{

    protected $categoryTransformer;
    protected $instructorTransformer;
    protected $scheduleTransformer;
    protected $rateTransformer;

    function __construct( CategoryTransformer $categoryTransformer, 
                            InstructorTransformer $instructorTransformer,
                                ScheduleTransformer $scheduleTransformer, 
                                    RateTransformer $rateTransformer )
    {
        $this->categoryTransformer      = $categoryTransformer;
        $this->instructorTransformer    = $instructorTransformer;
        $this->scheduleTransformer      = $scheduleTransformer;
        $this->rateTransformer          = $rateTransformer;


    }

    public function transform($course) : array
    {
        $course = Course::find($course->id);
        return [
            'id'                        => (int) $course->id,
            'category'                  => $this->categoryTransformer->transform($course->category),
            'instructor'                => $this->instructorTransformer->transform($course->instructor),
            'name'                      => $course->name,
            'rate'                      => Course::find($course->id)->rate->sum('rate')/$course->rate->count(),
            'price'                     => $course->price/100,
            'discount'                  => $course->discount/100,
            'after_discount'            => ($course->price/100) - ($course->discount/100),
            'number_of_students'        => $course->number_of_students, 
            'number_of_hours'           => $course->number_of_hours ,
            'number_of_sessions'        => $course->number_of_sessions,
            'description'               => $course->description,
            'image'                     => config('app.url').$course->image,
            'is_certificated'           => (bool) $course->is_certificated,
            'schedule'                  => $this->scheduleTransformer->transformCollection($course->schedule),
            'rates'                     => $this->rateTransformer->transformCollection($course->rate)

        ];
    }
}