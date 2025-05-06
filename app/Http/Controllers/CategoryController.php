<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 管理画面トップページ 兼 カテゴリー一覧表示
     */
    public function top()
    {
        $categories = Category::get();

        return view('admin.top', [
            'categories' => $categories
        ]);
    }

    /**
     * カテゴリー新規登録画面表示
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * カテゴリー新規登録処理
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.top');
    }

    /**
     * カテゴリー詳細画面表示
     */
    public function show(Request $request, int $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        return view('admin.categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
