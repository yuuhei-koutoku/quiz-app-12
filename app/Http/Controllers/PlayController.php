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
        // セッションの削除
        session()->forget('resultArray');

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
        // $quizzes = $category->quizzes->toArray();
        // shuffle($quizzes);
        // $quiz = $quizzes[0];

        // セッションに保存されているクイズIDの配列を取得
        $resultArray = session('resultArray');
        // 初回アクセス時はセッションに保存されたクイズIDの配列がないため、クイズIDの配列を作成
        if (is_null($resultArray)) {
            // クイズIDを全て抽出する
            $quizIds = $category->quizzes->pluck('id')->toArray();

            // クイズIDの配列をランダムに入れ返す
            shuffle($quizIds);

            $resultArray = [];
            foreach ($quizIds as $quizId) {
                $resultArray[] = [
                    'quizId' => $quizId,
                    'result' => null,
                ];
            };

            // クイズIDの配列をセッションに保存
            session(['resultArray' => $resultArray]);
        }

        // $resultArrayの中で、resultがnullのもののうち、最初のデータを選ぶ
        $noAnswerResult = collect($resultArray)->filter(function ($item) {
            return $item['result'] === null;
        })->first();

        if (!$noAnswerResult) {
            // 全てのクイズに解答済みの場合は、リザルト画面にリダイレクト
            return redirect()->route('categories.quizzes.result', ['categoryId' => $categoryId]);
        }

        // クイズIDに紐づくクイズを取得
        $quiz = $category->quizzes->firstWhere('id', $noAnswerResult['quizId'])->toArray();

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
        $quizId          = $request->quizId;
        $selectedOptions = $request->optionId === null ? [] : $request->optionId;

        // カテゴリーに紐づくクイズと選択肢を取得する
        $category = Category::with('quizzes.options')->findOrFail($categoryId);
        $quiz = $category->quizzes->firstWhere('id', $quizId);
        $quizOptions = $quiz->options->toArray();

        $isCorrectAnswer = $this->isCorrectAnswer($selectedOptions, $quizOptions);

        // セッションからクイズIDと解答情報を取得
        $resultArray = session('resultArray');
        foreach ($resultArray as $index => $result) {
            if ($result['quizId'] === (int)$quizId) {
                $resultArray[$index]['result'] = $isCorrectAnswer;
                break;
            }
        }
        // 解答結果をセッションに保存（上書き）する
        session(['resultArray' => $resultArray]);

        return view('play.answer', [
            'categoryId'      => $categoryId,
            'quiz'            => $quiz->toArray(),
            'quizOptions'     => $quizOptions,
            'selectedOptions' => $selectedOptions,
            'isCorrectAnswer' => $isCorrectAnswer,
        ]);
    }

    /**
     * リザルト画面表示
     */
    public function result(Request $request, int $categoryId)
    {
        dd($categoryId, $request);
    }

    /**
     * プレイヤーの解答が正解か不正解かを判定
     */
    private function isCorrectAnswer(array $selectedOptions, array $quizOptions)
    {
        // クイズの選択肢から正解の選択肢を抽出し、そのidを全て取得する
        $correctOptions = array_filter($quizOptions, function ($option) {
            return $option['is_correct'] === 1;
        });

        // idの数字だけを抽出する
        $correctOptionIds = array_map(function ($option) {
            return $option['id'];
        }, $correctOptions);

        // プレイヤーが選んだ選択肢の個数と正解の選択肢の個数が一致するかを判定する
        if (count($selectedOptions) !== count($correctOptionIds)) {
            return false;
        }

        // プレイヤーが選んだ選択肢のid番号と正解のidが全て一致することを判定する
        foreach ($selectedOptions as $selectedOption) {
            if (!in_array((int)$selectedOption, $correctOptionIds)) {
                return false;
            }
        }

        // 正解であることを返す
        return true;

        // 自分で考えたコード
        // // 配列の要素をintにキャストする
        // $selectedOptions = array_map('intval', $selectedOptions);

        // // クイズの選択肢から正解の選択肢を抽出し、そのidを全て取得する
        // $correctOptions = [];
        // foreach ($quizOptions as $quizOption) {
        //     if ($quizOption['is_correct'] === 1) {
        //         $correctOptions[] = $quizOption['id'];
        //     }
        // }

        // // プレイヤーの解答と正解・不正解の情報を比較する
        // $result = false;
        // if ($selectedOptions === $correctOptions) $result = true;

        // return $result;
    }
}
