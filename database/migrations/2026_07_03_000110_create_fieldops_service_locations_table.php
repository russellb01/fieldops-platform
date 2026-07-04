<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fieldops_service_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('fieldops_customers')->cascadeOnDelete();
            $table->string('location_name')->nullable();
            $table->string('address');
            $table->string('city')->nullable();
            $table->string('state')->default('TN');
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('access_notes')->nullable();
            $table->text('site_notes')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fieldops_service_locations');
    }
};
