<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct to category page
    public function index()
    {
        $category = Category::get();
        return view('admin.category.index', compact('category'));
    }

    //create category
    public function createCategory(Request $request)
    {
        $validator = $this->categoryValidationCheck($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $this->getCategoryData($request);
        $category = Category::create($data);
        return back();
    }

    //delete category
    public function deleteCategory($id)
    {
        Category::where('category_id', $id)->delete();
        return redirect()->route('admin#category')->with(['deleteSuccess' => 'Category deleted successfully']);
    }

    //search category
    public function searchCategory(Request $request)
    {
        $category = Category::where('title', 'like', '%' . $request->categorySearch . '%')->get();
        return view('admin.category.index', compact('category'));
    }

    //category edit page
    public function categoryEditPage($id)
    {
        $category = Category::get();
        $updateData = Category::where('category_id', $id)->first();
        return view('admin.category.edit', compact('category', 'updateData'));
    }

    //category update
    public function categoryUpdate($id, Request $request)
    {
        $validator = $this->categoryValidationCheck($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = $this->getUpdateData($request);
        Category::where('category_id', $id)->update($updateData);
        return redirect()->route('admin#category')->with(['updateSuccess' => 'Category Updated Successfully']);
    }

    //getCategoryData
    private function getCategoryData($request)
    {
        return [
            'title' => $request->categoryName,
            'description' => $request->categoryDescription,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    //category validation check
    private function categoryValidationCheck($request)
    {
        $validationRules = [
            'categoryName' => 'required',
            'categoryDescription' => 'required',
        ];
        return Validator::make($request->all(), $validationRules);
    }

    //get category update data
    private function getUpdateData($request)
    {
        return [
            'title' => $request->categoryName,
            'description' => $request->categoryDescription,
            'updated_at' => Carbon::now()
        ];
    }
}
