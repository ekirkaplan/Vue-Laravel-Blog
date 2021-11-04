<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('blogId')->unsigned();
            $table->string('name');
            $table->string('email',150);
            $table->string('title',50);
            $table->text('content');
            $table->boolean('status')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('blogId')->references('id')->on('blog')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
