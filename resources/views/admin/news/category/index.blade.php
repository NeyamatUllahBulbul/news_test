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
            <li class="breadcrumb-item">NewsCategory</li>
            <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">List of News Categories</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped text-center">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Is Featured</th>
                            <th>Is Home Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 1 @endphp
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->is_featured == true ? 'Yes' : 'No' }}</td>
                                <td>{{ $category->is_home_category == true ? 'Yes' : 'No' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $category->status == NewsCategory::STATUS_ACTIVE ? 'badge-success' : 'badge-danger' }}">
                                        {{ NewsCategory::STATUS_LIST[$category->status] }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-name="{{ $category->name }}"
                                            onclick="show_edit_modal(this)"
                                            data-is-featured="{{ $category->is_featured }}"
                                            data-slug="{{ $category->slug }}"
                                            data-is-home-category="{{ $category->is_home_category }}"
                                            data-status="{{ $category->status }}">
                                        <i class="fa fa-edit"></i>Edit
                                    </button>
                                    <form class="" action="{{route('news_category.destroy', $category->slug)}}"
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
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add News Category</h3>
                </div>
                <form role="form" action="{{route('news_category.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        @include('admin.news.category._form')
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editCategory">
                            @method('put')
                            <input type="hidden" name="slug" id="slug">
                            <div class="form-group">
                                <label for="name">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value=""
                                       class="form-control" id="edit_category_name" placeholder="Enter User name">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <br>
                                <input type="radio" name="status" value="Active" id="active">
                                <label for="active">Active</label>
                                <input type="radio" name="status" value="Inactive" id="inactive">
                                <label for="inactive">Inactive</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit_is_featured" name="is_featured"
                                       value="featured">
                                <label class="form-check-label" for="edit_is_featured">Is Featured?</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit_show_in_home"
                                       name="show_in_home" value="show">
                                <label class="form-check-label" for="edit_show_in_home">Show In Home</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submit_edit_form()">Update</button>
                    </div>
                </div>
            </div>
        </div>
        {{--End Modal--}}
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
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        function show_edit_modal(el) {
            var name = $(el).attr('data-name');
            var status = $(el).attr('data-status');
            var slug = $(el).attr('data-slug');
            var is_featured = $(el).attr('data-is-featured');
            var is_home_category = $(el).attr('data-is-home-category');
            $("#edit_category_name").empty().val(name);
            $("#slug").empty().val(slug);
            if (is_featured == 1) {
                $("#edit_is_featured").prop('checked', true);
            }
            if (is_home_category == 1) {
                $("#edit_show_in_home").prop('checked', true);
            }
            if (status == 1) {
                $("#active").prop('checked', true);
            } else {
                $("#inactive").prop('checked', true);
            }
            jQuery.noConflict();
            $("#editModal").modal();
        }

        function submit_edit_form() {
            event.preventDefault();

            var url = '{{ route('news_category.update') }}';
            var postData = new FormData(document.getElementById('editCategory'));
            $.ajax({
                url: url,
                data: postData,
                processData: false,
                contentType: false,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    if (data.code == 200) {
                        toastr.success(data.msg);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }

                    if (data.code == 400) {
                        toastr.error(data.msg);
                    }
                },
                error: function () {
                    toastr.error('Server Error');
                }
            });

        }
    </script>
@endpush
