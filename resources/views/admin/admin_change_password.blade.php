@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.update_password') }}" method="post" >
                            @csrf

                            @if (count($errors))
                             @foreach ($errors->all as $error)
                            <p class="alert alert-danger alert-dismissible fade show">{{ $error }}</p>
                             @endforeach

                            @endif
                            <div class="row mb-3">
                                <label for="admin-oldpassword" class="col-sm-2 col-form-label">old Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" placeholder="old Password" id="oldpassword" name="oldpassword">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="admin-newpassword" class="col-sm-2 col-form-label">New Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" placeholder="New Password" id="newpassword" name="newpassword">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="admin-confirmpassword" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword">
                                </div>
                            </div>
                            <!-- end row -->

                            <input type="submit" value="Change Password" class="btn btn-primary btn-rounded waves-effect waves-light">
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>



@endsection
