@php use App\Models\User; @endphp
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
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{$title}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- card-body -->
                <div class="card-body">
                    <table class="table table-bordered text-center table-responsive-lg">
                        <thead>
                        <tr>
                            <th style="width: 10px">Sl</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $serial++ }}</td>
                                <td>
                                    <img src="{{ asset($user->image) }}"
                                         style="max-height: 50px!important;max-width: 50px!important;">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ User::TYPES[$user->type] }}</td>
                                <td>
                                    <span
                                        class="badge {{ $user->status == User::STATUS_ACTIVE ? 'badge-success' : 'badge-danger' }}">
                                        {{ User::STATUS_LIST[$user->status] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{route('user.edit',$user->id)}}" class="btn btn-info btn-sm">
                                        <i class="fa fa-edit"></i>Edit
                                    </a>
                                    <form class="" action="{{route('user.destroy',$user->id)}}" method="post"
                                          style="display:inline">
                                        @csrf
                                        @method('delete')
                                        <button title="Delete" type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <!-- Pagination -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="{{$users->previousPageUrl()}}">&laquo;</a></li>
                        @for($i=1;$i<=$users->lastPage();$i++)
                            <li class="page-item"><a class="page-link" href="{{$users->url($i)}}">{{$i}}</a></li>
                        @endfor
                        <li class="page-item"><a class="page-link" href="{{$users->nextPageUrl()}}">&raquo;</a></li>
                    </ul>
                </div>
                <!-- Pagination ends -->
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection
