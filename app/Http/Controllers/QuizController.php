<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
use App\Models\Option;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * クイズ新規登録画面表示
     */
    public function create(Request $request, int $categoryId)
    {
        return view('admin.quizzes.create', [
            'categoryId' => $categoryId
        ]);
    }

    /**
     * クイズ新規登録処理
     */
    public function store(StoreQuizRequest $request, int $categoryId)
    {
        // 先にクイズを登録する
        $quiz = new Quiz();
        $quiz->category_id = $categoryId;
        $quiz->question    = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();

        // クイズIDをもとに、選択肢(Option)も登録する
        $options = [
            ['quiz_id' => $quiz->id, 'content' => $request->content1, 'is_correct' => $request->isCorrect1],
            ['quiz_id' => $quiz->id, 'content' => $request->content2, 'is_correct' => $request->isCorrect2],
            ['quiz_id' => $quiz->id, 'content' => $request->content3, 'is_correct' => $request->isCorrect3],
            ['quiz_id' => $quiz->id, 'content' => $request->content4, 'is_correct' => $request->isCorrect4],
        ];

        foreach ($options as $option) {
            $newOption = new Option();
            $newOption->quiz_id    = $option['quiz_id'];
            $newOption->content    = $option['content'];
            $newOption->is_correct = $option['is_correct'];
            $newOption->save();
        }

        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * クイズ編集画面表示
     */
    public function edit(Request $request, int $categoryId, int $quizId)
    {
        $quiz = Quiz::with('category', 'options')->findOrFail($quizId);

        return view('admin.quizzes.edit', [
            'category' => $quiz->category,
            'quiz'     => $quiz,
            'options'  => $quiz->options,
        ]);
    }

    /**
     * クイズ更新処理
     */
    public function update(UpdateQuizRequest $request, int $categoryId, int $quizId)
    {
        // Quizの更新
        $quiz = Quiz::findOrFail($quizId);
        $quiz->question    = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();

        // Optionの更新
        $option1 = Option::findOrFail((int)$request->optionId1);
        $option1->content    = $request->content1;
        $option1->is_correct = $request->isCorrect1;
        $option1->save();
        $option2 = Option::findOrFail((int)$request->optionId2);
        $option2->content    = $request->content2;
        $option2->is_correct = $request->isCorrect2;
        $option2->save();
        $option3 = Option::findOrFail((int)$request->optionId3);
        $option3->content    = $request->content3;
        $option3->is_correct = $request->isCorrect3;
        $option3->save();
        $option4 = Option::findOrFail((int)$request->optionId4);
        $option4->content    = $request->content4;
        $option4->is_correct = $request->isCorrect4;
        $option4->save();
        // カテゴリー詳細画面にリダイレクト
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
