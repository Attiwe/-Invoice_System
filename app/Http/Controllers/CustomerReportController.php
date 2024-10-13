<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
             $product = Product::all();
             $sction = Section::all();
        return view('report.customer_invoice',compact('product','sction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function serch_customer(Request $request)
    {
         if ($request->Section && $request->product && empty($request->start_at) && empty($request->end_at)) {
             $invoice = Invoice::select('*')
                ->where('section_id', $request->Section)  
                ->where('product', $request->product)
                ->get();
            
            return view('report.customer_invoice', compact('invoice'));
        }

        //ناقص كود هنا
    
     }
}    