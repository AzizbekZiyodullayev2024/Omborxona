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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('table_name')->nullable(false);
            $table->string('field_name')->nullable(false);
            $table->bigInteger('field_id')->nullable(false);
            $table->text('field_value')->nullable(false);
            $table->string('language_url');
            $table->unique(['table_name', 'field_name', 'field_id', 'language_url']);
            $table->foreign('language_url')->references('url')->on('languages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
