<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="image">User Image <small>(Resolution: 120×120)</small> <small
                    class="text-primary">(Optional)</small></label>
            <input type="file" name="image" class="form-control dropify" data-height="280" id="image"
                   data-default-file="{{ isset($user) ? asset($user->image) : null }}"
                   data-max-width="121" data-max-height="121" data-allowed-file-extensions="jpg jpeg png svg">
            <label class="text-primary">The maximum size of the file can be 5MB.</label>
            @error('image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" value="{{old('name',isset($user)?$user->name:null)}}"
                   class="form-control" id="name" placeholder="Enter User name">
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">Email <span class="text-danger">*</span></label>
            <input type="email" name="email"
                   value="{{old('email',isset($user)?$user->email:null)}}"
                   class="form-control" id="email" placeholder="Enter User email">
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        @if(!isset($user))
            <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" id="status" placeholder="Password">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                       placeholder="Confirm Password">
                @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        @endif
        @isset($user)
            <div class="form-group">
                <label for="status">Status</label>
                <br>
                <input type="radio" name="status"
                       @if(old('status',isset($user) ? $user->status : null) == true) checked
                       @endif value="Active" id="active">
                <label for="active">Active</label>
                <input type="radio" name="status"
                       @if(old('status',isset($user) ? $user->status : null) == false) checked
                       @endif value="Inactive" id="inactive">
                <label for="inactive">Inactive</label>
            </div>
            @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        @endisset
    </div>
</div>

