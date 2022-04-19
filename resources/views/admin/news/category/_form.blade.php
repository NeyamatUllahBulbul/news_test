<div class="form-group">
    <label for="name">Category Name <span class="text-danger">*</span></label>
    <input type="text" name="name" value="{{old('name',isset($user)?$user->name:null)}}"
           class="form-control" id="name" placeholder="Enter Category name">
    @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>{{----}}
<div class="form-check">
    <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="featured">
    <label class="form-check-label" for="is_featured">Is Featured?</label>
</div>

<div class="form-check">
    <input type="checkbox" class="form-check-input" id="show_in_home" name="show_in_home" value="show">
    <label class="form-check-label" for="show_in_home">Show In Home</label>
</div>



