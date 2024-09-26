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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile', 2000)->nullable();
            $table->integer('balance')->default(0);
            $table->decimal('max_score')->default(0.00);
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('payment_type_id')->nullable(); // Assuming ID in banks is also an unsigned integer
            $table->string('account_name')->nullable();
            $table->string('account_no')->nullable();
            $table->decimal('commission')->default('0.00');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
