<?php

namespace App\Services;

use App\Models\EdiRecord;
use Illuminate\Support\Collection;

class EdiParser
{
    public function parse(string $filePath): Collection
    {
        if (! file_exists($filePath)) {
            throw new \RuntimeException("Fichier introuvable : {$filePath}");
        }

        $content = file_get_contents($filePath);

        if (! mb_detect_encoding($content, 'UTF-8', true)) {
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
        }

        $records = collect();

        foreach (explode("\n", $content) as $line) {
            $line = rtrim($line, "\r");
            if (trim($line) === '' || strlen($line) < 400) {
                continue;
            }
            $type = trim(substr($line, 0, 5));
            if (empty($type) || ! ctype_alnum($type)) {
                continue;
            }
            $records->push(EdiRecord::fromLine($line));
        }

        // ── Agrégation des BLs multi-lignes ──────────────────────────────────
        $blCounts  = $records->groupBy(fn($r) => $r->data['bl_number'])->map->count();
        $blVolumes = $records->groupBy(fn($r) => $r->data['bl_number'])
            ->map(fn($group) => $group->sum(fn($r) => (float)($r->data['bl_volume'] ?? 0)));
        $blWeights = $records->groupBy(fn($r) => $r->data['bl_number'])
            ->map(fn($group) => $group->sum(fn($r) => (float)($r->data['bl_weight'] ?? 0)));

        foreach ($records as $record) {
            $bl    = $record->data['bl_number'];
            $count = $blCounts[$bl] ?? 1;

            if ($count > 1) {
                $record->data['number_of_yard_items'] = (string)$count;
                $record->data['number_of_packages']   = (string)$count;

                $totalVol = round($blVolumes[$bl] ?? 0, 3);
                if ($totalVol > 0) {
                    $record->data['bl_volume']               = (string)$totalVol;
                    $record->data['blitem_commodity_volume'] = (string)$totalVol;
                }

                $totalWgt = round($blWeights[$bl] ?? 0, 3);
                if ($totalWgt > 0) {
                    $record->data['bl_weight']               = (string)$totalWgt;
                    $record->data['blitem_commodity_weight'] = (string)$totalWgt;
                }
            }
        }

        return $records;
    }

    public function getHeaders(): array
    {
        return [
            'bl_number'                     => 'BL Number',
            'import_export'                 => 'ImportExport',
            'stevedore'                     => 'Stevedore',
            'shipping_agent'                => 'Shipping Agent',
            'estimated_departure_date'      => 'Estimated Departure Date',
            'call_number'                   => 'Call Number',
            'shipper'                       => 'Shipper',
            'forwarder'                     => 'Forwarder',
            'related_customer'              => 'Related Customer',
            'forwarding_agent'              => 'Forwarding Agent',
            'final_destination_country'     => 'Final Destination Country',
            'manifest'                      => 'Manifest',
            'number_of_yard_items'          => 'Number of Yard Items',
            'number_of_packages'            => 'Number of Packages',
            'slot_file'                     => 'SlotFile',
            'transport_mode'                => 'TransportMode',
            'consignee'                     => 'Consignee',
            'custom_release_order'          => 'CustomReleaseOrder',
            'custom_release_order_date'     => 'CustomReleaseOrderDate',
            'delivery_order'                => 'DeliveryOrder',
            'delivery_order_date'           => 'DeliveryOrderDate',
            'master_bl'                     => 'MasterBL',
            'bl_volume'                     => 'BLVolume',
            'bl_weight'                     => 'BLWeight',
            'incoterm'                      => 'Incoterm',
            'port_of_loading'               => 'Port_of_Loading UNLOCODE',
            'reception_location'            => 'Reception_Location UNLOCODE',
            'transshipment_port_1'          => 'Transshipment port 1 UNLOCODE',
            'transshipment_port_2'          => 'Transshipment port 2 UNLOCODE',
            'commodity'                     => 'Commodity',
            'yard_item_type'                => 'YardItemType',
            'unit_of_measure'               => 'UnitOfMeasure',
            'comment'                       => 'Comment',
            'direction_code'                => 'DirectionCode',
            'agent_name'                    => 'Agent Name',
            'blitem_yard_item_type'         => 'BLItem YardItemType',
            'blitem_comment'                => 'BLItem Comment',
            'blitem_yard_item_number'       => 'BLItem YardItemNumber',
            'blitem_allow_invalid'          => 'BLItem AllowInvalidYardItemNumber',
            'blitem_yard_item_code'         => 'BLItem YardItemCode',
            'blitem_out_of_gauge'           => 'BLItem OutOfGauge',
            'blitem_commodity'              => 'BLItem Commodity',
            'blitem_unloading_date'         => 'BLItem YardItemUnloadingDate',
            'blitem_commodity_volume'       => 'BLItem Commodity Volume',
            'blitem_commodity_weight'       => 'BLItem Commodity Weight',
            'blitem_commodity_packages'     => 'BLItem Commodity Packages',
            'blitem_import_export'          => 'BLItem ImportExport',
            'blitem_custom_number'          => 'BLItem CustomNumber',
            'blitem_seal_number_1'          => 'BLItem SealNumber1',
            'blitem_seal_number_2'          => 'BLItem SealNumber2',
            'blitem_hazardous_class'        => 'BLItem HazardousClass',
            'blitem_barcode'                => 'BLItem BarCode',
            'blitem_vehicle_model'          => 'BLItem VehicleModel',
            'blitem_chassis_number'         => 'BLItem ChassisNumber',
            'outgoing_call_number'          => 'OutGoingCallNumber',
            'outgoing_slot_file'            => 'OutGoingSlotFile',
            'is_lifter'                     => 'Is Lifter',
            'stacked_chassis'               => 'Stacked Vehicle Chassis Number',
            'stacked_model'                 => 'Stacked Vehicle Model',
            'stacked_weight'                => 'Stacked Vehicle Weight',
            'stacked_volume'                => 'Stacked Vehicle Volume',
            'new_transshipment_bl'          => 'New Transshipment BL',
            'shipper_name'                  => 'Shipper Name',
            'adresse_2'                     => 'Adresse 2',
            'adresse_3'                     => 'Adresse 3',
            'adresse_4'                     => 'Adresse 4',
            'adresse_5'                     => 'Adresse 5',
            'notify1'                       => 'Notify1',
            'notify2'                       => 'Notify2',
            'notify3'                       => 'Notify3',
            'notify4'                       => 'Notify4',
            'notify5'                       => 'Notify5',
        ];
    }
}