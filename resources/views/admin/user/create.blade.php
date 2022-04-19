@extends('layout.admin.master')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{$title}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @include('admin.user._form')
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection
