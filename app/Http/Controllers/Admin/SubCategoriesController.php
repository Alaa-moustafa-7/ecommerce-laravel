<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\subCategoriesRequest;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    public function index()
    {
        $default_lang = get_default_lang();
        $categories = SubCategory::where('translation_lang', $default_lang)
            ->Selection()->get();
        return view('admin.subcategories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.subcategories.create');
    }

    public function store(subCategoriesRequest $request)
    {
        // return $request;

        $sub_categories = collect($request->category);
        $filter = $sub_categories->filter(function ($key, $value) {
            return $key['abbr'] == get_default_lang();
        });

        return $default_category = array_values($filter->all());

        $filePath = '';
        if ($request->has('photo')) {
            $filePath = uploadImage('subcategories', $request->photo);
        }

        return $default_categoty_id::insertGetId([

            'category_id' => $default_category['category_id'],
            'translation_lang' => $default_category['abbr'],
            'translation_of' => 0,
            'name' => $default_category['name'],
            'photo' => $filePath

        ]);

        return redirect()->back()->with(['success' => 'تم الحفظ بنجاح']);
    }
}
