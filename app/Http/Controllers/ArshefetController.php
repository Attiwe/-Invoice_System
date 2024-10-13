<?php

namespace App\Http\Controllers;

use App\Models\Arshefet;
use App\Models\Invoice;
use Illuminate\Http\Request;
use View;

class ArshefetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $invoices = Invoice::onlyTrashed()->get();
       return View('invoices.arshef_invoice',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Arshefet $arshefet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arshefet $arshefet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        // return  $request->id;
         
        try {
             Invoice::withTrashed()->where('id', $id)->restore();
            
             return redirect()->route('page.invoice')->with('success', 'Invoice restored successfully.');
        } catch (\Exception $e) {
             return redirect()->route('page.invoice')->with('error', 'An error occurred while restoring the invoice.');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request )
    {
        // return $request->id;
        Invoice::query()->where('id',$request->id)->forceDelete();
        return back();
        
    }
}
