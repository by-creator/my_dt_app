<form method="POST" action="{{ route('ticket.store') }}" onclick="this.submit()" class="h-100">
    @csrf

    <input type="hidden" name="service_id" value="{{ $service->id }}">
    <input type="hidden" name="priorite" value="normal">

    <div class="card ticket-card h-100">

        @php
            $icons = [
                'Validation' => '📝',
                'Facturation' => '💳',
                'Caisse' => '💰',
                'Bad' => '📦',
            ];
        @endphp

        <div class="ticket-icon" style="background: {{ $service->couleur ?? '#4f6bed' }}">
            {{ $icons[$service->nom] ?? '👤' }}
        </div>


        <div class="ticket-title">
            Ticket pour<br>
            <strong>{{ $service->nom }}</strong>
        </div>

    </div>
</form>
