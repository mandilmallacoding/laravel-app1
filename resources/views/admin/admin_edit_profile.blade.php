@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.update_profile') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" placeholder="Name" id="name" value="{{ $adminData->name }}" name="name">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="email" placeholder="Email" id="email" value="{{ $adminData->email }}" name="email">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Profile Image</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" placeholder="Email" id="profile_img" value="" name="profile_img">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img id="showimg" class="rounded avatar-md mx-auto" alt="200x200" src="{{ !empty($adminData->profile_image)?url('upload/admin_images/'.$adminData->profile_image):url('upload/no_image.jpg') }}" data-holder-rendered="true">
                                </div>
                            </div>
                            <!-- end row -->
                            <input type="submit" value="Update Profile" class="btn btn-primary btn-rounded waves-effect waves-light">
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('#profile_img').change(function(e){
            // console.log("mandil");

            var reader = new FileReader();
            reader.onload = function(e){
                $('#showimg').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>

@endsection
