<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fieldops_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('fieldops_customers')->cascadeOnDelete();
            $table->foreignId('service_location_id')->nullable()->constrained('fieldops_service_locations')->nullOnDelete();
            $table->foreignId('estimate_id')->nullable()->constrained('fieldops_estimates')->nullOnDelete();
            $table->string('title');
            $table->string('status')->default('draft');
            $table->date('service_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->decimal('balance', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
        });

        Schema::create('fieldops_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('fieldops_invoices')->cascadeOnDelete();
            $table->string('line_type')->default('service');
            $table->text('description');
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fieldops_invoice_items');
        Schema::dropIfExists('fieldops_invoices');
    }
};
