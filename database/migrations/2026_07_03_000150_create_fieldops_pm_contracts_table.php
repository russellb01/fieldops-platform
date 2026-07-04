<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fieldops_pm_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->foreignId('customer_id')->constrained('fieldops_customers')->cascadeOnDelete();
            $table->foreignId('service_location_id')->nullable()->constrained('fieldops_service_locations')->nullOnDelete();
            $table->string('title');
            $table->string('status')->default('active');
            $table->string('frequency')->default('quarterly');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->decimal('monthly_price', 12, 2)->default(0);
            $table->decimal('annual_value', 12, 2)->default(0);
            $table->text('scope')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status', 'next_service_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fieldops_pm_contracts');
    }
};
