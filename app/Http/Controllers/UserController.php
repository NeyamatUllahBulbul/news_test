<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\ImageSizeValidation;
use App\Rules\ImageTypeValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $data['title']  = 'User List';
        $data['users']  = User::where('type', '!=', User::TYPE_SUPERADMIN)->paginate(2);
        $data['serial'] = managePaginationSerial($data['users']);

        return view('admin.user.index', $data);
    }

    public function create()
    {
        $title = 'Create User';

        return view('admin.user.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required | string',
            'email'    => 'required | email | unique:users,email',
            'password' => 'required | confirmed | min:6',
            'image'    => [
                'image', 'sometimes', 'nullable',
                new ImageSizeValidation(),
                new ImageTypeValidation(),
                'dimensions:min_width=120,min_height=120,max_width=120,max_height=120',
            ],
        ]);

        try {
            $user           = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->type     = User::TYPE_ADMIN;
            if ($request->has('image')) {
                $user->image = file_upload($request->image, 'users');
            }
            $user->save();

            toastr()->success(__('New User created successfully'));

            return redirect()->route('admin.user.index');
        } catch (\Exception $exception) {
            Log::error('User#Create: ' . $exception->getMessage());
            toastr()->error(__('Something went wrong!'));

            return redirect()->back();
        }
    }

    public function edit(User $user)
    {
        $data['title'] = 'User Edit';
        $data['user']  = $user;

        return view('admin.user.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required | string',
            'email' => 'required | email',
            'image' => [
                'sometimes', 'nullable', 'image',
                new ImageSizeValidation(),
                new ImageTypeValidation(),
                'dimensions:min_width=120,min_height=120,max_width=120,max_height=120',
            ],
        ]);

        try {
            $user->name   = $request->name;
            $user->email  = $request->email;
            $user->status = $request->status == 'Inactive' ? false : true;
            if ($request->has('image')) {
                if (!empty($user->image) && file_exists($user->image)) {
                    unlink_file($user->image);
                }
                $user->image = file_upload($request->image, 'users');
            }
            $user->save();

            toastr()->success(__('User information updated successfully'));

            return redirect()->back();
        } catch (\Exception $exception) {
            Log::error('User#Update: ' . $exception->getMessage());
            toastr()->error(__('Something went wrong!'));

            return redirect()->back();
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->image != null && file_exists($user->image)) {
                unlink_file($user->image);
            }
            $user->delete();

            toastr()->success(__('User deleted successfully'));

            return redirect()->back();
        } catch (\Exception $exception) {
            toastr()->error(__('Something went wrong!'));

            return redirect()->back();
        }
    }
}
