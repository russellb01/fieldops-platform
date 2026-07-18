<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fieldops_work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_number')->unique();
            $table->foreignId('customer_id')->constrained('fieldops_customers')->cascadeOnDelete();
            $table->foreignId('service_location_id')->nullable()->constrained('fieldops_service_locations')->nullOnDelete();
            $table->foreignId('equipment_asset_id')->nullable()->constrained('fieldops_equipment_assets')->nullOnDelete();
            $table->foreignId('estimate_id')->nullable()->constrained('fieldops_estimates')->nullOnDelete();
            $table->string('title');
            $table->string('status')->default('new');
            $table->string('priority')->default('normal');
            $table->string('service_type')->nullable();
            $table->string('assigned_to')->nullable();
            $table->dateTime('scheduled_start')->nullable();
            $table->dateTime('scheduled_end')->nullable();
            $table->text('customer_request')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('work_performed')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'scheduled_start']);
            $table->index(['customer_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fieldops_work_orders');
    }
};
