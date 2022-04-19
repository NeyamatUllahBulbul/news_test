@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/select2/css/select2.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote-bs4.css')}}">
@endpush
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label for="cover_photo">Cover Image <span class="text-danger">*</span></label>
            <input type="file" name="cover_photo" class="form-control dropify" data-height="245" id="cover_photo"
                   data-default-file="{{ isset($news) ? asset($news->cover_photo) : null }}"
                   data-allowed-file-extensions="jpg jpeg png svg">
            <label class="text-primary">The maximum size of the file can be 5MB.</label>
            @error('cover_photo')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="featured"
                   @if(old('status',isset($news) ? $news->is_featured : null) == true) checked @endif>
            <label class="form-check-label" for="is_featured">Is Featured?</label>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="show_in_home" name="show_in_home" value="show"
                   @if(old('status',isset($news) ? $news->is_home_news : null) == true) checked @endif>
            <label class="form-check-label" for="show_in_home">Show In Home</label>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_highest_read" name="is_highest_read"
                   value="highest_read"
                   @if(old('status',isset($news) ? $news->is_highest_read : null) == true) checked @endif>
            <label class="form-check-label" for="is_highest_read">Is Highest Read?</label>
        </div>
    </div>
    <div class="col-md-7">
        <div class="form-group">
            <label for="title">News Title <span class="text-danger">*</span></label>
            <input type="text" name="title" value="{{old('title',isset($news)?$news->title:null)}}"
                   class="form-control" id="title" placeholder="Enter News title" required>
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="reporter_name">Reporter Name <span class="text-primary">(Optional)</span></label>
            <input type="text" name="reporter_name"
                   value="{{old('reporter_name',isset($news)?$news->reporter_name:null)}}"
                   class="form-control" id="reporter_name" placeholder="Enter Reporter Name">
            @error('reporter_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>News Category</label>
            <div class="select2-purple">
                <select name="categories[]" class="select2" multiple="multiple" data-placeholder="Select Category"
                        data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}" {{ isset($news->categories) ? in_array($category->id, $news_category_ids) ? 'selected' : null : null }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <br>
            <input type="radio" name="status"
                   @if(old('status',isset($news) ? $news->status : null) == true) checked @endif
                   value="Active" id="active">
            <label for="active">Active</label>
            <input type="radio" name="status"
                   @if(old('status',isset($news) ? $news->status : null) == false) checked @endif
                   value="Inactive" id="inactive">
            <label for="inactive">Inactive</label>
        </div>
        @error('status')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>News Category</label>
            <textarea name="news_content" id="summernote">{{ isset($news) ? $news->content : null }}</textarea>
        </div>
    </div>
</div>

@push('script')
    <!-- Select2 -->
    <script src="{{asset('assets/admin/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2();

    </script>
@endpush
