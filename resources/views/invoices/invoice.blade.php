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
         <div class="col-xl-12">
         <div class="d-flex align-items-center justify-content-between mb-3">
     <div>
        <a href="{{ route('invoice.show') }}" class="btn btn-success me-2">
            اضافه فتوره <i class="fas fa-plus"></i>
        </a>
        <a href="{{ route('page.export_invoices') }}" class="btn btn-success">
            تصدير فتوره <i class="fas fa-file-download"></i>
        </a>
    </div>
            </div>
            <div class="card mt-5">
                
                <div class="col-xl-12">
                    <div class="card-header pb-0">
                        
                        <p class="tx-12 tx-gray-500 mb-2">مثال على جدول الفواتير. <a href="#">تعرف على المزيد</a></p>

                        <div class="row card">
                            <div class="card-body">
                                <div class="table-responsive">

                                <table id="example" class="table table-bordered table-hover text-md-nowrap">
                            <thead  >
                                <tr>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">#</th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">الاسم</th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">رقم الفاتورة
                                    </th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">تاريخ الفاتورة
                                    </th>
                                    <!-- <th class="text-center" style="font-size: 16px; font-weight: bold;">المنتج</th> -->
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">القسم</th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">الخصم</th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">نسبة الضريبة
                                    </th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">قيمة الضريبة
                                    </th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">الإجمالي</th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">الحالة</th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">الملاحظات</th>
                                    <th class="text-center" style="font-size: 16px; font-weight: bold;">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selected as $select)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ Auth::user()->name }} (Admin)</td>
                                        <td class="text-center text-primary">{{ $select->invoice_number }}</td>
                                        <td class="text-center">{{ $select->due_date ?? 'غير متوفر' }}</td>
                                        <td class="text-center"><a
                                                href="{{ route('cases.invoices', ['id' => $select->id]) }}">{{ $select->section->section_name ?? 'غير متوفر' }}</a>
                                        </td>
                                        <!-- <td class="text-center">{{ $select->product_name ?? 'غير متوفر' }}</td> -->
                                      <td class="text-center">{{ $select->discoun ?? 'غير متوفر' }}</td>
                                        <td class="text-center text-primary">{{ $select->rate_vat ?? 'غير متوفر' }}</td>
                                        <td class="text-center">{{ $select->value_vat ?? '150.00' }}</td>
                                        <td class="text-center">{{ $select->total ?? '1000.00'}}</td>
                                        <td class="text-center">
                                            @if(isset($select->value_status))
                                                @if($select->value_status === 1)
                                                    <span class="text-success">{{ $select->status }}</span>
                                                @elseif($select->value_status === 2)
                                                    <span class="text-danger">{{ $select->status }}</span>
                                                @elseif($select->value_status === 3)
                                                    <span class="text-warning">{{ $select->status }}</span>
                                                @endif
                                            @else
                                                <span class="text-muted">غير متوفر</span>
                                            @endif
                                        </td>

                                        </td>
                                        <td class="text-center">{{ $select->note ?? '--'}}</td>

                                        <td class="text-center">
                                        <div class="dropdown">
                                          <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
                                              data-toggle="dropdown" id="dropdownMenuButton" type="button"> العمليات <i class="fas fa-caret-down ml-1"></i></button>
                                              <div  class="dropdown-menu tx-13">
                                                                    
                                            @php    $en_id = Crypt::encrypt($select->id); @endphp
                                            <a href="{{ route('invoice.edit', $en_id) }}"
                                            class="dropdown-item">تعديل  </a>
                                           
                                            @php    $en_id = Crypt::encrypt($select->id); @endphp
                                            <a href="{{ route('edit.casesInvoices', $en_id) }}"
                                            class="dropdown-item">حاله الدفع </a>

                                            <form action="{{ route('destroy', $select->id) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('هل أنت متأكد من أنك تريد حذف هذا العنصر؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"  class="dropdown-item">حذف</button>
                                            </form>

                                            <!-- النقل الي الارشيف   -->
                                            <a  class="dropdown-item"
                                                data-invoice_id="{{ $select->id }} data-target=" modal
                                                data-target="#Transfer_invoice" data-toggle="modal" href=" ">النقل الي
                                                    االارشيف</a>
                                                 
                                                    <!-- عمليه الطباعه   -->
                                                      <a class="dropdown-item " href="{{route('page.print_invoice',$select->id)}}"> الطباعه </a>
                                        </div>
                                    </div>

                                        </td>
                                    </tr>
                                    <!-- النقل الي الارشيف  -->
                                    


                                    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <form action=" {{route('arshef', $select->id)}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                 </div>
                                                <div class="modal-body">
                                                    هل انت متاكد من عملية الارشفة ؟
                                                    <input type="hidden" name="id" id="id">
 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">الغاء</button>
                                                    <button type="submit" class="btn btn-success">تاكيد</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

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
 
