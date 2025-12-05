<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des factures</u></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Numéro BL</th>
                            <th>Agent</th>
                            <th>Statut</th>
                            <th>Durée de traitement</th>
                            <th>Fichier facture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dossiers as $d)
                        @foreach($d->factures as $facture)

                        @php
                        // Sécurisation : convertir selon ce qui arrive
                        $facturesJson = is_string($facture->facture)
                        ? json_decode($facture->facture, true)
                        : $facture->facture;
                        @endphp

                        @foreach($facturesJson as $index => $f)
                        @php
                        $url = !empty($f['path']) ? Storage::disk('b2')->url($f['path']) : null;
                        @endphp

                        <tr>
                            <td>{{ $facture->bl }}</td>
                            <td>{{ $facture->user }}</td>
                            <td>{{ $facture->statut }}</td>
                            <td>{{ $facture->time_elapsed }}</td>
                            <td>{{ $f['original'] }}</td>

                            <td>
                                @if($url)
                                <a href="{{ $url }}" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="fa-solid fa-eye"></i> Ouvrir
                                </a>
                                @else
                                <span class="text-muted">Pas de fichier</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        @endforeach
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</section>