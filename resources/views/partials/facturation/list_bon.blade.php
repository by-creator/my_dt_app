<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des bons</u></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Numéro BL</th>
                            <th>Agent</th>
                            <th>Statut</th>
                            <th>Durée de traitement</th>
                            <th>Fichier bon</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dossiers as $d)
                        @foreach($d->bons as $bon)

                        @php
                        // Sécurisation : convertir selon ce qui arrive
                        $bonsJson = is_string($bon->bon)
                        ? json_decode($bon->bon, true)
                        : $bon->bon;
                        @endphp

                        @foreach($bonsJson as $index => $b)
                        @php
                        $url = !empty($b['path']) ? Storage::disk('b2')->url($b['path']) : null;
                        @endphp

                        <tr>
                            <td>{{ $bon->bl }}</td>
                            <td>{{ $bon->user }}</td>
                            <td>{{ $bon->statut }}</td>
                            <td>{{ $bon->time_elapsed }}</td>
                            <td>{{ $b['original'] }}</td>

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