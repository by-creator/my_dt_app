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
                        @foreach($dossier as $d) <!-- Boucle sur chaque dossier -->
                            @foreach($d->proformas as $index => $proforma) <!-- Boucle sur les proformas associés au dossier -->
                                @php
                                    $url = !empty($proforma->path) ? Storage::disk('b2')->url($proforma->path) : null;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $d->id }}</td> <!-- ID du dossier -->
                                    <td>{{ $proforma->original }}</td> <!-- Nom du fichier -->
                                    <td>
                                        @if($url)
                                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-eye"></i> Ouvrir
                                            </a>
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
