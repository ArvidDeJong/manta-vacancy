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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // CMS tracking fields
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('host')->nullable();
            $table->integer('pid')->nullable();
            $table->string('locale')->nullable();

            // Status fields
            $table->boolean('active')->default(true);
            $table->integer('sort')->default(1);

            // Content fields
            $table->string('title')->nullable();
            $table->string('title_2')->nullable();
            $table->string('title_3')->nullable();
            $table->string('slug')->nullable();

            $table->string('employment_type')->nullable();
            $table->string('location')->nullable();

            // SEO fields
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('tags')->nullable();

            // Main content
            $table->longText('excerpt')->nullable();
            $table->longText('content')->nullable();

            // Date fields
            $table->datetime('show_from')->nullable();
            $table->datetime('show_till')->nullable();

            // Vacancy specific fields
            $table->text('summary_requirements')->nullable();

            // System fields
            $table->string('administration')->nullable()->comment('Administration column');
            $table->string('identifier')->nullable()->comment('Identifier column');

            // Email configuration
            $table->json('email_receivers')->nullable();

            // Flexible text fields
            $table->text('text_1')->nullable();
            $table->text('text_2')->nullable();
            $table->text('text_3')->nullable();
            $table->text('text_4')->nullable();

            // Email templates
            $table->longText('email_client')->nullable();
            $table->longText('email_subject_client')->nullable();
            $table->longText('email_subject_webmaster')->nullable();
            $table->longText('email_webmaster')->nullable();

            // Additional data
            $table->longText('data')->nullable();

            // Indexes
            $table->index(['company_id', 'host']);
            $table->index('locale');
            $table->index('active');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
