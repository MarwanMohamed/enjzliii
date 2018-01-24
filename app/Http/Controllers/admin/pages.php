<?php

namespace App\Http\Controllers\admin;

use \App\transaction;
use \App\projectBudget;
use \App\specialization;
use \App\skill;
use \App\country;
use \App\tibs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class pages extends Controller {

    function index(Request $request) {
        $pages = \App\page::paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    function edit($id) {
        $page = \App\page::find($id);
        if ($page)
            return view('admin.pages.edit', compact('page'));
        else
            abort (404);
    }
    
    function editPost(Request $request){
        $this->validate($request, [
            'id'=>'required|exists:page,id',
            'title'=>'required|min:3|max:50',
            'text'=>'required|min:3',
        ]);
        \App\page::where('id',$request->id)->update(['title'=>$request->title,'text'=>$request->text]);
        session()->flash('msg','تم تعديل الصفحة بنجاح');
        return redirect('admin/pages/index');
    }

}
