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
        //Schema means table. It is a class that is used to create tables.
        //create() is a method that is used to create a table.
        
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->longText('image');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Foreign key
            /**
             * Explanation:
             * 1. The foreign key is the user_id column in the posts table.
             * 2. The reference is the id column in the users table.
             * 3. foreign key should have the same data type as the reference to which it is pointing.
             */
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
