<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('report.invoice_report' );

    }

   


    public function sarch_invoices(Request $request)
{
    $rdio = $request->rdio;

    try {
         if ($rdio == 1) {
             if($request->type=='الكل' ){
                  $invioce = Invoice::query()->with('section')->get();
                  $type = $request->type;
                   return view('report.invoice_report',compact('invioce','type') );
    
            }
             if ($request->type && $request->start_at == '' && $request->end_at == '') {
                $invioce = Invoice::query()->where('status', $request->type)->get();
                $type = $request->type;
                 return view('report.invoice_report', compact('type', 'invioce'));
            } 
 
            else { 
                $start_at = Carbon::parse($request->start_at)->startOfDay();
                $end_at = Carbon::parse($request->end_at)->endOfDay(); 
                $type = $request->type;
                $invioce = Invoice::query()
                    ->whereBetween('invoice_Date', [$start_at, $end_at])
                    ->where('status', $request->type) 
                    ->get();
                 return view('report.invoice_report', compact('start_at', 'end_at', 'type', 'invioce'));
            }
        } else {   
            $invioce = Invoice::query()->where('invoice_number', $request->invoice_number)->get();
            if (!isset($invioce)) {
                return redirect()->back()->withErrors(['error' => 'الفاتورة التي تبحث عنها غير موجودة']);
            }
            return view('report.invoice_report', compact('invioce'));
        }
     } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => 'حدث خطأ أثناء البحث عن الفواتير: ' . $e->getMessage()]);    }
     
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
