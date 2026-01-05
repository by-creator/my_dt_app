<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des proformas</u></h4>
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
                            <th>Fichier Proforma</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dossiers as $d)
                            @foreach ($d->proformas as $proforma)
                               @foreach(($proforma->proforma['proforma'] ?? []) as $p)
                                    <tr>
                                        <td>{{ $proforma->bl }}</td>
                                        <td>{{ $proforma->user }}</td>
                                        <td>{{ $proforma->statut }}</td>
                                        <td>{{ $proforma->time_elapsed }}</td>

                                        {{-- Nom original --}}
                                        <td>{{ $p['original'] ?? '-' }}</td>

                                        {{-- Lien --}}
                                        <td>
                                            @if (!empty($p['url']))
                                                <a href="{{ $p['url'] }}" class="btn btn-sm btn-primary"
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
