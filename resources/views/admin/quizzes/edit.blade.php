<x-admin-layout>
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">クイズ新規登録</h1>
            </div>
            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                <form method="POST" action="" class="flex flex-wrap -m-2">
                    @csrf

                    {{-- 問題文 --}}
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="question" class="leading-7 text-sm text-gray-600">問題文</label>
                            <textarea id="question" name="question" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old('question') }}</textarea>
                        </div>
                        {{-- 問題文のバリデーションエラーメッセージの表示 --}}
                        @error('question')
                            <div class="alert alert-danger text-red-700">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 解説 --}}
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="explanation" class="leading-7 text-sm text-gray-600">解説</label>
                            <textarea id="explanation" name="explanation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old('explanation') }}</textarea>
                        </div>
                        {{-- 解説のバリデーションエラーメッセージの表示 --}}
                        @error('explanation')
                            <div class="alert alert-danger text-red-700">{{ $message }}</div>
                        @enderror
                    </div>

                    @for ($i = 1; $i <= 4; $i++)
                        {{-- 選択肢 --}}
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="content{{ $i }}" class="leading-7 text-sm text-gray-600">選択肢{{ $i }}</label>
                                <input type="text" id="content{{ $i }}" name="content{{ $i }}" value="{{ old('content' . $i) }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            {{-- 選択肢のバリデーションエラーメッセージの表示 --}}
                            @error('content' . $i)
                                <div class="alert alert-danger text-red-700">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 選択肢の正解・不正解 --}}
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="isCorrect{{ $i }}" class="leading-7 text-sm text-gray-600">選択肢の正解・不正解{{ $i }}</label>
                                <select
                                    id="isCorrect{{ $i }}"
                                    name="isCorrect{{ $i }}"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <option value="1" {{ old('isCorrect' . $i) === '1' ? 'selected' : '' }}>正解</option>
                                    <option value="0" {{ old('isCorrect' . $i) === '0' ? 'selected' : '' }}>不正解</option>
                                </select>
                            </div>
                            {{-- 選択肢の正解・不正解のバリデーションエラーメッセージの表示 --}}
                            @error('isCorrect' . $i)
                                <div class="alert alert-danger text-red-700">{{ $message }}</div>
                            @enderror
                        </div>
                    @endfor

                    <div class="p-2 w-full">
                        <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                            登録
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-admin-layout>
