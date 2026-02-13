<div class="table-responsive">
    <table class="table table-striped" id="tableYards">
        <thead>
            <tr>
                <th>terminal</th>
                <th>shipowner</th>
                <th>item_number</th>
                <th>item_type</th>
                <th>item_code</th>
                <th>bl_number</th>
                <th>final_destination_country</th>
                <th>description</th>
                <th>teu</th>
                <th>volume</th>
                <th>weight</th>
                <th>yard_zone_type</th>
                <th>zone</th>
                <th>type_veh</th>
                <th>type_de_marchandise</th>
                <th>pod</th>
                <th>yard_zone</th>
                <th>consignee</th>
                <th>call_number</th>
                <th>vessel</th>
                <th>eta</th>
                <th>vessel_arrival_date</th>
                <th>cycle</th>
                <th>yard_quantity</th>
                <th>days_since_in</th>
                <th>dwelltime</th>
                <th>bae</th>
                <th>bloque</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($yards as $yard)
                <tr>
                    <td>{{ $yard->terminal }}</td>
                    <td>{{ $yard->shipowner }}</td>
                    <td>{{ $yard->item_number }}</td>
                    <td>{{ $yard->item_type }}</td>
                    <td>{{ $yard->item_code }}</td>
                    <td>{{ $yard->bl_number }}</td>
                    <td>{{ $yard->final_destination_country }}</td>
                    <td>{{ $yard->description }}</td>
                    <td>{{ $yard->teu }}</td>
                    <td>{{ $yard->volume }}</td>
                    <td>{{ $yard->weight }}</td>
                    <td>{{ $yard->yard_zone_type }}</td>
                    <td>{{ $yard->zone }}</td>
                    <td>{{ $yard->type_veh }}</td>
                    <td>{{ $yard->type_de_marchandise }}</td>
                    <td>{{ $yard->pod }}</td>
                    <td>{{ $yard->yard_zone }}</td>
                    <td>{{ $yard->consignee }}</td>
                    <td>{{ $yard->call_number }}</td>
                    <td>{{ $yard->vessel }}</td>
                    <td>{{ optional($yard->eta)->format('d/m/Y') }}</td>
                    <td>{{ optional($yard->vessel_arrival_date)->format('d/m/Y') }}</td>
                    <td>{{ $yard->cycle }}</td>
                    <td>{{ $yard->yard_quantity }}</td>
                    <td>{{ $yard->days_since_in }}</td>
                    <td>{{ $yard->dwelltime }}</td>
                    <td>{{ $yard->bae }}</td>
                    <td>{{ $yard->bloque }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
