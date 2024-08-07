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
        Schema::create('file_manager_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('file_manager_folders')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('file_manager_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folder_id');
            $table->foreign('folder_id')->references('id')->on('file_manager_folders')->onDelete('cascade');
            $table->string('name');
            $table->string('mime_type');
            $table->bigInteger('size')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_manager_folders');
        Schema::dropIfExists('file_manager_media');
    }
};
