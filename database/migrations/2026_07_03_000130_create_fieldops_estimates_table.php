<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fieldops_estimates', function (Blueprint $table) {
            $table->id();
            $table->string('estimate_number')->unique();
            $table->foreignId('customer_id')->constrained('fieldops_customers')->cascadeOnDelete();
            $table->foreignId('service_location_id')->nullable()->constrained('fieldops_service_locations')->nullOnDelete();
            $table->string('title');
            $table->string('status')->default('draft');
            $table->text('issue_summary')->nullable();
            $table->text('scope_of_work')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->date('valid_until')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
        });

        Schema::create('fieldops_estimate_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estimate_id')->constrained('fieldops_estimates')->cascadeOnDelete();
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
        Schema::dropIfExists('fieldops_estimate_items');
        Schema::dropIfExists('fieldops_estimates');
    }
};
