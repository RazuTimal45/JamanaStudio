<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slogan');
            $table->string('about_website')->nullable();
            $table->string('image')->nullable();
            $table->string('logo_header');
            $table->string('logo_footer')->nullable();
            $table->string('hero_image');
            $table->string('fav_icon')->nullable();
            $table->string('email');
            $table->string('optional_email')->nullable();
            $table->bigInteger('phone');
            $table->bigInteger('mobile')->nullable();
            $table->string('address');
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->softDeletes();
            $table->string('meta_title');
            $table->text('meta_description');
            $table->text('meta_keyword');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
