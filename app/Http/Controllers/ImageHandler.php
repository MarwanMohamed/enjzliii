<?php

namespace App\Http\Controllers;

use App\Logic\FileRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Validator;

class ImageHandler extends Controller {





    function uploadFile(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        }else {
            $file = new FileRepository();
            $json = $file->upload($request);
        }
        return response()->json($json);
    }

    function download($id){
        //PDF file is stored under project/public/download/info.pdf
       $file=\App\file::find($id);
        if($file->type=='file'){
            $path= storage_path('app/uploads/files/'.$file->name);
        }else{
            $path = storage_path('app/uploads/images/'.$file->name);
        }
        
          if (!\Illuminate\Support\Facades\File::exists($path))
			{
                            session()->flash('error','هذا الملف غير موجود');
			    return redirect()->back();
			}

        $headers = array(
            'Content-Type:'.$file->mime,
        );

        return Response::download($path, $file->name, $headers);
    }




    public function getPublicImage($size, $id){
        $path = storage_path('app/uploads/images/'.$id);

        if(!File::exists($path))
            $path = storage_path('app/uploads/images/default_image.jpg');

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $sizes = explode("x", $size);

        if(is_numeric($sizes[0]) && is_numeric($sizes[1])){

            $manager = new ImageManager();
            $image = $manager->make( $file )->fit($sizes[0], $sizes[1], function ($constraint) {
                $constraint->upsize();
            });
            $response = Response::make($image->encode($image->mime), 200);

            $response->header("CF-Cache-Status", 'HIF');
            $response->header("Cache-Control", 'max-age=604800, public');
//            $response->header("Content-Encoding", 'gzip');
            $response->header("Content-Type", $type);
//            $response->header("Vary", 'Accept-Encoding');

            return $response;

        }else { abort(404); }
    }

    public function getImageResize($size, $id){
        $path = storage_path('app/uploads/images/'.$id);

        if(!File::exists($path))
          $path = storage_path('app/uploads/images/default_image.jpg');

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        if(is_numeric($size)){

            $manager = new ImageManager();
            $image = $manager->make( $file );
            $height = $image->height();
            $width = $image->width();
          if($width > $height){
            $new_height = (($height * $size)/$width);
            $image = $image->resize($size, $new_height, function ($constraint) {
                $constraint->upsize();
            });

          }else{
            $new_width = (($width * $size)/$height);
            $image = $image->resize($new_width, $size, function ($constraint) {
                $constraint->upsize();
            });
          }

            $response = Response::make($image->encode($image->mime), 200);

            $response->header("CF-Cache-Status", 'HIF');
            $response->header("Cache-Control", 'max-age=604800, public');
            $response->header("Content-Type", $type);

            return $response;

        }else { abort(404); }
    }

    public function getDefaultImage($id){
        $path = storage_path('app/uploads/images/'.$id);

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $manager = new ImageManager();
        $image = $manager->make( $file );
        $response = Response::make($image->encode($image->mime), 200);
        $response->header("CF-Cache-Status", 'HIF');
        $response->header("Cache-Control", 'max-age=604800, public');
//            $response->header("Content-Encoding", 'gzip');
        $response->header("Content-Type", $type);
//            $response->header("Vary", 'Accept-Encoding');

        return $response;

    }
}
