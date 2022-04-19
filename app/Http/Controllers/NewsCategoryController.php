<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $data['title']      = 'News Category';
        $data['categories'] = NewsCategory::latest()->get();

        return view('admin.news.category.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required | string',
            'is_featured'  => 'sometimes | nullable | string',
            'show_in_home' => 'sometimes | nullable | string',
        ]);

        try {
            $category                   = new NewsCategory();
            $category->name             = $request->name;
            $category->slug             = generate_slug($request->name);
            $category->is_featured      = $request->has('is_featured') && $request->is_featured == 'featured' ? true : false;
            $category->is_home_category = $request->has('show_in_home') && $request->show_in_home == 'show' ? true : false;
            $category->status           = true;
            $category->save();

            toastr()->success(__('New Category created successfully'));

            return back();
        } catch (\Exception $exception) {
            Log::error('NewsCategory#Create: ' . $exception->getMessage());
            toastr()->error(__('Something went wrong!'));

            return back();
        }
    }

    public function update(Request $request)
    {
        if (!$request->has('name') || $request->name == null) {
            $data['msg']  = 'Name cannot be null';
            $data['code'] = 400;

            return $data;
        }

        $request->validate([
            'name'         => 'required | string',
            'is_featured'  => 'sometimes | nullable | string',
            'show_in_home' => 'sometimes | nullable | string',
        ]);

        try {
            $category                   = NewsCategory::where('slug', $request->slug)->first();
            $category->name             = $request->name;
            $category->is_featured      = $request->has('is_featured') && $request->is_featured == 'featured' ? true : false;
            $category->is_home_category = $request->has('show_in_home') && $request->show_in_home == 'show' ? true : false;
            $category->status           = $request->status == 'Active' ? true : false;
            $category->save();

            $data['msg']  = 'Category successfully updated';
            $data['code'] = 200;

            return $data;
        } catch (\Exception $exception) {
            Log::error('NewsCategory#Update: ' . $exception->getMessage());

            $data['msg']  = 'Something went wrong';
            $data['code'] = 400;

            return $data;
        }
    }

    public function destroy($slug)
    {
        try {
            $category = NewsCategory::where('slug', $slug)->first();

            $category->delete();

            toastr()->success(__('Category deleted successfully'));

            return redirect()->back();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            toastr()->error(__('Something went wrong!'));

            return redirect()->back();
        }
    }
}
