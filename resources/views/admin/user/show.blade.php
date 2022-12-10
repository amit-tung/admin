@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    {{--<div class="col-sm-6 text-right">--}}
                    {{--<ol class="breadcrumb float-sm-right">--}}
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    {{--<li class="breadcrumb-item active">DataTables</li>--}}
                    {{--</ol>--}}
                    {{--</div>--}}
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            @include('admin.flash')
            <div class="row">

                {{--<div class="col-md-12">--}}
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body  p-0">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th width="30%">Name</th>
                                    <td width="70%">{{ $record['name'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Username</th>
                                    <td width="70%">{{ $record['username'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Email</th>
                                    <td width="70%">{{ $record['email'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Contact</th>
                                    <td width="70%">{{ $record['contact'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Gender</th>
                                    <td width="70%">{{ $record['gender'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Country</th>
                                    <td width="70%">{{ $record['country'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">State</th>
                                    <td width="70%">{{ $record['state'] }}</td>
                                </tr>
                                
                                <tr>
                                    <th width="30%">District</th>
                                    <td width="70%">{{ $record['city'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Taluka</th>
                                    <td width="70%">{{ $record['taluka'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Image</th>
                                    <td width="70%"><img src="{{ $record['image_url'] }}" width="150"></td>
                                </tr>
                                <tr>
                                    <th width="30%">Business</th>
                                    <td width="70%">{{ $record['business'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Created At</th>
                                    <td width="70%">{{ $record['created_at']->format(config('setting.DATETIME_FORMAT')) }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">App</th>
                                    <td width="70%">{{ $record['app']['name'] }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Status</th>
                                    <td width="70%">{{ $record['status'] }}</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route($route.'index') }}" type="submit" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
                @foreach($business as $key => $company)
                    <div class="col-md-6">
                        {!! Form::model($company, ['route' => 'admin.user_update_company','files' =>true , 'id'=>'myform', 'method' => 'patch', 'class' => 'ajax_submit']) !!}
                        <input type="hidden" name="company_id" value="{{ $company['id'] }}">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Company Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body  p-0">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="30%">Name</th>
                                        <td width="70%" class="p-1">
                                            {!! Form::text('name',null, ['class' => 'form-control'] ) !!}
                                            {{--                                        {{ $company['name'] }}--}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Email</th>
                                        <td width="70%" class="p-1">
                                            {!! Form::text('email',null, ['class' => 'form-control'] ) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Contact</th>
                                        <td width="70%" class="p-1">
                                            {!! Form::text('contact',null, ['class' => 'form-control'] ) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Address</th>
                                        <td width="70%" class="p-1">
                                            {!! Form::text('address',null, ['class' => 'form-control'] ) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Website</th>
                                        <td width="70%" class="p-1">
                                            {!! Form::text('website',null, ['class' => 'form-control'] ) !!}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th width="30%">Logo</th>
                                        <td width="70%" class="p-1">
                                            <img src="{{ $company['logo_url'] }}" width="150">
                                            <br>
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    {!! Form::file("logo", ['class' => 'custom-file-input form-control','text'=>'select file'] ) !!}
                                                    <label class="custom-file-label" for="customFile"> </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th width="30%">Created At</th>
                                        <td width="70%"
                                            class="p-1">{{ $company['created_at']->format(config('setting.DATETIME_FORMAT')) }}</td>
                                    </tr>
                                    {{--<tr>--}}
                                    {{--<th width="30%">Status</th>--}}
                                    {{--<td width="70%">{{ $company['status'] }}</td>--}}
                                    {{--</tr>--}}
                                    </thead>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn btn-success float-right" type="submit">Update Business</button>
                                {{--<a href="{{ route($route.'index') }}" type="submit" class="btn btn-default">Back</a>--}}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                @endforeach
                {{--</div>--}}

                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">User Custom Frame1</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body  p-0">
                            {!! Form::open(['route' => 'admin.add_custom_frame','files' =>true , 'id'=>'myform', 'method' => 'post', 'class' => 'ajax_submit']) !!}

                            <div class="row p-3">

                                {{--<div class="col-md-4 offset-md-1">--}}
                                {{--@component('admin.component.select', [--}}
                                {{--'name' => 'category_id',--}}
                                {{--'title' => 'Select User Company',--}}
                                {{--'lists' => ['' => '--- Select Company---'] + \App\User::where('id',$record['id'])->get()->pluck('business','id')->toArray(),--}}
                                {{--'value'=>null,--}}
                                {{--'required'=>true,--}}
                                {{--'options'=>[]--}}
                                {{--])@endcomponent--}}
                                {{--</div>--}}
                                <div class="col-md-6">
                                    @component('admin.component.file', [
                                        'name' => 'image',
                                        'title' => 'Upload Frame',
                                        'value'=>null,
                                        'required'=>true,
                                        'options'=>['placeholder'=>'Choose file','required'=>'required']
                                    ])@endcomponent
                                </div>
                                <input type="hidden" value="{{$record['id']}}" name="user_id">
                                <div class="col-md-2">
                                    <br/>
                                    <input id="invisible_id" name="invisible" type="hidden" value="secret">

                                    <button type="submit" class="btn btn-info btn-block mt-2">Submit</button>
                                </div>

                            </div>
                            {!! Form::close() !!}


                            <div class="row">
                                <div class="col-md-12">

                                    <table id="datatable1" class="table table-sm table-bordered table-striped">
                                        <thead>
                                        <tr class="bg-gradient-cyan text-white">
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user_frames as $key => $user_frame)
                                            <tr>
                                                <td>{{ $user_frame['id'] }}</td>
                                                <td class="text-center">
                                                    <a href="{{ $user_frame['image_url'] }}" target="_blank"> <img
                                                                src="{{ $user_frame['image_url'] }}" width="150"></a>
                                                </td>
                                                <td>{{ $user_frame['status'] }}</td>

                                                <td>{{ $user_frame['created_at']->format(config('setting.DATE_FORMAT')) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ url('admin/delete_custom_frame/'.$user_frame['id']) }}" class="btn btn-danger btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-trash"></i></a>
                                                    {{--<a href="{{ url('admin/company/'.$user_frame['id'].'/edit') }}" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>--}}
                                                    {{--<button class="btn btn-danger btn-sm frame-delete "--}}
                                                            {{--data-id="' . $record->id . '" data-toggle="tooltip"--}}
                                                            {{--data-original-title="Delete"><i class="fa fa-trash"></i>--}}
                                                    {{--</button>--}}

                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')
    <script type="text/javascript">

    </script>
@endsection
