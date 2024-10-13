<?php

namespace App\Http\Controllers;

use App\Models\Invoic_attachments;
use Auth;
 use DB;
use Illuminate\Http\Request;
use Storage;

class InvoicAttachmentsController extends Controller
{

    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            
             $imag = $request->file('file_name');
            $file_name = $imag->getClientOriginalName();
            $invoice_number = $request->invoice_number;
    
             $invoice_id = $request->invoice_id;  
    
             $attachments = new Invoic_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->invoice_id = $invoice_id;
            $attachments->Created_by = Auth::user()->name;
            $attachments->save();
    
             $imag->move(public_path('attachments/' . $invoice_number), $file_name);
    
            DB::commit();
    
            return back()->with('success', 'تم حفظ المرفق بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'حدث خطأ أثناء حفظ المرفق: ' . $e->getMessage()]);
        }
    }
    
  
   
    public function destroy(Request $request)
    {
        try {
            Invoic_attachments::query()->findOrFail($request->id_file)->delete();
           Storage::disk('public_uploads_file')->delete($request->invoice_number.'/'.$request->file_name);
        return back();
         } catch (\Throwable $th) {
           return view('emty.emty');
        }
          
    }

    public function open_file($invoice_number , $file_name){
      
        $file = Storage::disk('public_uploads_file')->path($invoice_number . '/' . $file_name);
                  return response()->file($file);
    }

    public function down_file($invoice_number , $file_name){
        $down = Storage::disk('public_uploads_file')->path($invoice_number . '/' . $file_name);
        return response()->download($down);
    }
}
    