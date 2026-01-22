<?php

namespace App\Imports;

use App\Models\RapportInfosFacturation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class RapportInfosFacturationImport implements ToModel,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    ShouldQueue
{
    public function model(array $row)
    {
        $amountSigned = ($row['debit_invoice_currency'] ?? 0)
                      + ($row['credit_invoice_currency'] ?? 0);

        return new RapportInfosFacturation([
            'terminal_name' => $row['terminalname'] ?? null,
            'company' => $row['company'] ?? null,
            'terminal' => $row['terminal'] ?? null,
            'category_type' => $row['categorytype'] ?? null,
            'invoice_type_description' => $row['invoicetypedescription'] ?? null,
            'service' => $row['service'] ?? null,
            'shipowner' => $row['shipowner'] ?? null,
            'line_operator' => $row['line_operator'] ?? null,
            'category' => $row['category'] ?? null,
            'validation_date' => $row['validationdate'] ?? null,
            'invoice_number' => $row['invoicenumber'] ?? null,
            'invoice_status' => $row['invoicestatus'] ?? null,
            'status_change_reason' => $row['statuschangereason'] ?? null,
            'amount_excluding_tax_invoice_currency' => $row['amount_excluding_tax_invoicecurrency'] ?? 0,
            'currency' => $row['currency'] ?? null,
            'amount_excluding_tax_local_currency' => $row['amount_excluding_tax_localcurrency'] ?? 0,
            'billed_third_party' => $row['billedthirdparty'] ?? null,
            'client' => $row['client'] ?? null,
            'billed_third_party_account' => $row['billedthirdpartyaccount'] ?? null,
            'sens' => $row['sens'] ?? null,
            'item_number' => $row['itemnumber'] ?? null,
            'item_type' => $row['itemtype'] ?? null,
            'cycle' => $row['cycle'] ?? null,
            'commodity' => $row['commodity'] ?? null,
            'weight' => $row['weight'] ?? 0,
            'volume' => $row['volume'] ?? 0,
            'normalized_size' => $row['normalizedsize'] ?? null,
            'teu' => $row['teu'] ?? null,
            'unit' => $row['unit'] ?? null,
            'is_reefer' => $row['isreefer'] ?? false,
            'account_number' => $row['account_number'] ?? null,
            'invoice_line' => $row['invoiceline'] ?? null,
            'description' => $row['description'] ?? null,
            'contract_name' => $row['contractname'] ?? null,
            'contract_type' => $row['contracttype'] ?? null,
            'section' => $row['section'] ?? null,
            'rubric' => $row['rubric'] ?? null,
            'disbursement_code' => $row['disbursementcode'] ?? null,
            'debit_invoice_currency' => $row['debit_invoice_currency'] ?? 0,
            'credit_invoice_currency' => $row['credit_invoice_currency'] ?? 0,
            'amount_signed_local_currency' => $amountSigned,
            'cap_amount_signed_local_currency' => $amountSigned,
            'call_number' => $row['callnumber'] ?? null,
            'vessel_name' => $row['vesselname'] ?? null,
            'availability_date' => $row['availabilitydate'] ?? null,
            'bl_number' => $row['blnumber'] ?? null,
            'final_country_destination' => $row['finalcountrydestination'] ?? null,
            'invoice_comment' => $row['invoicecomment'] ?? null,
        ]);
    }

    

    /** Nombre de lignes lues à la fois */
    public function chunkSize(): int
    {
        return 1000; // 🔥 idéal
    }

    /** Inserts groupés */
    public function batchSize(): int
    {
        return 1000;
    }
}
