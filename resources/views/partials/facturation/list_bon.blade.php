<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des bons</u></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Numéro BL</th>
                            <th>Statut</th>
                            <th>Fichier bon</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dossiers as $d)
                            @foreach ($d->bons as $bon)
                                @foreach ($bon->bon['bon'] ?? [] as $b)
                                    <tr>
                                        <td>{{ $bon->bl }}</td>
                                        <td>{{ $bon->statut }}</td>

                                        {{-- Nom original --}}
                                        <td>{{ $b['original'] ?? '-' }}</td>

                                        {{-- Lien --}}
                                        <td>
                                            @if (!empty($b['url']))
                                                <a href="{{ $b['url'] }}" class="btn btn-sm btn-primary"
                                                    target="_blank">
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
