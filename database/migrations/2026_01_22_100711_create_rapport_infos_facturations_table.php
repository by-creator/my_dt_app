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
        Schema::create('rapport_infos_facturations', function (Blueprint $table) {
            $table->id();
             $table->string('terminal_name')->nullable();
            $table->string('company')->nullable();
            $table->string('terminal')->nullable();
            $table->string('category_type')->nullable();
            $table->string('invoice_type_description')->nullable();
            $table->string('service')->nullable();
            $table->string('shipowner')->nullable();
            $table->string('line_operator')->nullable();
            $table->string('category')->nullable();

            $table->date('validation_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_status')->nullable();
            $table->string('status_change_reason')->nullable();

            $table->decimal('amount_excluding_tax_invoice_currency', 15, 3)->default(0);
            $table->string('currency', 10)->nullable();
            $table->decimal('amount_excluding_tax_local_currency', 15, 3)->default(0);

            $table->string('billed_third_party')->nullable();
            $table->string('client')->nullable();
            $table->string('billed_third_party_account')->nullable();
            $table->string('sens')->nullable();

            $table->string('item_number')->nullable();
            $table->string('item_type')->nullable();
            $table->string('cycle')->nullable();
            $table->string('commodity')->nullable();

            $table->decimal('weight', 15, 3)->default(0);
            $table->decimal('volume', 15, 3)->default(0);
            $table->string('normalized_size')->nullable();
            $table->integer('teu')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('is_reefer')->default(false);

            $table->string('account_number')->nullable();
            $table->integer('invoice_line')->nullable();
            $table->text('description')->nullable();

            $table->string('contract_name')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('section')->nullable();
            $table->string('rubric')->nullable();
            $table->string('disbursement_code')->nullable();

            $table->decimal('debit_invoice_currency', 15, 3)->default(0);
            $table->decimal('credit_invoice_currency', 15, 3)->default(0);

            $table->decimal('amount_signed_local_currency', 15, 3)->default(0);
            $table->decimal('cap_amount_signed_local_currency', 15, 3)->default(0);

            $table->string('call_number')->nullable();
            $table->string('vessel_name')->nullable();
            $table->date('availability_date')->nullable();
            $table->string('bl_number')->nullable();
            $table->string('final_country_destination')->nullable();
            $table->text('invoice_comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapport_infos_facturations');
    }
};
