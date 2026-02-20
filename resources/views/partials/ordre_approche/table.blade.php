<div class="table-responsive">
    <table class="table table-striped" id="tableYards">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Item</th>
                <th>Imprimer l'ordre</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($yard_list as $yard)
                <tr>
                    <td>{{ optional($yard->date)->format('d/m/Y') }}</td>
                    <td>{{ $yard->time }}</td>
                    <td>{{ $yard->item_number }}</td>
                    <td>
                        <a href="{{ route('ordre_approche.print', [$yard->id, 'vehicule']) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary me-2">
                            approche véhicule
                        </a>

                        <a href="{{ route('ordre_approche.print', [$yard->id, 'tc']) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary me-2">
                            chargement tc
                        </a>

                        <a href="{{ route('ordre_approche.print', [$yard->id, 'bulk']) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary me-2">
                            chargement bulk
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
