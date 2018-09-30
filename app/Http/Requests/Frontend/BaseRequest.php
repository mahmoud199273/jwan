<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

Abstract class BaseRequest extends FormRequest
{

    public function uploadImage( $image )
    {
        $imagePath = "";      
        $image_name = time().time().'_'.uniqid().".".$image->getClientOriginalExtension();  
        $imageDir   = base_path() .'/public/assets/images';
        $upload_img = $image->move($imageDir,$image_name); 
        $imagePath  = '/public/assets/images/'.$image_name;

        return $imagePath;   
    }
   
}