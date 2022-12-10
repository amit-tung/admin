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
            <div class="row">
                <div class="col-md-12">

                </div>
                <div class="col-md-8 offset-md-2">
                    @include('admin.flash')
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Form Field</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->


                        {!! Form::model($record, ['route' => ['admin.profile_post'],'files' =>true , 'id'=>'myform', 'method' => 'post', 'class' => 'ajax_submit','autocomplete'=>'off']) !!}

                        <div class="card-body">
                            <div class="message-section">
                                @include('admin.message_section')
                            </div>

                            @component('admin.component.text', [
                                'name' => 'name',
                                'title' => 'Name',
                                'value'=>null,
                                'required'=>true,
                                'options'=>['placeholder'=>'Enter name']
                            ])@endcomponent
                            @component('admin.component.text', [
                                'name' => 'email',
                                'title' => 'Email',
                                'value'=>null,
                                'required'=>true,
                                'options'=>['placeholder'=>'Enter email']
                            ])@endcomponent
                            @component('admin.component.password', [
                                'name' => 'password',
                                'title' => 'Password (Leave black if don\'t want to update)',
                                'value'=>null,
                                'required'=>true,
                                'options'=>['placeholder'=>'Enter email','autocomplete'=>'off']
                            ])@endcomponent

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ url('admin/home') }}" type="submit" class="btn btn-default">Back</a>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

