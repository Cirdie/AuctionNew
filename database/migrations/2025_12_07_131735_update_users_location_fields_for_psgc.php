<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Drop old foreign keys and columns
            if (Schema::hasColumn('users', 'country_id')) {
                $table->dropForeign(['country_id']);
                $table->dropColumn('country_id');
            }

            if (Schema::hasColumn('users', 'state_id')) {
                $table->dropForeign(['state_id']);
                $table->dropColumn('state_id');
            }

            if (Schema::hasColumn('users', 'city_id')) {
                $table->dropForeign(['city_id']);
                $table->dropColumn('city_id');
            }

            // Add PSGC location fields
            $table->string('country')->default('PH')->after('zip_code');

            $table->string('province')->nullable()->after('country');
            $table->string('province_code')->nullable()->after('province');

            $table->string('city')->nullable()->after('province_code');
            $table->string('city_code')->nullable()->after('city');

            $table->string('barangay')->nullable()->after('city_code');
            $table->string('barangay_code')->nullable()->after('barangay');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Remove PSGC fields
            $table->dropColumn([
                'country',
                'province',
                'province_code',
                'city',
                'city_code',
                'barangay',
                'barangay_code',
            ]);

            // Restore old columns (optional)
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->foreignId('city_id')->nullable()->constrained('cities');
        });
    }
};
