<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Product;
use App\Model\Translation;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $categories = User::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%");
                    $q->orWhere('accountId', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $categories = User::where('name', '!=', null);
        }


        $categories = $categories->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.category.index', compact('categories', 'search'));
    }

    function sub_index()
    {
        $categories = Category::with(['parent'])->where(['position' => 1])->latest()->paginate(Helpers::getPagination());
        return view('admin-views.category.sub-index', compact('categories'));
    }

    public function search(Request $request)
    {
        $key = explode(' ', $request['search']);
        $categories = Category::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->get();
        return response()->json([
            'view' => view('admin-views.category.partials._table', compact('categories'))->render()
        ]);
    }

    function sub_sub_index()
    {
        return view('admin-views.category.sub-sub-index');
    }

    function sub_category_index()
    {
        return view('admin-views.category.index');
    }

    function sub_sub_category_index()
    {
        return view('admin-views.category.index');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        foreach ($request->name as $name) {
            if (strlen($name) > 255) {
                toastr::error(\App\CentralLogics\translate('Name is too long!'));
                return back();
            }
        }

        //uniqueness check
        $cat = Category::where('name', $request->name)->where('parent_id', $request->parent_id ?? 0)->first();
        if (isset($cat)) {
            Toastr::error(\App\CentralLogics\translate(($request->parent_id == null ? 'Category' : 'Sub-category') . ' already exists!'));
            return back();
        }

        //image upload
        if (!empty($request->file('image'))) {
            $image_name = Helpers::upload('category/', 'png', $request->file('image'));
        } else {
            $image_name = 'def.png';
        }
        if (!empty($request->file('banner_image'))) {
            $banner_image_name = Helpers::upload('category/banner/', 'png', $request->file('banner_image'));
        } else {
            $banner_image_name = 'def.png';
        }

        //into db
        $category = new Category();
        $category->name = $request->name[array_search('en', $request->lang)];
        $category->image = $image_name;
        $category->banner_image = $banner_image_name;
        $category->parent_id = $request->parent_id == null ? 0 : $request->parent_id;
        $category->position = $request->position;
        $category->save();

        //translation
        $data = [];
        foreach ($request->lang as $index => $key) {
            if ($request->name[$index] && $key != 'en') {
                array_push($data, array(
                    'translationable_type' => 'App\Model\Category',
                    'translationable_id' => $category->id,
                    'locale' => $key,
                    'key' => 'name',
                    'value' => $request->name[$index],
                ));
            }
        }
        if (count($data)) {
            Translation::insert($data);
        }

        Toastr::success($request->parent_id == 0 ? \App\CentralLogics\translate('Category Added Successfully!') : \App\CentralLogics\translate('Sub Category Added Successfully!'));
        return back();
    }

    public function edit($id)
    {
        $category = User::find($id);
        return view('admin-views.category.edit', compact('category'));
    }

    public function status(Request $request)
    {
        $category = category::find($request->id);
        $category->status = $request->status;
        $category->save();
        Toastr::success($category->parent_id == 0 ? 'Category status updated!' : 'Sub Category status updated!');
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'f_name' => 'required',
        ]);

        $user = User::find($id);
        $user->f_name = $request->f_name;
        $user->account_id = $request->account_id;
        $user->account_balance = $request->account_balance;
        if(!empty($request->pin)){
            $user->pin = $request->pin;
        }
        $user->save();
        Toastr::success(\App\CentralLogics\translate('Category updated successfully!'));
        return back();
    }

    public function delete(Request $request)
    {
        $category = User::find($request->id);
        $category->delete();
        Toastr::success($category->parent_id == 0 ? 'Category removed!' : 'Sub Category removed!');

        return back();
    }
}
