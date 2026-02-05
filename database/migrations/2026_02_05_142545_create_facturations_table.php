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
        Schema::create('facturations', function (Blueprint $table) {
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

            $table->string('validation_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_status')->nullable();
            $table->string('status_change_reason')->nullable();

            $table->string('amount_excluding_tax_invoice_currency')->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('amount_excluding_tax_local_currency')->nullable();

            $table->string('billed_third_party')->nullable();
            $table->string('client')->nullable();
            $table->string('billed_third_party_account')->nullable();
            $table->string('sens')->nullable();

            $table->string('item_number')->nullable();
            $table->string('item_type')->nullable();
            $table->string('cycle')->nullable();
            $table->string('commodity')->nullable();

            $table->string('weight')->nullable();
            $table->string('volume')->nullable();
            $table->string('normalized_size')->nullable();
            $table->string('teu')->nullable();
            $table->string('unit')->nullable();
            $table->string('is_reefer')->nullable();

            $table->string('account_number')->nullable();
            $table->string('invoice_line')->nullable();
            $table->string('description')->nullable();

            $table->string('contract_name')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('section')->nullable();
            $table->string('rubric')->nullable();
            $table->string('disbursement_code')->nullable();

            $table->string('debit_invoice_currency')->nullable();
            $table->string('credit_invoice_currency')->nullable();

            $table->string('amount_signed_local_currency')->nullable();
            $table->string('cap_amount_signed_local_currency')->nullable();

            $table->string('call_number')->nullable();
            $table->string('vessel_name')->nullable();
            $table->string('availability_date')->nullable();
            $table->string('bl_number')->nullable();
            $table->string('final_country_destination')->nullable();
            $table->string('invoice_comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturations');
    }
};
