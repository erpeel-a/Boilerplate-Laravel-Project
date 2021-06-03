<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
           $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('categories')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('author')->constrained('users')->onUpdate('restrict')->onDelete('restrict');
            $table->string('thumbnail');
            $table->text('content');
            $table->string('slug');
            $table->enum('status', ['draft', 'publish', 'archive'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
