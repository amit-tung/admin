@extends('adminpanel.master.master')

@section('title', __("admin.Account settings.Account settings"))

@section('content')


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Business</h1>
            </div>
            
            
            
            
            
            
        </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Form Field</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                                            <form method="POST" action="http://bjppost.rahulchocha.com/admin/business" accept-charset="UTF-8" id="myform" class="ajax_submit" enctype="multipart/form-data"><input name="_token" type="hidden" value="vCvIArm5pLcHAJw1TkJZyWN1SYogg4x9gizHsDI2">
                                        <div class="card-body">
                    <div class="message-section">
                                                    </div>
                    <div class="form-group">
<label class="control-label">Name <span class="text-danger">*</span></label>
<input class="form-control" placeholder="Enter name" name="name" type="text">

</div>


                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="http://bjppost.rahulchocha.com/admin/business" type="submit" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
                </form>
            </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

@endsection

@section('script')
<script>
   

</script>

@endsection 