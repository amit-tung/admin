@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }} List</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route($route.'create') }}" class="btn btn-success"> <i class="fa fa-plus"></i> Add new</a>

                        {{--<ol class="breadcrumb float-sm-right">--}}
                            {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                            {{--<li class="breadcrumb-item active">DataTables</li>--}}
                        {{--</ol>--}}

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('admin.flash')
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div>
                                <label for="">Filter </label>
                            </div>
                            <div class="row justify-content-between mt-2 mb-4 ">
                                <div class="col-md-3">
                                    <label for=""> Select App: </label>
                                    {{
                                        Form::select('app',$apps,request()->app??'',[
                                            'class'=>'custom-select custom-select-s form-contro form-control-s',
                                            'style'=>'width: unset',
                                            'placeholder'=>'Select App',
                                            'id'=>'filter_app_id'
                                        ])
                                    }}
                                </div>
                                
                                <div>
                                    <button  id="filter_btn" class="btn btn-success"> Filter</button>
                                </div>

                            </div>
                            <table id="datatable1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Index</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Name</th>
                                    <th>Festival Date</th>
                                    <th>Activation Date</th>
                                    <th>Display Order</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('js')
    {{--<script>--}}
        {{--$(function () {--}}
            {{--$("#example1").DataTable();--}}
        {{--});--}}
    {{--</script>--}}
    <!-- DataTables -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            var oTable = $('#datatable1').DataTable({
                processing: true,
                serverSide: true,
                // stateSave: true,
                //scrollY: 300,
                ajax: {
                    url: "{{ route($route.'index')  }}",
                    data: function (d) {
                        d.appId = $('#filter_app_id').val()
                     }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image',searchable: false,orderable : false,className : 'text-center'},
                    {data: 'festival_category.name', name: 'festival_category.name'},
                    {data: 'festival_sub_category.name', name: 'festival_sub_category.name'},
                    {data: 'name', name: 'name'},
                    {data: 'festival_date', name: 'festival_date'},
                    {data: 'active_from', name: 'active_from'},
                    {data: 'display_order', name: 'display_order'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'status', name: 'status', searchable: false,orderable : false,className : 'text-center'},
                    {data: 'action', name: 'action', searchable: false, orderable : false,className : 'text-center'},
                ]
            });



            $('#datatable1').on('draw.dt', function () {
                $('.chk_status').each(function () {
                    $(this).bootstrapToggle()
                });
            });
            $("body").on("change", ".chk_status", function () {
                var row_id = $(this).val();
                if ($(this).is(':checked')) {
                    var status = $(this).attr('data-on');     // If checked
                } else {
                    var status = $(this).attr('data-off'); // If not checked
                }

                $.ajax({
                    type: "PUT",
                    url: '{{ route($route.'index') }}/' + row_id ,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": row_id,
                        "status": status,
                    },
                    beforeSend: function () {
                        $('#datatable1').waitMe({effect: 'roundBounce'});
                    },
                    complete: function () {
                        $('#datatable1').waitMe('hide');
                    },
                    error: function (result) {
                    },
                    success: function (result) {
                        //Success Code.
                    }
                });
            });


            $("#datatable1").on('click', '.data-delete', function () {
                var obj = $(this);
                var id = $(this).attr('data-id');

                if (confirm("Are you sure to Delete Data?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route($route.'index')  }}/" + id,
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        beforeSend: function () {
                            $(this).attr('disabled', true);
                            $('.alert .msg-content').html('');
                            $('.alert').hide();
                        },
                        success: function (resp) {
                            oTable.ajax.reload();
                            alert(resp.message);
                        },
                        error: function (e) {
                            alert('Error: ' + e);
                        }
                    });
                }
            });
            $("#filter_btn").click(function(){
                oTable.draw();
            })
        });
    </script>

@endsection