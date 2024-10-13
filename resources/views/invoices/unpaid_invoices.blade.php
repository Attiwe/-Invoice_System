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
                                                <th class="border-bottom-0 text-center" style="font-size: 16px; font-weight: bold;">#</th>
                                                <th class="border-bottom-0 text-center" style="font-size: 16px; font-weight: bold;">الاسم</th>
                                                <th class="border-bottom-0 text-center" style="font-size: 16px; font-weight: bold;">رقم الفاتورة</th>
                                                <th class="border-bottom-0 text-center" style="font-size: 16px; font-weight: bold;">تاريخ الفاتورة</th>
                                                    <!-- <th class="border-bottom-0 text-center" style="font-size: 16px; font-weight: bold;">تاريخ الدفع</th> -->
                                                 <th class="border-bottom-0 text-center" style="font-size: 16px; font-weight: bold;">القسم</th>
                                                <th class="border-bottom-0 text-center" style="font-size: 16px; font-weight: bold;">الخصم</th>
                                                 <th class="border-bottom-0 text-center" style="font-size: 16px; font-weight: bold;">الحالة</th>
                                              </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices  as $invoice )
                                            <tr>
												<td>{{$i++}}</td>
												<td> {{Auth::User()->name }} (admin)</td>
												<td> {{$invoice-> 	invoice_number }}</td>
												<td> {{$invoice ->due_date }}</td>
 												<td class=" text-primary" > {{$invoice ->Section->section_name  }}</td>
												<td> {{$invoice ->discoun  }}</td>
												<td  class="text-primary" > {{$invoice ->status   }}</td>
 											</tr>
                                            
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