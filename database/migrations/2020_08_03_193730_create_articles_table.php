<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->string('title');
            $table->text('content');
            $table->string('picture');
            $table->string('position');
            $table->text('description');
            $table->text('keywoard');
            $table->bigInteger('likes_count')->default(0);
            $table->bigInteger('dislikes_count')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('users')
                ->on('id')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('categories')
                ->on('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
