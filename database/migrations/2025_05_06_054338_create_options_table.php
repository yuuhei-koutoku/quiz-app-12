<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')
                ->constrained()       // quizzesテーブルのidカラムと紐づける
                ->onUpdate('cascade') // 親テーブルのレコードが更新されたとき、同時に更新される
                ->onDelete('cascade') // 親テーブルのレコードが削除されたとき、同時に削除される
                ->comment('クイズID');
            $table->string('content')->comment('選択肢の文章');
            $table->smallInteger('is_correct')->comment('0:不正解 1:正解');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
