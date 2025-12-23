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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index(); // blog, page, contract, faq
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('blocks'); // CRITICAL: Block data stored as JSON
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
