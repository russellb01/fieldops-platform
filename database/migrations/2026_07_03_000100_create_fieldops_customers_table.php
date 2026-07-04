<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fieldops_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_type')->default('residential');
            $table->string('company_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('display_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->default('TN');
            $table->string('billing_postal_code')->nullable();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['customer_type', 'status']);
            $table->index('display_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fieldops_customers');
    }
};
