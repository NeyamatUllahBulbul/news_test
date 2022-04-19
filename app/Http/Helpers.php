<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('file_upload')) {
    function file_upload($file, $location)
    {
        if ($file) {
            $random         = Str::random(3);
            $thumbnail_name = $random . '-' . $file->getClientOriginalName();
            $file->storeAs('public/' . $location, $thumbnail_name);

            return 'storage/' . $location . '/' . $thumbnail_name;
        }
    }
}

if (!function_exists('unlink_file')) {
    function unlink_file($url)
    {
        try {
            unlink($url);
            Storage::delete($url);
        } catch (\Throwable $th) {
            toastr()->error('Error', __('Something Wrong Try Again!'));
        }
    }
}

if (!function_exists('get_user_image')) {
    function get_user_image()
    {
        try {
            if (auth()->user()->image != null) {
                return auth()->user()->image;
            } else {
                return 'assets/admin/images/rsz_index.png';
            }
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('get_user_image: ' . $th->getMessage());
        }
    }
}

if (!function_exists('get_default_user_image')) {
    function get_default_user_image()
    {
        try {
            return 'assets/backend/images/user_avatar.png';
        } catch (\Throwable $th) {
            toastr()->error('Error', __('Something Wrong Try Again!'));
        }
    }
}

if (!function_exists('managePaginationSerial')) {
    function managePaginationSerial($obj)
    {
        $serial = 1;
        if ($obj->currentPage() > 1) {
            $serial = $obj->perPage() * ($obj->currentPage() - 1) + 1;
        }
        return $serial;
    }
}

if (!function_exists('generate_slug')) {
    function generate_slug($data)
    {
        try {
            return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $data)) . '-' . Str::random(5);
        } catch (\Throwable $th) {
            toastr()->error('Error', __('Something Wrong Try Again!'));
        }
    }
}
