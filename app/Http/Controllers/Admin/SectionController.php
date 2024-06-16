<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Section;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    private function getSections()
    {
        return Section::paginate(10);
    }

    public function index()
    {
        $sections = $this->getSections();
        return view('admin.section.index', compact('sections'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name|max:255',
            'guard_name' => 'nullable'
        ]);
        $section = new Section();
        $section->fill($validated)->save();

        Session::flash('message', 'Section Created Successfully!');
        return redirect()->back();
    }

    public function edit(Section $section)
    {
        $sections = $this->getSections();
        return view('admin.section.index', compact('section', 'sections'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $section->id,
        ]);

        $section->fill($validated)->save();
        Session::flash('message', 'Section Updated Successfully!');
        return redirect()->route('sections.index');
    }

    public function destroy(Section $department)
    {
        $department->delete();
        Session::flash('message', 'Section Deleted Successfully!');
        return redirect()->back();
    }
}
