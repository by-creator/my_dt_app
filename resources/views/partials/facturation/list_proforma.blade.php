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
                            <th>Dossier (ID ou Autre info)</th>
                            <th>Fichier Proforma</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dossiersProformas as $item)
                            @foreach($item['proformas'] as $index => $proforma)
                                @php
                                    // Génère l'URL du fichier en utilisant le chemin stocké
                                    $url = !empty($proforma['path']) ? Storage::disk('b2')->url($proforma['path']) : null;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <!-- Afficher le nom du dossier ou une autre propriété -->
                                        {{ $item['dossier']->name ?? $item['dossier']->id }}  <!-- Changer selon la propriété -->
                                    </td>
                                    <td>
                                        <!-- Affiche le nom du fichier (original) -->
                                        {{ $proforma['original'] }}
                                    </td>
                                    <td>
                                        @if($url)
                                            <!-- Lien pour ouvrir le fichier -->
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
