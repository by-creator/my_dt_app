<?php

namespace App\Services;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class XlsxExporter
{
    // Brand colors
    const COLOR_HEADER_BG    = '1F3864';   // Dark navy
    const COLOR_HEADER_FONT  = 'FFFFFF';   // White
    const COLOR_ROW_ALT      = 'EEF2F7';   // Light blue-grey
    const COLOR_ROW_NORMAL   = 'FFFFFF';   // White
    const COLOR_BORDER       = 'B8C4D0';   // Soft blue-grey

    public function export(Collection $records, array $headers, string $outputPath): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('EDI Data');

        // ── Write header row ──────────────────────────────────────────────────
        $col = 1;
        foreach ($headers as $key => $label) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->getCell("{$colLetter}1")->setValue($label);
            $col++;
        }

        $this->applyHeaderStyle($sheet, 1, count($headers));

        // ── Write data rows ───────────────────────────────────────────────────
        $row = 2;
        foreach ($records as $record) {
            $col = 1;
            $data = $record->toArray();
            foreach (array_keys($headers) as $key) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $sheet->getCell("{$colLetter}{$row}")->setValue($data[$key] ?? '');
                $col++;
            }
            $this->applyRowStyle($sheet, $row, count($headers), $row % 2 === 0);
            $row++;
        }

        // ── Auto-size columns ─────────────────────────────────────────────────
        foreach (range(1, count($headers)) as $colIndex) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // ── Freeze header row ─────────────────────────────────────────────────
        $sheet->freezePane('A2');

        // ── Auto-filter ───────────────────────────────────────────────────────
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));
        $sheet->setAutoFilter("A1:{$lastCol}1");

        // ── Write file ────────────────────────────────────────────────────────
        $writer = new Xlsx($spreadsheet);
        $writer->save($outputPath);

        return $outputPath;
    }

    private function applyHeaderStyle($sheet, int $row, int $colCount): void
    {
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);
        $range = "A{$row}:{$lastCol}{$row}";

        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['argb' => 'FF' . self::COLOR_HEADER_FONT],
                'size'  => 10,
                'name'  => 'Arial',
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF' . self::COLOR_HEADER_BG],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => false,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FF' . self::COLOR_BORDER],
                ],
            ],
        ]);

        $sheet->getRowDimension($row)->setRowHeight(22);
    }

    private function applyRowStyle($sheet, int $row, int $colCount, bool $alternate): void
    {
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);
        $range = "A{$row}:{$lastCol}{$row}";

        $bgColor = $alternate ? self::COLOR_ROW_ALT : self::COLOR_ROW_NORMAL;

        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'size' => 9,
                'name' => 'Arial',
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF' . $bgColor],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FF' . self::COLOR_BORDER],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    }
}
