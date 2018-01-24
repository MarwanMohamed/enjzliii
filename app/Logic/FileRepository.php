<?php

namespace App\Logic;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use App\Ufile;
use \Storage;

class FileRepository {
    
    private $file_save_path = 'uploads/files/';
    private $video_save_path = 'uploads/videos/';
    private $file_full_path = 'app/uploads/files/';
    private $video_full_path = 'app/uploads/videos/';
    private $image_save_path = 'uploads/images/';
    private $image_full_path = 'app/uploads/images/';

    public function upload( $form_data,$id=0,$type=0) {

        $validator = Validator::make($form_data->all(), [
            'file'=>'Required|file|mimetypes:application/pdf,image/*,application/msword'
        ]);

        if ($validator->fails()) {

            $json=[
                'msg' => $validator->messages()->first(),
                'status' => 0
            ];

        }

        $file = $form_data['file'];

        $extension = $file->getClientOriginalExtension();
        $isImage=1;
        if($extension=='doc'||$extension=='docx'||$extension=='pdf'){
                $isImage=0;
                $filename = 'file_'.time().mt_rand();
            }
            else
                $filename = 'image_'.time().mt_rand();
            if($isImage)
                $allowed_filename = $this->createUniqueFilename( $filename, $extension ,$this->image_full_path);
            else
                $allowed_filename = $this->createUniqueFilename( $filename, $extension, $this->file_full_path );
           if($isImage)
                $uploadSuccess = $this->save_image( $file, $allowed_filename );
            else
                $uploadSuccess = $this->save_file( $file, $allowed_filename );

        if( !$uploadSuccess ) {
            $json= [
                    'status'=>1
                ];
            }

            $sessionFile = new \App\file();
            $sessionFile->name      = $allowed_filename;
            $sessionFile->user_id      = session('user')['id'];
            if($extension=='doc'||$extension=='docx'||$extension=='pdf')
                $sessionFile->type     = 'file';
            else
                $sessionFile->type     = 'image';
            $sessionFile->refer_id=$id;
            $sessionFile->orginName= $file->getClientOriginalName();

            $sessionFile->referal_type=$type;
           $sessionFile->save();
            $json=[
                'data' => $file,
                'file_id' => $sessionFile->id,
                'file_name' => $allowed_filename,
                'type' =>  $sessionFile->type,
                'status' =>  1
    ];
       

        return $json;
    }



    function multiple_upload_IF($id=0,$type=0){

        $files = Input::file('file');
        $file_count = count($files);
        $uploadcount = 0;
        $filenames=array();
        foreach($files as $file) {

            $extension = $file->getClientOriginalExtension();
            $isImage = 1;
            if ($extension == 'doc' || $extension == 'docx' || $extension == 'pdf') {
                $isImage = 0;
                $filename = 'file_' . time() . mt_rand();
            } else
                $filename = 'image_' . time() . mt_rand();
            if ($isImage)
                $allowed_filename = $this->createUniqueFilename($filename, $extension, $this->image_full_path);
            else
                $allowed_filename = $this->createUniqueFilename($filename, $extension, $this->file_full_path);
            if ($isImage)
                $uploadSuccess = $this->save_image($file, $allowed_filename);
            else
                $uploadSuccess = $this->save_file($file, $allowed_filename);

            if (!$uploadSuccess) {
                $uploadcount ++;
            }

            $sessionFile = new \App\file();
            $sessionFile->name = $allowed_filename;
            $sessionFile->user_id = session('user')['id'];
            $sessionFile->refer_id = $id;
            $sessionFile->orginName= $file->getClientOriginalName();
            $sessionFile->mime= $file->getMimeType();
            $sessionFile->referal_type= $type;
            $sessionFile->user_id = session('user')['id'];
            if ($extension == 'doc' || $extension == 'docx' || $extension == 'pdf')
                $sessionFile->type = 'file';
            else
                $sessionFile->type = 'image';
            $sessionFile->save();
            $filenames[]=array($allowed_filename,$sessionFile->type,$sessionFile->id);

        }
        return $filenames;
    }


    function multiple_upload($id=0,$type=0){

        $files = Input::file('file');
        $file_count = count($files);
        $uploadcount = 0;
        $filenames=array();
        foreach($files as $file) {

            $extension = strtolower ($file->getClientOriginalExtension());
            $isImage = 1;
            if ($extension == 'doc' || $extension == 'docx' || $extension == 'pdf') {
                $isImage = 0;
              $uploadcount++;
                $filename = 'file_' . time() . mt_rand();
            }  else if($extension == 'png'||$extension == 'jpg'||$extension == 'jpeg'||$extension == 'gif'||$extension == 'jfif'){
                $filename = 'image_' . time() . mt_rand();
                $uploadcount++;
            }else{
              continue;
            }
            if ($isImage)
                $allowed_filename = $this->createUniqueFilename($filename, $extension, $this->image_full_path);
            else
                $allowed_filename = $this->createUniqueFilename($filename, $extension, $this->file_full_path);
            if ($isImage)
                $uploadSuccess = $this->save_image($file, $allowed_filename);
            else
                $uploadSuccess = $this->save_file($file, $allowed_filename);

            if (!$uploadSuccess) {
                $uploadcount ++;
            }

            $sessionFile = new \App\file();
            $sessionFile->name = $allowed_filename;
            $sessionFile->user_id = session('user')['id'];
            $sessionFile->refer_id = $id;
            $sessionFile->orginName= $file->getClientOriginalName();
            $sessionFile->mime= $file->getMimeType();
            $sessionFile->referal_type= $type;
            $sessionFile->user_id = session('user')['id'];
            if ($extension == 'doc' || $extension == 'docx' || $extension == 'pdf')
                $sessionFile->type = 'file';
            else
                $sessionFile->type = 'image';
            $sessionFile->save();
            $filenames[]=array($allowed_filename,$sessionFile->type,$sessionFile->id);

        }
        return $filenames;
    }

    public function createUniqueFilename( $filename, $extension, $path )
    {
//        $path_dir = $path;
//        $full_path = $path . $filename . '.' . $extension;
        $path = storage_path($path . $filename . '.' . $extension);
        
        if ( File::exists( $path ) )
        {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }

        return $filename . '.' . $extension;
    }

    /**
     * Optimize & Save File
     */
    public function save_file( $file, $filename )
    {
        $file_r = $file->storeAs($this->file_save_path, $filename);
//        $file_r = $file->move( 'uploads/files/' . $filename);
//        $file_r = Storage::put('uploads/files/' . $filename, file_get_contents($file->getRealPath()));

        return $file_r;
    }
  public function save_image( $file, $filename )
    {
        $file_r = $file->storeAs($this->image_save_path, $filename);
//        $file_r = $file->move( 'uploads/files/' . $filename);
//        $file_r = Storage::put('uploads/files/' . $filename, file_get_contents($file->getRealPath()));

        return $file_r;
    }

    /**
     * Optimize & Save Video
     */
    public function save_video( $video, $filename )
    {
        $video_r = $video->storeAs($this->video_save_path, $filename);

        return $video_r;
    }

    /**
     * Delete Image From Session folder, based on server created filename
     */
    public function deleteI( $filename ) {

        $file_dir = $this->image_full_path;
        $path = storage_path($file_dir . $filename );
        \App\file::where('name',$filename)->delete();
        if (File::exists( $path ) ) {
            unlink($path);
            return 1;
        }else{
            return 0;
        }

    }
    public function deleteF( $filename ) {

    $file_dir = $this->file_save_path;
    Storage::delete($file_dir . $filename);
      return 1;
    }

    function deleteMultiple($files){
        foreach ($files as $file){
            if($file->type=='file'){
                $this->deleteF($file->name);
            }else{
                $this->deleteI($file->name);
            }

        }
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