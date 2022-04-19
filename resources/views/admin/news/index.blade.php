@php use App\Models\NewsCategory @endphp
@extends('layout.admin.master')
@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">List of News</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped text-center">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Cover photo</th>
                            <th>Title</th>
                            <th>Reporter Name</th>
                            <th>Categories</th>
                            <th>Publish Date</th>
                            <th>Update Date</th>
                            <th>Is Featured</th>
                            <th>Show In Home</th>
                            <th>Is Highest read</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 1 @endphp
                        @foreach($news as $new)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>
                                    <img src="{{ asset($new->cover_photo) }}"
                                         style="max-height: 50px!important;max-width: 50px!important;">
                                </td>
                                <td>{{ $new->title }}</td>
                                <td>{{ $new->reporter_name }}</td>
                                <td>
                                    @foreach($new->categories as $category)
                                        <span class="badge badge-primary">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ date("d F, Y@h:i:s A",strtotime($new->created_atdate)) }}</td>
                                <td>{{ date("d F, Y@h:i:s A",strtotime($new->updated_atdate)) }}</td>
                                <td>{{ $new->is_featured == true ? 'Yes' : 'No' }}</td>
                                <td>{{ $new->is_home_news == true ? 'Yes' : 'No' }}</td>
                                <td>{{ $new->is_highest_read == true ? 'Yes' : 'No' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $new->status == NewsCategory::STATUS_ACTIVE ? 'badge-success' : 'badge-danger' }}">
                                        {{ NewsCategory::STATUS_LIST[$new->status] }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('news.edit', $new->slug) }}" type="button"
                                       class="btn btn-info btn-sm">
                                        <i class="fa fa-edit"></i>Edit
                                    </a>
                                    <form class="" action="{{route('news.destroy', $new->slug)}}"
                                          method="post"
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
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- DataTables -->
    <script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function () {
            jQuery.noConflict();
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
