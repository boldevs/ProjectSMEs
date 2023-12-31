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
        Schema::table('sales', function (Blueprint $table) {
            // Check if the column exists before adding it
            if (!Schema::hasColumn('sales', 'particular_client')) {
                $table->unsignedBigInteger('particular_client')->nullable()->after('customer_id');
                // The ->unsignedBigInteger() method creates an unsigned big integer field
                // The ->nullable() method allows the field to accept NULL values
                // The ->after('customer_id') will add the field after the 'customer_id' field in the table
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'particular_client')) {
                $table->dropColumn('particular_client');
            }
        });
    }
};
