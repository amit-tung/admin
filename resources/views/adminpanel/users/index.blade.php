@extends('adminpanel.master.master')

@section('title', __('admin.Account settings.Account settings'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users List</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('users.create') }}" class="btn btn-success"> <i class="fa fa-plus"></i> Add new</a>

                        {{-- <ol class="breadcrumb float-sm-right"> --}}
                        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                        {{-- <li class="breadcrumb-item active">DataTables</li> --}}
                        {{-- </ol> --}}

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('adminpanel.flash')
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Created At</th>
                                            <th>Purchase Date</th>
                                            <th>Status</th>
                                            <th width="200">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
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

@section('script')
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
                ajax: '{{ route("users.index")  }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'contact', name: 'contact'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'plan_start', name: 'plan_start', searchable: false,orderable : false,className : 'text-center'},
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
                    url: '{{ route("users.index") }}/' + row_id ,
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

            $("body").on("click", ".add_date", function () {

                var row_id = $(this).data("id");
                $.ajax({
                    type: "PUT",
                    url: '{{ route("users.index") }}/' + row_id ,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": row_id,
                        "date": "plan_start",
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
                        oTable.ajax.reload();
                    }
                });
            });

            $("#datatable1").on('click', '.data-delete', function () {
                var obj = $(this);
                var id = $(this).attr('data-id');

                if (confirm("Are you sure to Delete Data?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route("users.index")  }}/" + id,
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
        });
    </script>
@endsection
