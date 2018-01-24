<?php

namespace App\Http\Controllers\admin;

use \App\transaction;
use \App\projectBudget;
use \App\specialization;
use \App\skill;
use \App\country;
use \App\tibs;
use App\FAQ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class constants extends Controller {

    function budget() {
        $projectBudgets = projectBudget::latest()->paginate(10);
        return view('admin.constant.budget', compact('projectBudgets'));
    }

    function deleteBudget(Request $request) {
        projectBudget::where('id', $request->id)->delete();
        session()->flash('msg', 'تم حذف العنصر');
        return redirect(url()->previous());
    }

    function addBudget(Request $request) {
        $this->validate($request, [
            'min' => 'required|integer|min:0|max:' . $request->max,
            'max' => 'required|integer|min:' . $request->min
        ]);

        $projectBudget = new projectBudget();
        $projectBudget->min = $request->min;
        $projectBudget->max = $request->max;
        $projectBudget->save();
        session()->flash('msg', 'تمت الاضافة بنجاح');
        return redirect(url()->previous());
    }

    function editBudgetPost(Request $request) {
        $this->validate($request, [
            'id' => 'required|exists:projectbudget,id',
            'min' => 'required|integer|min:0|max:' . $request->max,
            'max' => 'required|integer|min:' . $request->min
        ]);

        $projectBudget = projectBudget::find($request->id);
        $projectBudget->min = $request->min;
        $projectBudget->max = $request->max;
        $projectBudget->save();
        session()->flash('msg', 'تم التعديل بنجاح');
        return redirect(url()->previous());
    }

    function editBudget($id) {
        $json['status'] = 1;
        $json['budget'] = projectBudget::find($id);
        return response()->json($json);
    }

    function faq() {
        $FAQs = FAQ::latest()->paginate(10);
        return view('admin.constant.FAQ', compact('FAQs'));
    }

    function deletefaq(Request $request) {
        FAQ::where('id', $request->id)->delete();
        session()->flash('msg', 'تم حذف العنصر');
        return redirect(url()->previous());
    }

    function addfaq(Request $request) {
        $this->validate($request, [
            'question' => 'required|min:5|max:5000',
            'answer' => 'required|min:5|max:5000'
        ]);

        $FAQ = new FAQ();
        $FAQ->question = $request->question;
        $FAQ->answer = $request->answer;
        $FAQ->isVIP = isset($request->isVIP);
        $FAQ->save();
        session()->flash('msg', 'تمت الاضافة بنجاح');
        return redirect(url()->previous());
    }

    function editfaqPost(Request $request) {
        $this->validate($request, [
            'id' => 'required|exists:faq,id',
            'question' => 'required|min:5|max:5000',
            'answer' => 'required|min:5|max:5000'
        ]);
        $FAQ = FAQ::find($request->id);
        $FAQ->question = $request->question;
        $FAQ->answer = $request->answer;
        $FAQ->isVIP = isset($request->isVIP);

        $FAQ->save();
        session()->flash('msg', 'تم التعديل بنجاح');
        return redirect(url()->previous());
    }

    function editfaq($id) {
        $json['status'] = 1;
        $json['FAQ'] = FAQ::find($id);
        return response()->json($json);
    }

    function specialization(Request $request) {
        $q = $request->q ? $request->q : '';
        $specializations = specialization::where('name', 'like', '%' . $q . '%')->latest()->paginate(10);
        return view('admin.constant.specialization', compact('specializations', 'q'));
    }

    function deleteSpec(Request $request) {
        specialization::where('id', $request->id)->delete();
        session()->flash('msg', 'تم حذف العنصر');
        return redirect(url()->previous());
    }

    function addSpec(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:3|max:50|unique:specialization,name'
        ]);

        $specialization = new specialization();
        $specialization->name = $request->name;
        $specialization->save();
        if (!$request->ajax()) {
            session()->flash('msg', 'تمت الاضافة بنجاح');
            return redirect(url()->previous());
        } else {
            $json['status'] = 1;
            $json['msg'] = 'تمت الإضافة بنجاح';
            return response()->json($json);
        }
    }

    function editSpecPost(Request $request) {
        $this->validate($request, [
            'id' => 'required|exists:specialization,id',
            'name' => 'required|min:5|max:50'
        ]);

        $specialization = specialization::find($request->id);
        $specialization->name = $request->name;
        $specialization->save();
        if ($request->ajax()) {
            $json['status'] = 2;
            $json['msg'] = 'تم التعديل بنجاح';
            session()->flash('msg', 'تم التعديل بنجاح');

            return response()->json($json);
        } else {
            session()->flash('msg', 'تم التعديل بنجاح');

            return redirect(url()->previous());
        }
    }

    function editSpec($id) {
        $json['status'] = 1;
        $json['specialization'] = specialization::find($id);
        return response()->json($json);
    }
  
      function editSkill($id) {
        $json['status'] = 1;
        $json['skill'] = skill::find($id);
        return response()->json($json);
    }


    function skills(Request $request) {
        $q = $request->q ? $request->q : '';
        $specializations = specialization::get()->pluck('name','id');
        $skills = skill::with('specialization')->where('name', 'like', '%' . $q . '%')->orderBy('ordering')->paginate(10);
        return view('admin.constant.skills', compact('specializations','skills', 'q'));
    }

    function deleteSkill(Request $request) {
        skill::where('id', $request->id)->delete();
        session()->flash('msg', 'تم حذف العنصر');
        return redirect(url()->previous());
    }

    function addSkill(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:skill,name',
            'ordering' => 'required|integer',
            'specialization_id' => 'required'
        ]);

        $skill = new skill();
        $skill->name = $request->name;
        $skill->ordering = $request->ordering;
        
        $skill->specialization_id = $request->specialization_id;
        $skill->save();
        if (!$request->ajax()) {
            session()->flash('msg', 'تمت الاضافة بنجاح');
            return redirect(url()->previous());
        } else {
            $json['status'] = 1;
            $json['msg'] = 'تمت الإضافة بنجاح';
            return response()->json($json);
        }
    }

    function editSkillPost(Request $request) {
        $this->validate($request, [
            'id' => 'required|exists:skill,id',
            'name' => 'required|unique:skill,name,' . $request->id,
            'ordering' => 'required|integer',
            'specialization_id' => 'required'
        ]);

        $skill = skill::find($request->id);
        $skill->name = $request->name;
        $skill->ordering = $request->ordering;
        $skill->specialization_id = $request->specialization_id;
        $skill->save();
        if ($request->ajax()) {
            $json['status'] = 2;
            $json['msg'] = 'تم التعديل بنجاح';
            session()->flash('msg', 'تم التعديل بنجاح');

            return response()->json($json);
        } else {
            session()->flash('msg', 'تم التعديل بنجاح');

            return redirect(url()->previous());
        }
    }

    function tibs(Request $request) {
        $q = $request->q ? $request->q : '';
        $type = $request->type ? $request->type : 0;
        $tibs = tibs::where('value', 'like', '%' . $q . '%');
        if ($type) {
            $tibs->where('type', $type);
        }
        $tibs = $tibs->latest()->paginate(10);
        return view('admin.constant.tibs', compact('tibs', 'q', 'type'));
    }

    function deleteTib(Request $request) {
        tibs::where('id', $request->id)->delete();
        session()->flash('msg', 'تم حذف العنصر');
        return redirect(url()->previous());
    }

    function addTib(Request $request) {
        $this->validate($request, [
            'value' => 'required|min:3|max:500|unique:tibs,value',
            'type' => 'required'
        ]);

        $tibs = new tibs ();
        $tibs->value = $request->value;
        $tibs->type = $request->type;
        $tibs->save();
        if (!$request->ajax()) {
            session()->flash('msg', 'تمت الاضافة بنجاح');
            return redirect(url()->previous());
        } else {
            $json['status'] = 1;
            $json['msg'] = 'تمت الإضافة بنجاح';
            return response()->json($json);
        }
    }

    function editTibPost(Request $request) {
        $this->validate($request, [
            'id' => 'required|exists:tibs,id',
            'type' => 'required|min:5|max:500',
            'type' => 'required|integer'
        ]);

        $tib = tibs::find($request->id);
        $tib->value = $request->value;
        $tib->type = $request->type;
        $tib->save();
        if ($request->ajax()) {
            $json['status'] = 2;
            $json['msg'] = 'تم التعديل بنجاح';
            session()->flash('msg', 'تم التعديل بنجاح');

            return response()->json($json);
        } else {
            session()->flash('msg', 'تم التعديل بنجاح');

            return redirect(url()->previous());
        }
    }

    function editTib($id) {
        $json['status'] = 1;
        $json['tib'] = tibs::find($id);
        return response()->json($json);
    }

    function countries(Request $request) {
        $q = $request->q ? $request->q : '';
        $countries = country::where('name', 'like', '%' . $q . '%')->latest()->paginate(10);
        return view('admin.constant.countries', compact('countries', 'q'));
    }

    function deleteCountry(Request $request) {
        specialization::where('id', $request->id)->delete();
        session()->flash('msg', 'تم حذف العنصر');
        return redirect(url()->previous());
    }

    function addCountry(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'code' => 'required|min:2|max:50|unique:country,code',
            'zipCode' => 'required|integer'
        ]);

        $country = new country();
        $country->name = $request->name;
        $country->code = $request->code;
        $country->zipCode = $request->zipCode;
        $country->save();
        if (!$request->ajax()) {
            session()->flash('msg', 'تمت الاضافة بنجاح');
            return redirect(url()->previous());
        } else {
            $json['status'] = 1;
            $json['msg'] = 'تمت الإضافة بنجاح';
            return response()->json($json);
        }
    }

    function editCountryPost(Request $request) {
        $this->validate($request, [
            'id' => 'required|exists:country,id',
            'name' => 'required|min:3|max:50',
            'code' => 'required|max:50|unique:country,code,' . $request->id,
            'zipCode' => 'required|integer'
        ]);

        $country = country::find($request->id);
        $country->name = $request->name;
        $country->code = $request->code;
        $country->zipCode = $request->zipCode;
        $country->save();
        if ($request->ajax()) {
            $json['status'] = 2;
            $json['msg'] = 'تم التعديل بنجاح';
            session()->flash('msg', 'تم التعديل بنجاح');

            return response()->json($json);
        } else {
            session()->flash('msg', 'تم التعديل بنجاح');

            return redirect(url()->previous());
        }
    }

    function editCountry($id) {
        $json['status'] = 1;
        $json['country'] = country::find($id);
        return response()->json($json);
    }

}
