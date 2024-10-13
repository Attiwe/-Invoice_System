<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.section', compact('sections'));
    }

    /**
     
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'section_name' => 'required|unique:sections,section_name',
            'description' => 'nullable',
        ], [
            'section_name.required' => 'يرجى إدخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقًا',
        ]);

        $data['created_by'] = Auth::user()->name;

        Section::create($data);

        session()->flash('Add', 'تم إضافة القسم بنجاح');

        return redirect()->route('page.section');

    }




    public function update(Request $request)
    {

        $Products = Section::query()->findOrFail(id: $request->id);

        $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,',
            'description' => 'required',
        ], [
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
        ]);

        $Products->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit', 'تم تعديل القسم بنجاح');
        return redirect()->route('page.section');
    }

    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        Section::query()->findOrFail($request->id)->delete();
        return redirect()->route('page.section');

    }
}
