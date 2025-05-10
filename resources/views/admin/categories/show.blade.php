<x-admin-layout>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">
                    {{ $category->name }}
                </h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                    {{ $category->description }}
                </p>
            </div>

            <div class="sm:w-1/2 ml-auto">
                <div class="flex flex-wrap -m-2">
                    <div class="p-2 w-full">
                        <button
                            {{-- onclick="location.href='{{ route('admin.categories.create') }}'" --}}
                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                            カテゴリー編集
                        </button>
                    </div>
                </div>
            </div>

            <div class="sm:w-1/2 ml-auto mt-2">
                <div class="flex flex-wrap -m-2">
                    <div class="p-2 w-full">
                        <button
                            onclick="location.href='{{ route('admin.categories.quizzes.create', ['categoryId' => $category->id]) }}'"
                            class="flex mx-auto text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">
                            クイズ新規登録
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-5 mx-auto">
            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">クイズ問題文</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">更新日時</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">編集</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">削除</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quizzes as $quiz)
                            <tr>
                                <td class="px-4 py-3">{{ $quiz->id }}</td>
                                {{-- 問題文：はじめの10文字だけを表示 --}}
                                <td class="px-4 py-3">
                                    {{ Str::length($quiz->question) > 10 ? mb_substr($quiz->question, 0, 10) . '...' : $quiz->question }}
                                </td>
                                <td class="px-4 py-3">{{ $quiz->updated_at }}</td>
                                <td class="px-4 py-3 text-lg text-gray-900">
                                    <button
                                        {{-- クイズ編集画面に遷移 --}}
                                        onclick="location.href='{{ route('admin.categories.edit', ['categoryId' => $category->id]) }}'"
                                        class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                        編集
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-lg text-gray-900">
                                    <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                        削除
                                    </button>
                                </td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</x-admin-layout>
