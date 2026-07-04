<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fieldops_equipment_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('fieldops_customers')->cascadeOnDelete();
            $table->foreignId('service_location_id')->nullable()->constrained('fieldops_service_locations')->nullOnDelete();
            $table->string('asset_type')->default('equipment');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('install_date')->nullable();
            $table->date('warranty_expires_at')->nullable();
            $table->string('refrigerant_type')->nullable();
            $table->string('filter_size')->nullable();
            $table->string('belt_size')->nullable();
            $table->string('voltage')->nullable();
            $table->string('phase')->nullable();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'asset_type', 'status']);
            $table->index('serial_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fieldops_equipment_assets');
    }
};
