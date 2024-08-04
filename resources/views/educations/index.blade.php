@extends('layouts.app')
@section('css')
            <!-- DataTables -->
            <link href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            <link href="{{url('assets')}}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Educations</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                        <li class="breadcrumb-item active">Educations</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">List Data</h4>
                    

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Action</th>
                           
                        </tr>
                        </thead>


                        <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                           
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                           
                        </tr>
                     
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
@section('js')
     <!-- Required datatable js -->
     <script src="{{url('assets')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
     <script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
     <!-- Buttons examples -->
     <script src="{{url('assets')}}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
     <script src="{{url('assets')}}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
     <script src="{{url('assets')}}/libs/jszip/jszip.min.js"></script>
     <script src="{{url('assets')}}/libs/pdfmake/build/pdfmake.min.js"></script>
     <script src="{{url('assets')}}/libs/pdfmake/build/vfs_fonts.js"></script>
     <script src="{{url('assets')}}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
     <script src="{{url('assets')}}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
     <script src="{{url('assets')}}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
     
     <!-- Responsive examples -->
     <script src="{{url('assets')}}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
     <script src="{{url('assets')}}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

     <!-- Datatable init js -->
     <script src="{{url('assets')}}/js/pages/datatables.init.js"></script>    
@endsection