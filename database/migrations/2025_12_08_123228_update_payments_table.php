<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            // 👉 NEW FIELDS
            if (!Schema::hasColumn('payments', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('amount');
            }

            if (!Schema::hasColumn('payments', 'delivery_address')) {
                $table->text('delivery_address')->nullable()->after('payment_method');
            }

            if (!Schema::hasColumn('payments', 'proof_image')) {
                $table->string('proof_image')->nullable()->after('delivery_address');
            }

            // 👉 REMOVE OLD UNUSED COLUMNS
            $oldColumns = [
                'method',
                'currency',
                'token',
                'card_last4',
                'card_id',
                'client_ip',
                'payer_email',
                'gateway',
                'description',
            ];

            foreach ($oldColumns as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            // Restore old columns if needed
            $table->string('method')->nullable();
            $table->string('currency')->nullable();
            $table->string('token')->nullable();
            $table->string('card_last4')->nullable();
            $table->string('card_id')->nullable();
            $table->string('client_ip')->nullable();
            $table->string('payer_email')->nullable();
            $table->smallInteger('gateway')->nullable();
            $table->text('description')->nullable();

            // Drop new fields
            $table->dropColumn([
                'payment_method',
                'delivery_address',
                'proof_image',
            ]);
        });
    }
};
