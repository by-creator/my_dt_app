<?php

namespace App\Imports;

use App\Models\FacturationStaging;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FacturationXlsxImport implements ToModel, WithStartRow
{
    /**
     * 🔥 Ignore la ligne d’en-tête
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        try {
            return new FacturationStaging([
                'terminal_name' => $row[0] ?? null,
                'company' => $row[1] ?? null,
                'terminal' => $row[2] ?? null,
                'category_type' => $row[3] ?? null,
                'invoice_type_description' => $row[4] ?? null,
                'service' => $row[5] ?? null,
                'shipowner' => $row[6] ?? null,
                'line_operator' => $row[7] ?? null,
                'category' => $row[8] ?? null,

                'validation_date' => $this->safeDate($row[9] ?? null),
                'invoice_number' => $row[10] ?? null,
                'invoice_status' => $row[11] ?? null,
                'status_change_reason' => $row[12] ?? null,

                'amount_excluding_tax_invoice_currency' => $row[13] ?? null,
                'currency' => $row[14] ?? null,
                'amount_excluding_tax_local_currency' => $row[15] ?? null,

                'billed_third_party' => $row[16] ?? null,
                'client' => $row[17] ?? null,
                'billed_third_party_account' => $row[18] ?? null,
                'sens' => $row[19] ?? null,

                'item_number' => $row[20] ?? null,
                'item_type' => $row[21] ?? null,
                'cycle' => $row[22] ?? null,
                'commodity' => $row[23] ?? null,

                'weight' => $row[24] ?? null,
                'volume' => $row[25] ?? null,
                'normalized_size' => $row[26] ?? null,
                'teu' => $row[27] ?? null,
                'unit' => $row[28] ?? null,
                'is_reefer' => $this->toBool($row[29] ?? null),

                'account_number' => $row[30] ?? null,
                'invoice_line' => $row[31] ?? null,
                'description' => $row[32] ?? null,

                'contract_name' => $row[33] ?? null,
                'contract_type' => $row[34] ?? null,
                'section' => $row[35] ?? null,
                'rubric' => $row[36] ?? null,
                'disbursement_code' => $row[37] ?? null,

                'debit_invoice_currency' => $row[38] ?? null,
                'credit_invoice_currency' => $row[39] ?? null,

                'amount_signed_local_currency' => $row[40] ?? null,
                'cap_amount_signed_local_currency' => $row[41] ?? null,

                'call_number' => $row[42] ?? null,
                'vessel_name' => $row[43] ?? null,
                'availability_date' => $this->safeDate($row[44] ?? null),
                'bl_number' => $row[45] ?? null,
                'final_country_destination' => $row[46] ?? null,
                'invoice_comment' => $row[47] ?? null,

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ [FACTURATION][XLSX] Ligne ignorée', [
                'row' => $row,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * 🧠 Conversion date safe
     */
    private function safeDate($value): ?string
    {
        if (!$value) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }

    private function toBool($value): bool
    {
        return in_array(
            strtolower((string) $value),
            ['1', 'true', 'oui', 'vrai', 'yes'],
            true
        );
    }
}
