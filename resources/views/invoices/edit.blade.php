

@extends('layouts.master')
@section('title')
اضافة فاتورة
@stop
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection


@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                اضافة فاتورة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- row -->
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
           
            <form action="{{route('invoice.store_update',$invoice->id)}}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')
                    {{-- 1 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">رقم الفاتورة</label>
                            <input type="text" class="form-control" id="inputName" value="{{$invoice->invoice_number}}" name="invoice_number"
                                title="يرجي ادخال رقم الفاتورة" required>
                        </div>

                        <div class="col">
                            <label>تاريخ الفاتورة</label>
                            <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                type="text" value="{{ $invoice->invoice_Date }}" required>
                        </div>

                        <div class="col">
                            <label>تاريخ الاستحقاق</label>
                            <input class="form-control fc-datepicker" name="due_date" value="{{ $invoice-> due_date }}"
                                type="text" required>
                        </div>

                    </div>

                    {{-- 2 --}}
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">القسم</label>
                            <select name="section_id" class="form-control SlectBox" onclick="console.log($(this).val())"
                                onchange="console.log('change is firing')">
                                <!--placeholder-->
                                <!-- <option value=" " selected disabled>حدد القسم</option> -->
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $invoice->Section->section_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">المنتج</label>
                            <select id="product" name="product" class="form-control">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col">
                            <label for="inputName" class="control-label">مبلغ التحصيل</label>
                            <input type="text" class="form-control" id="inputName" name="amount_collection"
                                value="{{$invoice->amount_collection }}" >
                        </div>
                    </div>


                    {{-- 3 --}}

                    <div class="row">

                        <div class="col">
                            <label for="inputName" class="control-label">مبلغ العمولة</label>
                            <input type="text" class="form-control form-control-lg" id="Amount_commission"
                                name="amount_commission" title="يرجي ادخال مبلغ العمولة "
                                value="{{$invoice-> amount_commission }}"
                                required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">الخصم</label>
                            <input type="text" class="form-control form-control-lg" id="discoun" name="discoun"
                                title="يرجي ادخال مبلغ الخصم "
                                value="{{$invoice->discoun }}"  required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                            <select name="rate_vat" id="rate_vat" class="form-control" onchange="myFunction()">
                                <!--placeholder-->
                                <option value="" selected disabled> {{$invoice->rate_vat }}</option>
                                <option value=" 5%">5%</option>
                                <option value="10%">10%</option>
                            </select>
                        </div>

                    </div>

                    {{-- 4 --}}

                    <!-- <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                            <input type="text" class="form-control" id="value_vat" name="value_vat" readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                            <input type="text" class="form-control" id="Total"  name="total" readonly>
                        </div>
                    </div> -->

                    {{-- 5 --}}
                    <div class="row">
    <div class="col">
        <label for="exampleTextarea">ملاحظات</label>
        <textarea class="form-control" id="exampleTextarea" name="note" rows="3">{{ $invoice->note }}</textarea>
    </div>
</div><br>


 

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                    </div>


                </form>
           
            </div>
        </div>
    </div>
</div>

</div>

<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Select2 js-->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!--Internal Fileuploads js-->
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<!--Internal Fancy uploader js-->
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
<!--Internal  Form-elements js-->
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<!--Internal Sumoselect js-->
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<!-- Internal form-elements js -->
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();

</script>
<!--  
  <script>
    $(document).ready(function () {
        $('select[name="Section"]').on('change', function () {
            var SectionId = $(this).val();
            if (SectionId) {
                $.ajax({
                     url: "{{ URL::to('section') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="product"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="product"]').append('<option value="' +
                                value + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
        });

    });

</script>  
<script>

 
function myFunction() {
    var Amount_Commission = parseFloat(document.getElementById("Amount_commission").value) || 0;
    var Discount = parseFloat(document.getElementById("discoun").value) || 0;
    var Rate_VAT = parseFloat(document.getElementById("rate_vat").value) || 0;

    // تحقق من أن قيمة نسبة ضريبة القيمة المضافة تم تحديدها
    if (!document.getElementById("rate_vat").value) {
        alert('يرجي تحديد نسبة ضريبة القيمة المضافة');
        return; // الخروج من الدالة إذا كانت القيمة غير صحيحة
    }

    var Amount_Commission2 = Amount_Commission - Discount;

    if (Amount_Commission <= 0) {
        alert('يرجي ادخال مبلغ العمولة بشكل صحيح');
        document.getElementById("value_vat").value = '';
        document.getElementById("Total").value = '';
        return;
    }

    var Value_VAT = (Amount_Commission2 * rate_vat) / 100;
    var Total = Amount_Commission2 + value_vat;

    document.getElementById("value_vat").value = Value_VAT.toFixed(2);
    document.getElementById("total").value = Total.toFixed(2);
}
</script>  -->

@endsection