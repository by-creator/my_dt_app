
<h1>Dossier Facturation</h1>

@foreach (['proforma','facture','bon'] as $type)
    <h4>{{ ucfirst($type) }}</h4>
    <ul>
        @foreach ($dossier->$type ?? [] as $file)
            <li>
                <a href="{{ Storage::disk('b2')->url($file['path']) }}" target="_blank">
                    {{ $file['original'] }}
                </a>
            </li>
        @endforeach
    </ul>
@endforeach
