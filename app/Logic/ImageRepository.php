<?php

namespace App\Logic;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use \App\Image;
use \Storage;


class ImageRepository {

    private $full_save_path = 'app/uploads/images/';
    private $save_path = 'uploads/images/';
//    private $icon_save_path = 'uploads/images/icon_size/';

    public function uploadBase64( Request $form_data ) {
//       dd($form_data->all());
        $data_array = $form_data['file'];
        $u_token = $form_data['u_token'];
        $user = \App\User::where('u_token', $u_token)->first();
        $images_array = '';
        if(is_array($form_data['file'])){
            foreach($data_array as $data){
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                $extension = str_replace('data:image/', '', $type);
                $filename = 'image_'.time().mt_rand();
//        $filename = $photo->getClientOriginalName();
                $allowed_filename = $filename . '.' . $extension;
//        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
                $uploadSuccess = \Storage::disk('local')->put('uploads/advertisements/'.$allowed_filename, $data);
                if( !$uploadSuccess ) {
                    $result['status'] = 'false';
                    $result['token_status'] = 'true';
                    $result['message'] = 'حدث خطأ اثناء الرفع.';
                    return $result;
                }
                $userImage = new \App\UserImage;
                $userImage->filename = $allowed_filename;
                if($user != null){
                    $userImage->user_id = $user->id;
                }

                $userImage->save();
                $images_array .= $allowed_filename . ',';
            }
            $result['status'] = 'true';
            $result['token_status'] = 'true';
            $result['message'] = 'تم رفع الصور.';
            $result['image_id'] = $images_array;
            return $result;
        }else{
            $data = $form_data['file'];
            $u_token = $form_data['u_token'];
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            $extension = str_replace('data:image/', '', $type);
            $filename = 'image_'.time().mt_rand();
//        $filename = $photo->getClientOriginalName();
            $allowed_filename = $filename . '.' . $extension;
//        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
            $uploadSuccess = \Storage::disk('local')->put('uploads/advertisements/'.$allowed_filename, $data);
            if( !$uploadSuccess ) {
                $result['status'] = 'false';
                $result['token_status'] = 'true';
                $result['message'] = 'حدث خطأ اثناء الرفع.';
                return $result;
            }
            $user = \App\User::where('u_token', $u_token)->first();
            $userImage = new \App\UserImage;
            $userImage->filename = $allowed_filename;
            if($user != null){
                $userImage->user_id = $user->id;
            }

            $userImage->save();
            $result['status'] = 'true';
            $result['token_status'] = 'true';
            $result['message'] = 'تم رفع الصورة.';
            $result['image_id'] = $allowed_filename;
            return $result;
        }
    }

    public function uploadBase64user( $form_data ) {
        $data = $form_data['file'];
        $u_token = $form_data['token'];
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        $extension = str_replace('data:image/', '', $type);
        $filename = 'image_'.time().mt_rand();
//        $filename = $photo->getClientOriginalName();
        $allowed_filename = $filename . '.' . $extension;
//        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
        $uploadSuccess = \Storage::disk('local')->put('uploads/images/'.$allowed_filename, $data);
        if( !$uploadSuccess ) {
            $result['status'] = 'false';
            $result['token_status'] = 'true';
            $result['msg'] = trans('lang.uploadError');
            return $result;
        }
        $result['status'] = 'true';
        $result['token_status'] = 'true';
        $result['msg'] = trans('lang.uploadSuccess');
        $result['image_id'] = $allowed_filename;
        return $result;
    }


    public function uploadFE($form_data){

        $photo = $form_data['file'];

        $extension = $photo->getClientOriginalExtension();
        $filename = 'image_'.time().mt_rand();
        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
        $uploadSuccess1 = $this->original( $photo, $allowed_filename );
        if( !$uploadSuccess1 ) {
            return [
                'status' => 0,
                'msg' => 'Server errors while uploading',
            ];
        }

        return [
            'status'  => 1,
            'filename' => $allowed_filename
        ];
    }



    public function uploadImage($form_data,$filename='file'){

        $photo = $form_data[$filename];

        $extension = $photo->getClientOriginalExtension();
        $filename = 'image_'.time().mt_rand();
        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
        $uploadSuccess1 = $this->original( $photo, $allowed_filename );
        if( !$uploadSuccess1 ) {
            return [
                'status' => 0,
                'msg' => 'Server errors while uploading',
            ];
        }

        return [
            'status'  => 1,
            'filename' => $allowed_filename
        ];
    }



    public function uploadIV($form_data){
        $validator = Validator::make($form_data, \App\Image::$rules,  \App\Image::$messages);

        if ($validator->fails()) {

            return Response::json([
                'errors' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);

        }

        $photo = $form_data['file'];
        $prev_img = $form_data['prev_image'];

        $extension = $photo->getClientOriginalExtension();
        $filename = 'image_'.time().mt_rand();
        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
        $uploadSuccess1 = $this->original( $photo, $allowed_filename );
        if( !$uploadSuccess1 ) {
            return Response::json([
                'errors' => true,
                'message' => 'Server errors while uploading',
                'code' => 500
            ], 500);
        }
        $sessionImage = new Image;
        $sessionImage->filename = $allowed_filename;
        $sessionImage->visible = 0;
        $sessionImage->save();

        if((!empty($prev_img)) && ($prev_img != 'avatar.png')){
            $this->delete($prev_img);
        }

        return Response::json([
            'errors' => false,
            'code'  => 200,
            'filename' => $allowed_filename
        ], 200);
    }

    public function upload_user( $form_data ) {

        $validator = Validator::make($form_data, \App\UserImage::$rules, \App\UserImage::$messages);

        if ($validator->fails()) {

            return Response::json([
                'errors' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);

        }

        $photo = $form_data['file'];
        $extension = $photo->getClientOriginalExtension();
        $filename = 'image_'.time().mt_rand();
//        $filename = $photo->getClientOriginalName();
        $allowed_filename = $filename . '.' . $extension;
//        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
        $uploadSuccess = $this->save_user_image( $photo, $allowed_filename );
        if( !$uploadSuccess ) {
            return Response::json([
                'errors' => true,
                'message' => 'Server errors while uploading',
                'code' => 500
            ], 500);
        }
        $sessiondata = session()->get('user');
        $userImage = new \App\UserImage;
        $userImage->filename = $allowed_filename;
        if($sessiondata != null){
            $userImage->user_id = $sessiondata[1]->id;
        }
        $userImage->save();

        return Response::json([
            'errors' => false,
            'code'  => 200,
            'filename' => $allowed_filename
        ], 200);

    }

    public function upload( $form_data ) {

        $photo = $form_data['file'];
        $extension = $photo->getClientOriginalExtension();
        $filename = 'image_'.time().mt_rand();
        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
        $uploadSuccess1 = $this->original( $photo, $allowed_filename );
        if( !$uploadSuccess1 ) {
            return Response::json([
                'errors' => true,
                'message' => 'Server errors while uploading',
                'code' => 500
            ], 500);
        }
        return [
            'status' => 1,
            'filename' => $allowed_filename
        ];


    }

    public function createUniqueFilename( $filename, $extension ) {
        $path = storage_path($this->full_save_path . $filename . '.' . $extension);


        if ( File::exists( $path ) )
        {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }

        return $filename . '.' . $extension;
    }

    /**
     * Optimize Original Image
     */
    public function original( $photo, $filename ) {
        $image = $photo->storeAs($this->save_path, $filename);
        return $image;
    }

    public function save_user_image( $photo, $filename ) {
        $image = $photo->storeAs('uploads/advertisements/', $filename);
        return $image;
    }

    /**
     * Create Icon From Original
     */
    public function icon( $photo, $filename )
    {
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
            })
            ->save( $this->icon_save_path  . $filename );

        return $image;
    }

    /**
     * Delete Image From Session folder, based on server created filename
     */
    public function deleteUser( $filename ) {

        $sessionImage = \App\UserImage::where('filename', 'like', $filename)->first();


        if(empty($sessionImage))
        {
            return Response::json([
                'errors' => true,
                'filename' => $filename,
                'code'  => 400
            ], 400);

        }

        $path = storage_path('app/uploads/advertisements/' . $sessionImage->filename );

        if ( File::exists( $path ) ) {
            Storage::delete('uploads/advertisements/' . $sessionImage->filename);
        }

        if( !empty($sessionImage)) {
            $sessionImage->delete();
        }

        return Response::json([
            'errors' => false,
            'filename' => $sessionImage->filename,
            'code'  => 200
        ], 200);
    }
    
  public static function deleteImage( $filename ) {

      

        $path = storage_path('app/uploads/' . $filename );

        if ( File::exists( $path ) ) {
            Storage::delete('uploads/' . $filename);
            return true;
        }

        return false;
    }
 
    
    public function deleteImageAPI( $inputs ) {
        $filename = $inputs['image_id'];
        $user = \App\User::where('u_token', $inputs['u_token'])->first();
        if($user == null ){
          $result['status'] = 'false';
          $result['token_status'] = 'false';
          $result['message'] = 'المستخدم خارج الجلسة.';
          return $result;
        }
        $sessionImage = \App\UserImage::where('filename', 'like', $filename)->where('user_id', 'like', $user->id)->first();

        if(empty($sessionImage))
        {
            $result['status'] = 'false';
            $result['token_status'] = 'true';
            $result['message'] = 'الصورة غير موجودة';
            return $result;
        }

        $path = storage_path('app/uploads/advertisements/' . $sessionImage->filename );

        if ( File::exists( $path ) ) {
            Storage::delete('uploads/advertisements/' . $sessionImage->filename);
        }

        if( !empty($sessionImage)) {
            $sessionImage->delete();
        }

        $result['status'] = 'true';
        $result['token_status'] = 'true';
        $result['message'] = 'تم حذف الصورة.';
        return $result;
    }

    public function delete( $filename ) {

        $sessionImage =  \App\Image::where('filename', 'like', $filename)->first();


        if(empty($sessionImage))
        {
            return Response::json([
                'errors' => true,
                'filename' => $filename,
                'code'  => 400
            ], 400);

        }


        $path = storage_path($this->full_save_path . $sessionImage->filename );

        if ( File::exists( $path ) ) {
            Storage::delete($this->save_path . $sessionImage->filename);
        }

        if( !empty($sessionImage)) {
            $sessionImage->delete();
        }

        return Response::json([
            'errors' => false,
            'filename' => $sessionImage->filename,
            'code'  => 200
        ], 200);
    }

    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}
