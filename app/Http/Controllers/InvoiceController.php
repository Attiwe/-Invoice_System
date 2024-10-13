<?php

namespace App\Http\Controllers;

use App\Models\Arshefet;
use App\Models\User;
use App\Models\Invoic_attachments;
use App\Models\Invoice;
use App\Models\Invoic_detals;
use App\Models\Product;
use App\Models\Section;
use App\Notifications\NotificationInvoicePaid;
use Auth;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Notification;
use PHPUnit\Framework\MockObject\Invocation;
use SebastianBergmann\CodeCoverage\Driver\Selector;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $selected = Invoice::all();
            $selected = Invoice::query()->latest()->with('section')->get();
         return view('invoices.invoice', compact('selected'));
    }


    public function store(Request $request)
    {
         try {
            DB::beginTransaction();

            $invoice = Invoice::create([
                'section_id' => $request->section_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'invoice_Date' => $request->invoice_Date,
                'rate_vat' => $request->rate_vat,
                'due_date' => $request->due_date,
                'value_vat' => $request->value_vat,
                'total' => $request->total,
                'status' => 'غير مدفوع',
                'value_status' => 2,
                'discoun' => $request->discoun,
                'note' => $request->note,
                'user' => Auth::User()->name,
                'description' => $request->description,
                'amount_collection' => $request->amount_collection,
                'amount_commission' => $request->amount_commission,
            ]);

            $invoices_id = Invoice::latest()->first()->id;
                
            Invoic_detals::create([
                'id_Invoice' => $invoices_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->section_id,
                'Status' => 'غير مدفوعه',
                'Value_Status' => 2,
                'note' => $request->note,
                'user' => Auth::user()->name,
            ]);

             if ($request->hasFile('pic')) {
                $imag = $request->file('pic');
                $file_name = $imag->getClientOriginalName();
                $invoice_number = $request->invoice_number;

                $attachments = new Invoic_attachments();
                $attachments->file_name = $file_name;
                $attachments->invoice_number = $invoice_number;
                $attachments->Created_by = Auth::user()->name;
                $attachments->invoice_id = $invoices_id;
                $attachments->save();

                $imag->move(public_path('attachments/' . $invoice_number), $file_name);
            }

            DB::commit();

            $user = User::first();
           // $user->notify(new NotificationInvoicePaid( $invoices_id  ));
            Notification::send($user , new NotificationInvoicePaid( $invoices_id ));

            return redirect()->route('page.invoice')->with('Add', 'تم إضافة الفاتورة بنجاح');
        } catch (\Throwable $th)   {
            DB::rollBack();

            return view('emty.emty');
        }
    }

    public function show()
    {
        //Bad Code
        $products = Product::all();
        $sections = Section::all();
        
         return view('invoices.add_invoice', compact('sections', 'products'));
    }



    public function cases($id)
    {

        DB::beginTransaction();
        try {
            $invoices = Invoice::query()->where('id', $id)->first();
            $invoice_detals = Invoic_detals::query()->where('id_Invoice', $id)->get();
            $invoice_attachment = Invoic_attachments::query()->where('invoice_id', $id)->get();
            DB::commit();
            return view('invoices.cases_invoice', compact('invoices', 'invoice_detals', 'invoice_attachment'));


        } catch (\Throwable $th) {
            DB::rollBack();

            return view('emty.emty');
        }


    }




    public function edit($id)
    {
                //Bad Code

        $en_id = Crypt::decrypt($id);
        $invoice = Invoice::query()->where('id', $en_id)->first();
        $sections = Section::all();
        $products = Product::all();

        return view('invoices.edit', compact('invoice', 'sections', 'products'));
    }

    public function store_update(Request $request)
    {
        DB::beginTransaction();


        $request->validate([
            'invoice_number' => 'required|string',
            'invoice_Date' => 'required|date',
            'due_date' => 'required|date',
            'amount_collection' => 'required|numeric',
            'amount_commission' => 'required|numeric',
            'product' => 'required|string',
            'discoun' => 'nullable|numeric',
            'note' => 'nullable|string',
        ]);


        try {
            $invoice = Invoice::query()->where('id',$request->id);

           
            $invoice->update([
                'section_id' => $request->section_id,
                'invoice_number' => $request->invoice_number,
                'invoice_Date' => $request->invoice_Date,
                'rate_vat' => $request->rate_vat,
                'due_date' => $request->due_date,
                'amount_collection' => $request->amount_collection,
                'amount_commission' => $request->amount_commission,
                'product' => $request->product,
                'discoun' => $request->discoun,
                'note' => $request->note,
                'Value_Status' => 2,
                // 'value_status' => 2,
                'status' => 'غير معرفه',
            ]);

            DB::commit();
            return redirect()->route('page.invoice')->with('success', 'تم تحديث الفاتورة بنجاح');

        } catch (\Throwable $th) {
            DB::rollBack();
            return view('emty.emty');
        }
    }


    public function edit_invoices($id)
    {
        $en_id = Crypt::decrypt($id);
        $invoices = Invoice::where('id', $en_id)->first();
        return view('invoices.statuse_invoice', compact('invoices'));

    }


    public function status_update(Request $request)
    {
        $en_id = Crypt::decrypt($request->id);
        try {
            $invoices = Invoice::query()->where('id',$en_id)->first();
            
     //    $invoices = Invoice::latest()->with('id_Invoice')->where('id', $en_id)->first();
            // dd(  $invoices);
          
            if ($request->status === 'مدفوعة') {
                $invoices->update([
    
                    'value_status' => 1,
                    'status' => $request->status,
                    'pyment_data' => $request->Payment_Date,
    
                ]);
    
                $invoices_id = $invoices->id;
    
                Invoic_detals::create([
                    'id_Invoice' => $invoices_id,
                    'invoice_number' => $request->invoice_number,
                    'product' => $request->product,
                    'Section' => $request->Section,
                    'Value_Status' => 1,
                    'note' => $request->note,
                    'Payment_Date' => $invoices->pyment_data,
                    'Status' => $invoices->status,
    
                    'user' => Auth::User()->name,
                ]);
    
    
            } else {
                $invoices->update([
    
                    'Value_Status' => 3,
                    'status' => $request->status,
                    'pyment_data' => $request->pyment_data,
    
                ]);
            }
            return redirect()->route('page.invoice');   
           } catch (\Exception $e) {
            
     return view('emty.emty');
          }

}

     public function show_invoice_paid()
    {

        $invoices = Invoice::query()->where('value_status', 1)->get();
        return view('invoices.paid_invoices', compact('invoices'));
    }

    public function show_invoice_unpaid()
    {
        $invoices = Invoice::query()->where('status', 'غير مدفوع')->get();
        return view('invoices.unpaid_invoices', compact('invoices'));
    }

    public function show_invoice_part()
    {
        $invoices = Invoice::query()->where('status', 'مدفوعة جزئيا')->get();
        return view('invoices.part_paid_invoices', compact('invoices'));

    }

    public function print_invoice(Request $request){
        $invoices = Invoice::query()->where('id',$request->id)->first();
        return view('invoices.print_invoice',compact('invoices'));
    }


    public function export() 
    {
        return Excel::download(new InvoiceExport, 'قائمه الفوتيرw.xlsx');
    }

    public function arshef($id)
    {
        $invoices = Invoice::query()->where('id',$id)->first();
            $invoices->delete();
            return redirect()->route('page.invoice_arshefe');
     }

    public function destroy(Request $request )
    {
        $invoices = Invoice::where('id', $request->id)->first();
    
        
            $invoices->forceDelete();
            return back();
        
        }
    
}

