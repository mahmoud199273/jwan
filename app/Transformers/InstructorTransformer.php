<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class InstructorTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform( $user ) : array
    {
        $img_arr=[];
        foreach ($user->intro_images as $key => $image ) {
            $img_arr[$key]['id'] = $image->id;
            $img_arr[$key]['image'] = config('app.url').$image->image;
        }

        $video_arr=[];
        foreach ($user->intro_videos as $key => $video ) {
            $video_arr[$key]['id'] = $video->id;
            $video_arr[$key]['video'] = config('app.url').$video->video;
        }

        return [
            'id'            => (int) $user->id,
            'name'          => $user->name,
            'full_name'     => $user->full_name,
            'profession'    => $user->profession,
            'email'         => $user->instructor_email,
            'description'   => $user->description,
            'is_approved'   => (boolean) $user->is_approved,
            'image'         => ($user->instructor_image) ?config('app.url').$user->instructor_image : null,
            'intro_images'  => $img_arr, 
            'intro_videos'  => $video_arr

        ];
    }
}