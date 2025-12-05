<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des proformas</u></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Dossier ID</th>
                            <th>Fichier Proforma</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dossiers as $d)
                        @foreach($d->proformas as $proforma)

                        @php
                        // Sécurisation : convertir selon ce qui arrive
                        $proformasJson = is_string($proforma->proforma)
                        ? json_decode($proforma->proforma, true)
                        : $proforma->proforma;
                        @endphp

                        @foreach($proformasJson as $index => $p)
                        @php
                        $url = !empty($p['path']) ? Storage::disk('b2')->url($p['path']) : null;
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $d->id }}</td>
                            <td>{{ $p['original'] }}</td>

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