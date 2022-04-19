<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsCategoryPivot;
use App\Rules\ImageSizeValidation;
use App\Rules\ImageTypeValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{

    public function index()
    {
        $data['title'] = 'News';
        $data['news']  = News::with('categories')->latest()->get();

        return view('admin.news.index', $data);
    }

    public function create()
    {
        $data['title']      = 'Add News';
        $data['categories'] = NewsCategory::where('status', true)->orderBy('name', 'ASC')->get();

        return view('admin.news.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required | string',
            'reporter_name'   => 'sometimes | nullable | string',
            'categories.*'    => 'required | distinct | min:1',
            'news_content'    => 'required',
            'is_featured'     => 'sometimes | nullable | string',
            'show_in_home'    => 'sometimes | nullable | string',
            'is_highest_read' => 'sometimes | nullable | string',
            'status'          => 'sometimes | nullable | string',
            'cover_photo'     => [
                'image', 'required',
                new ImageSizeValidation(),
                new ImageTypeValidation(),
            ],
        ]);

        DB::beginTransaction();
        try {
            $news                  = new News();
            $news->title           = $request->title;
            $news->slug            = generate_slug($request->title);
            $news->reporter_name   = $request->reporter_name;
            $news->content         = $request->news_content;
            $news->status          = $request->has('status') && $request->status == 'Active' ? true : false;
            $news->is_featured     = $request->has('is_featured') && $request->is_featured == 'featured' ? true : false;
            $news->is_home_news    = $request->has('show_in_home') && $request->show_in_home == 'show' ? true : false;
            $news->is_highest_read = $request->has('is_highest_read') && $request->is_highest_read == 'highest_read' ? true : false;
            if ($request->has('cover_photo')) {
                $news->cover_photo = file_upload($request->cover_photo, 'news');
            }
            $news->save();

            foreach ($request->categories as $category) {
                $news_category              = new NewsCategoryPivot();
                $news_category->news_id     = $news->id;
                $news_category->category_id = $category;
                $news_category->save();
            }

            DB::commit();

            toastr()->success(__('News created successfully'));

            return redirect()->route('news.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('News#Create: ' . $exception->getMessage());
            toastr()->error(__('Something went wrong!'));

            return redirect()->back();
        }
    }

    public function edit($slug)
    {
        $data['title']             = 'Edit News';
        $data['categories']        = NewsCategory::where('status', true)->orderBy('name', 'ASC')->get();
        $data['news']              = News::where('slug', $slug)->first();
        $data['news_category_ids'] = NewsCategoryPivot::where('news_id', $data['news']->id)->pluck('category_id')->toArray();

        return view('admin.news.edit', $data);
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'title'           => 'required | string',
            'reporter_name'   => 'sometimes | nullable | string',
            'categories.*'    => 'required | distinct | min:1',
            'news_content'    => 'required',
            'is_featured'     => 'sometimes | nullable | string',
            'show_in_home'    => 'sometimes | nullable | string',
            'is_highest_read' => 'sometimes | nullable | string',
            'status'          => 'sometimes | nullable | string',
            'cover_photo'     => [
                'image', 'sometimes', 'nullable', 'required',
                new ImageSizeValidation(),
                new ImageTypeValidation(),
            ],
        ]);

        DB::beginTransaction();
        try {
            $news                  = News::where('slug', $slug)->first();
            $news->title           = $request->title;
            $news->reporter_name   = $request->reporter_name;
            $news->content         = $request->news_content;
            $news->status          = $request->has('status') && $request->status == 'Active' ? true : false;
            $news->is_featured     = $request->has('is_featured') && $request->is_featured == 'featured' ? true : false;
            $news->is_home_news    = $request->has('show_in_home') && $request->show_in_home == 'show' ? true : false;
            $news->is_highest_read = $request->has('is_highest_read') && $request->is_highest_read == 'highest_read' ? true : false;
            if ($request->has('cover_photo')) {
                if ($news->cover_photo != null && file_exists($news->cover_photo)) {
                    unlink_file($news->cover_photo);
                }
                $news->cover_photo = file_upload($request->cover_photo, 'news');
            }
            $news->save();

            NewsCategoryPivot::where('news_id', $news->id)->delete();
            foreach ($request->categories as $category) {
                $news_category              = new NewsCategoryPivot();
                $news_category->news_id     = $news->id;
                $news_category->category_id = $category;
                $news_category->save();
            }

            DB::commit();

            toastr()->success(__('News updated successfully'));

            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('News#Update: ' . $exception->getMessage());
            toastr()->error(__('Something went wrong!'));

            return back();
        }
    }

    public function destroy($slug)
    {
        DB::beginTransaction();
        try {
            $news = News::where('slug', $slug)->first();
            if ($news->cover_photo != null && file_exists($news->cover_photo)) {
                unlink_file($news->cover_photo);
            }
            NewsCategoryPivot::where('news_id', $news->id)->delete();
            $news->delete();
            DB::commit();

            toastr()->success(__('News deleted successfully'));

            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            toastr()->error(__('Something went wrong!'));

            return back();
        }
    }
}
