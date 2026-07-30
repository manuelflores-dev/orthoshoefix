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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();

            // The customer the shoes belong to, and the staff member that took them in.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('service_type');
            $table->string('shoe_type');
            $table->text('description');
            $table->string('status')->default('received');

            $table->decimal('estimated_price', 8, 2)->nullable();

            // Contact details as captured for this specific order.
            $table->string('contact_name');
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();

            $table->date('received_at');
            $table->date('estimated_delivery_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->text('internal_notes')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index(['status', 'received_at']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
