<h3>Documents Proforma</h3>

@if ($dossier->proforma)
    <ul>
        @foreach ($dossier->proforma as $file)
            <li>
                <a href="{{ Storage::disk('b2')->url($file['path']) }}" target="_blank">
                    📄 {{ $file['original'] }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-muted">Aucun fichier</p>
@endif


<h3>Documents Facture</h3>
@if ($dossier->facture)
    <ul>
        @foreach ($dossier->facture as $file)
            <li>
                <a href="{{ Storage::disk('b2')->url($file['path']) }}" target="_blank">
                    📄 {{ $file['original'] }}
                </a>
            </li>
        @endforeach
    </ul>
@endif


<h3>Documents Bon</h3>
@if ($dossier->bon)
    <ul>
        @foreach ($dossier->bon as $file)
            <li>
                <a href="{{ Storage::disk('b2')->url($file['path']) }}" target="_blank">
                    📄 {{ $file['original'] }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
