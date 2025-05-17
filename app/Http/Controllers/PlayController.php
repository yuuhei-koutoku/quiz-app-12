<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PlayController extends Controller
{
    /**
     * プレイ画面トップページ
     */
    public function top()
    {
        $categories = Category::all();

        return view('play.top', [
            'categories' => $categories,
        ]);
    }

    /**
     * クイズスタート画面表示
     */
    public function categories(Request $request, int $categoryId)
    {
        $category = Category::withCount('quizzes')->findOrFail($categoryId);

        return view('play.start', [
            'category'     => $category,
            'quizzesCount' => $category->quizzes_count,
        ]);
    }

    /**
     * クイズ出題画面
     */
    public function quizzes(Request $request, int $categoryId)
    {
        // カテゴリーに紐づくクイズと選択肢を全て取得する
        $category = Category::with('quizzes.options')->findOrFail($categoryId);

        // クイズをランダムで選ぶ
        $quizzes = $category->quizzes->toArray();
        shuffle($quizzes);
        $quiz = $quizzes[0];

        return view('play.quizzes', [
            'categoryId' => $categoryId,
            'quiz'       => $quiz
        ]);
    }

    /**
     * クイズ解答画面
     */
    public function answer(Request $request, int $categoryId)
    {
        $quizId   = $request->quizId;
        $optionId = $request->optionId;

        return view('play.answer');
    }
}
