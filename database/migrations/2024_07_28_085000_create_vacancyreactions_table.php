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
        Schema::create('vacancyreactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key to vacancy
            $table->unsignedBigInteger('vacancy_id')->nullable();
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');
            
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
            
            // Personal information
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('sex')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            
            // Address information
            $table->string('address')->nullable();
            $table->string('address_nr')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->date('birthdate')->nullable();
            
            // Message information
            $table->string('subject')->nullable();
            $table->text('comment')->nullable();
            $table->string('internal_vacancyreaction')->nullable();
            $table->string('ip')->nullable();
            
            // Flexible option fields
            $table->text('option_1')->nullable();
            $table->text('option_2')->nullable();
            $table->text('option_3')->nullable();
            $table->text('option_4')->nullable();
            $table->text('option_5')->nullable();
            $table->text('option_6')->nullable();
            
            // Additional data
            $table->longText('data')->nullable();
            
            // Indexes
            $table->index(['company_id', 'host']);
            $table->index('locale');
            $table->index('active');
            $table->index('vacancy_id');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancyreactions');
    }
};
