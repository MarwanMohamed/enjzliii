<?php

namespace App\Http\Controllers\admin;

use App\conversation;
use \App\message;
use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class files extends Controller {
    
    protected $types = [
        'proposal' => 'اضافه عرض',
        'project' => 'اضافه مشروع',
        'message' => 'اضافه رساله',
        'discussion' => 'اضافه نقاش',
        'portfolio' => 'اضافه عمل',
    ];

    function index() {
        return view('admin.files.index');
    }
    
    protected function searchForType($term){
        return array_filter($this->types, function($var) use ($term) { return preg_match("/\b$term\b/iu", $var); });
    }

    function types(Request $request) {
        $q = $request->q ? $request->q : '';
        $filetypes = \App\fileType::where('mime', 'like', '%' . $q . '%')
        ->orWhere('extension', 'like', '%' . $q . '%');
        
        $matches = $this->searchForType($q);
        
        foreach($matches as $key => $value){
            $filetypes->orWhere('type', 'like', '%' . $key . '%');
        }
        
        $filetypes = $filetypes->orderBy('type')->paginate(10);
        
        $types = $this->types;
        
        return view('admin.files.type', compact('filetypes', 'q', 'types'));
    }

    function editType($id) {
        $json['status'] = 1;
        $json['fileType'] = \App\fileType::find($id);
        return response()->json($json);
    }
    
    
    function deleteType(Request $request) {
        \App\fileType::where('id', $request->id)->delete();
        session()->flash('msg', 'تم حذف العتصر');
        return redirect(url()->previous());
    }

    function editTypePost(Request $request) {
        $this->validate($request, [
            'id' => 'required|exists:filetype',
            'mime' => 'required',
            'type' => 'required|array',
            'extension' => 'required'
        ]);

        $filetype =  \App\fileType::find($request->id);
        $filetype->mime = $request->mime;
        $filetype->extension = $request->extension;
        $filetype->type = json_encode($request->type);
        $filetype->save();
        if (!$request->ajax()) {
            session()->flash('msg', 'تمت الاضافة بنجاح');
            return redirect(url()->previous());
        } else {
            $json['status'] = 2;
            session()->flash('msg', 'تمت الاضافة بنجاح');
            return response()->json($json);
        }
    }

    function edit($type = 0, Request $request) {
        global $setting;
        $typeId = $type ? $type : $request->type;
        switch ($typeId) {
            case 1:
                $type_name = 'اضافة مشروع';
                $acceptFilesId = 'addProjectFiles';
                break;
            case 2:
                $type_name = 'الملفات المرفقة في اضافة عمل';
                $acceptFilesId = 'attachAddPort';
                break;

            case 3:
                $type_name = 'الصورة المصغرة في اضافة عمل';
                $acceptFilesId = 'avatarAddPort';
                break;
            case 4:
                $type_name = 'اضافة عرض';
                $acceptFilesId = 'addBid';
                break;
            case 5:
                $type_name = 'اضافة نقاش';
                $acceptFilesId = 'addDesc';
                break;
            case 6:
                $type_name = 'ارسال رسالة';
                $acceptFilesId = 'sendMesg';
                break;
        }

        if ($type) {
            $acceptFiles = isset($setting[$acceptFilesId]) ? $setting[$acceptFilesId] : '';
            $filetypes = \App\fileType::get();
            return view('admin.files.edit', compact('type', 'type_name', 'filetypes', 'acceptFiles'));
        } else {
            $filetypes = \App\fileType::whereIn('id', $request->file)->get()->toArray();
            $acceptArr = [];
            foreach ($filetypes as $filetype) {
                $acceptArr[] = $filetype['mime'] . '/' . $filetype['extension'];
            }
            $text = implode(',', $acceptArr);
            \App\setting::add($acceptFilesId, $text);
            return redirect('/admin/files/index');
        }
    }

    function add(Request $request) {
        $this->validate($request, [
            'mime' => 'required',
            'type' => 'required|array',
            'extension' => 'required'
        ]);

        $filetype = new \App\fileType();
        $filetype->mime = $request->mime;
        $filetype->type = json_encode($request->type);
        $filetype->extension = $request->extension;
        $filetype->save();
        if (!$request->ajax()) {
            session()->flash('msg', 'تمت الاضافة بنجاح');
            return redirect(url()->previous());
        } else {
            $json['status'] = 2;
            session()->flash('msg', 'تمت الاضافة بنجاح');
            return response()->json($json);
        }
    }

}
