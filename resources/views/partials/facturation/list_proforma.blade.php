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
                        @foreach($dossiersProformas as $item)
                            @foreach($item['proformas'] as $index => $proforma)
                                @php
                                    $url = !empty($proforma->path) ? Storage::disk('b2')->url($proforma->path) : null;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['dossier']->id }}</td>
                                    <td>{{ $proforma->original }}</td>
                                    <td>
                                        @if($url)
                                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">Ouvrir</a>
                                            <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#validateProformaModal{{ $item['dossier']->id }}">Valider</a>
                                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProformaModal{{ $item['dossier']->id }}">Supprimer</a>
                                        @else
                                            <span class="text-muted">Pas de fichier</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
