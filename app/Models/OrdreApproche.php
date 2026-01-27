<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;


class OrdreApproche extends Model
{
    use HasFactory, ConvertsDates;

    protected $table = 'ordre_approches';

    protected $fillable = [
    'date','time','Terminal','Shipowner','ItemNumber','Item_Type',
    'Item_Code','BlNumber','FinalDestinationCountry','Description_',
    'TEU','Volume','Weight_','YardZoneType','Zone','Type_Veh',
    'TypeDeMarchandise','POD','YardZone','consignee','callNumber',
    'Vessel','ETA','vesselarrivaldate','Cycle','bae','client',
    'chauffeur','permis','pointeur','responsable','reserve'
];

}
