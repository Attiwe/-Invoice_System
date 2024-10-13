@extends('layouts.master')
 {{$i = 1;}}   <!-- counter -->

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفوتير المدفوعه</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المدفوعه    </span>
						</div>
					</div>
					 
				</div>
                <!-- start table -->
                <div class="row row-sm">  
    <div class="breadcrumb-header justify-content-between">
        <div class="col-xl-12">
            <div class="my-auto">
                
            </div>
            <div class="card mt-5">
                <div class="col-xl-12">
                    <div class="card-header pb-0">
                        <p class="tx-12 tx-gray-500 mb-2">مثال على جدول الفواتير. <a href="#">تعرف على المزيد</a></p>
                        <div class="row card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered table-hover text-md-nowrap">
                                        <thead class=" text-white">
                                            <tr>
                                                <th >#</th>
                                                <th >رقم الفاتورة</th>
                                                <th >تاريخ الفاتورة</th>
                                                <th >القسم</th>
                                                <th >الخصم</th>
                                                <th >الحالة</th>
                                                <th >العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $invoice->invoice_number }}</td>
                                                <td>{{ $invoice->due_date }}</td>
                                                <td class=" text-primary">{{ $invoice->Section->section_name }}</td>
                                                <td>{{ $invoice->discoun }}</td>
                                                <td class="text-info">{{ $invoice->status }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary" data-toggle="dropdown" id="dropdownMenuButton" type="button">
                                                            العمليات <i class="fas fa-caret-down ml-1"></i>
                                                        </button>
                                                        <div class="dropdown-menu tx-13">
                                                            <!-- Delete action -->
                                                            <a class="dropdown-item" data-invoice_id="{{ $invoice->id }}" data-toggle="modal" data-target="#deleteInvoiceModal_{{ $invoice->id }}">مسح</a>
                                                            
                                                            <!-- Restore action -->
                                                            <a class="dropdown-item" data-invoice_id="{{ $invoice->id }}" data-toggle="modal" data-target="#restoreInvoiceModal_{{ $invoice->id }}">نقل إلى قائمة الفواتير</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Start Delete Invoice Modal -->
                                            <div class="modal fade" id="deleteInvoiceModal_{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">مسح الفاتورة</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <form action="{{ route('page.Arshef_destroy', $invoice->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                        </div>
                                                        <div class="modal-body">
                                                            هل أنت متأكد من عملية المسح؟
                                                            <input type="hidden" name="id" id="id" value="{{ $invoice->id }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-danger">تأكيد</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Delete Invoice Modal -->

                                            <!-- Start Restore Invoice Modal -->
                                            <div class="modal fade" id="restoreInvoiceModal_{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">نقل إلى قائمة الفواتير</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <form action="{{ route('page.softDelet_update', $invoice->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                        </div>
                                                        <div class="modal-body">
                                                            هل أنت متأكد من عملية النقل؟
                                                            <input type="hidden" name="id" id="id">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-success">تأكيد</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Restore Invoice Modal -->
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

         <!-- End table -->

         


@endsection
@section('content')
				<!-- row -->
				<div class="row">

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

@endsection