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
        Schema::create('rapport_suivi_detail_facturations', function (Blueprint $table) {
            $table->id();

            $table->string('sites')->nullable();
            $table->string('company')->nullable();
            $table->string('terminal')->nullable();
            $table->string('category')->nullable();
            $table->string('invoice_type')->nullable();
            $table->string('service')->nullable();
            $table->string('maritime_dossier')->nullable();
            $table->string('shipowner')->nullable();
            $table->string('operator')->nullable();
            $table->string('record_type')->nullable();

            $table->date('accounting_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('status')->nullable();

            $table->decimal('invoice_amount', 15, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->decimal('invoice_amount_local', 15, 2)->nullable();

            $table->string('billed_customer')->nullable();
            $table->string('client')->nullable();
            $table->string('customer_account')->nullable();

            $table->string('item_line')->nullable();
            $table->string('way')->nullable();
            $table->string('item')->nullable();
            $table->string('sens')->nullable();
            $table->string('item_type')->nullable();
            $table->string('item_code')->nullable();

            $table->string('full_empty')->nullable();
            $table->string('reefer_dry')->nullable();
            $table->string('commodity')->nullable();
            $table->string('commodity_category')->nullable();
            $table->string('hazardous_class')->nullable();
            $table->string('out_of_gauge')->nullable();

            $table->decimal('weight', 15, 3)->nullable();
            $table->decimal('volume', 15, 3)->nullable();
            $table->integer('teu_20')->nullable();
            $table->integer('teu_40')->nullable();
            $table->integer('teus')->nullable();

            $table->string('vehicle')->nullable();
            $table->string('lots')->nullable();
            $table->decimal('invoiced_quantity', 15, 3)->nullable();
            $table->string('unit')->nullable();

            $table->string('line')->nullable();
            $table->text('description')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('account')->nullable();
            $table->string('section')->nullable();
            $table->string('rubric')->nullable();
            $table->string('destination')->nullable();

            $table->boolean('disbursement')->nullable();
            $table->decimal('debit', 15, 2)->nullable();
            $table->decimal('credit', 15, 2)->nullable();
            $table->decimal('signed_amount_local', 15, 2)->nullable();
            $table->boolean('integrated_to_accounting')->nullable();
            $table->decimal('rebate_local', 15, 2)->nullable();
            $table->string('vat_code')->nullable();

            $table->string('call_number')->nullable();
            $table->string('vessel')->nullable();
            $table->date('arrival')->nullable();
            $table->date('availability')->nullable();
            $table->date('departure')->nullable();
            $table->string('bl_number')->nullable();

            $table->date('in_date')->nullable();
            $table->integer('days_since_in')->nullable();
            $table->string('transport_mode')->nullable();
            $table->string('final_country_destination')->nullable();

            $table->date('rating_date')->nullable();
            $table->date('out_date')->nullable();
            $table->integer('days')->nullable();
            $table->date('extraction_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapport_suivi_detail_facturations');
    }
};
