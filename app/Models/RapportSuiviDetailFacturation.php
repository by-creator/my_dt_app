<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RapportSuiviDetailFacturation extends Model
{
    use HasFactory;

    protected $table = 'rapport_suivi_detail_facturations';

    protected $fillable = [
        'sites',
        'company',
        'terminal',
        'category',
        'invoice_type',
        'service',
        'maritime_dossier',
        'shipowner',
        'operator',
        'record_type',

        'accounting_date',
        'invoice_number',
        'status',

        'invoice_amount',
        'currency',
        'invoice_amount_local',

        'billed_customer',
        'client',
        'customer_account',

        'item_line',
        'way',
        'item',
        'sens',
        'item_type',
        'item_code',

        'full_empty',
        'reefer_dry',
        'commodity',
        'commodity_category',
        'hazardous_class',
        'out_of_gauge',

        'weight',
        'volume',
        'teu_20',
        'teu_40',
        'teus',

        'vehicle',
        'lots',
        'invoiced_quantity',
        'unit',

        'line',
        'description',
        'contract_type',
        'account',
        'section',
        'rubric',
        'destination',

        'disbursement',
        'debit',
        'credit',
        'signed_amount_local',
        'integrated_to_accounting',
        'rebate_local',
        'vat_code',

        'call_number',
        'vessel',
        'arrival',
        'availability',
        'departure',
        'bl_number',

        'in_date',
        'days_since_in',
        'transport_mode',
        'final_country_destination',

        'rating_date',
        'out_date',
        'days',
        'extraction_date',
    ];
}
