<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();

        return view('products.product', compact('sections', 'products'));
    }
 
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'product_name' => 'required',
                'section_id' => 'required',
                'description' => 'nullable',
            ], [
                'product_name.required' => 'يرجى إدخال اسم المنتج',
                'section_id.required' => 'يرجى إدخال اسم القسم',
            ]);

            Product::create(attributes: $validated);
            session()->flash('Add', 'تم إضافة القسم بنجاح');
            return redirect()->route(route: 'page.porduct');
        } catch (\Throwable $th) {
            return view('emty.emty');
        }
    }



    public function show()
    {
    }

    public function update(Request $request)
    {

        try {
            $id = Section::where('section_name', $request->section_name)->first()->id;

            $Products = Product::findOrFail($request->pro_id);

            $Products->update([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'section_id' => $id,
            ]);

            session()->flash('Edit', 'تم تعديل المنتج بنجاح');
            return redirect()->route('page.porduct');

        } catch (\Throwable $th) {
            return view('emty.emty');
        }


    }

    public function destroy(Request $request)
    {
        Product::query()->findOrFail($request->pro_id)->delete();
        return redirect()->route('page.porduct');

    }

}
