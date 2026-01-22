<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapportInfosFacturation extends Model
{
    protected $fillable = [
        'terminal_name',
        'company',
        'terminal',
        'category_type',
        'invoice_type_description',
        'service',
        'shipowner',
        'line_operator',
        'category',
        'validation_date',
        'invoice_number',
        'invoice_status',
        'status_change_reason',
        'amount_excluding_tax_invoice_currency',
        'currency',
        'amount_excluding_tax_local_currency',
        'billed_third_party',
        'client',
        'billed_third_party_account',
        'sens',
        'item_number',
        'item_type',
        'cycle',
        'commodity',
        'weight',
        'volume',
        'normalized_size',
        'teu',
        'unit',
        'is_reefer',
        'account_number',
        'invoice_line',
        'description',
        'contract_name',
        'contract_type',
        'section',
        'rubric',
        'disbursement_code',
        'debit_invoice_currency',
        'credit_invoice_currency',
        'amount_signed_local_currency',
        'cap_amount_signed_local_currency',
        'call_number',
        'vessel_name',
        'availability_date',
        'bl_number',
        'final_country_destination',
        'invoice_comment'
    ];
}

