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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('company')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product')->nullable();
            $table->string('location')->nullable();
            $table->string('site_type')->nullable();
            $table->string('timeline')->nullable();
            $table->string('budget_range')->nullable();
            $table->text('details');
            $table->boolean('needs_site_survey')->default(false);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->enum('status', ['new', 'contacted', 'quoted', 'won', 'lost'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
