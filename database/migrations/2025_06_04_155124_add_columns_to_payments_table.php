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
        Schema::table('payments', function (Blueprint $table) {
            // Add invoice_number column after invoice_id, make it nullable for existing records
            $table->string('invoice_number')->nullable()->after('invoice_id');
            
            // Add amount column after invoice_number with default 0
            $table->decimal('amount', 10, 2)->default(0)->after('invoice_number');
            
            // Rename note to description for consistency
            $table->renameColumn('note', 'description');
        });

        // Update existing records with invoice numbers from related invoices
        DB::statement('
            UPDATE payments p
            INNER JOIN invoices i ON p.invoice_id = i.id
            SET p.invoice_number = i.invoice_number,
                p.amount = i.amount_incl_vat
            WHERE p.invoice_number IS NULL
        ');

        // After updating, remove nullable and default constraints
        Schema::table('payments', function (Blueprint $table) {
            $table->string('invoice_number')->nullable(false)->change();
            $table->decimal('amount', 10, 2)->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['invoice_number', 'amount']);
            $table->renameColumn('description', 'note');
        });
    }
};
