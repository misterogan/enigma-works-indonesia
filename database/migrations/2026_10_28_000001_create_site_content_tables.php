<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('group')->default('software');
            $table->string('layer')->nullable();
            $table->string('name');
            $table->text('short')->nullable();
            $table->string('badge')->nullable();
            $table->string('icon')->default('pulse');
            $table->json('tags')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->string('h1')->nullable();
            $table->text('intro')->nullable();
            $table->json('points')->nullable();
            $table->json('faqs')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->boolean('has_page')->default(true);
            $table->boolean('is_main')->default(false);
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->string('h1')->nullable();
            $table->text('intro')->nullable();
            $table->text('body')->nullable();
            $table->json('nearby')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('client');
            $table->string('title');
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->text('summary')->nullable();
            $table->json('facts')->nullable();
            $table->json('checks')->nullable();
            $table->text('quote')->nullable();
            $table->string('quote_by')->nullable();
            $table->string('quote_role')->nullable();
            $table->boolean('quote_approved')->default(false);
            $table->json('sections')->nullable();
            $table->json('service_slugs')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
            $table->boolean('is_own')->default(false);
            $table->text('text')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('description', 320)->nullable();
            $table->string('category')->default('simrs');
            $table->string('cover')->nullable();
            $table->string('author')->default('Tim Enigma Works Indonesia');
            $table->longText('body')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['posts', 'faqs', 'portfolio_items', 'case_studies', 'cities', 'services', 'settings'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
