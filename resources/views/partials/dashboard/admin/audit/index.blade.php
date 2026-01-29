<style>
    .log-json {
        max-height: 180px;
        max-width: 420px;
        overflow: auto;
        white-space: pre-wrap;
        word-break: break-word;
        font-size: 0.75rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px;
    }
</style>

<div class="col-md-12 col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des logs</u></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="GET" action="{{ route('admin.audit') }}" class="row g-2 mb-3">
                    <div class="col-md-3">
                        <label class="form-label small">Du</label>
                        <input type="date" name="from" class="form-control form-control-sm"
                            value="{{ request('from') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small">Au</label>
                        <input type="date" name="to" class="form-control form-control-sm"
                            value="{{ request('to') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-sm btn-primary me-2">
                            🔍 Filtrer
                        </button>
                        <a href="{{ route('admin.audit.export.excel', request()->query()) }}"
                            class="btn btn-sm btn-success me-2">
                            📤 Excel
                        </a>

                        <a href="{{ route('admin.audit.export.pdf', request()->query()) }}"
                            class="btn btn-sm btn-danger  me-2">
                            📄 PDF
                        </a>


                        <a href="{{ route('admin.audit') }}" class="btn btn-sm btn-secondary">
                           ♻️ Réinitialiser
                        </a>
                    </div>
                </form>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Détails</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ optional($log->causer)->email }}</td>
                                <td>
                                    <pre class="log-json">
                                        {{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                                    </pre>
                                </td>
                                <td>{{ $log->properties['ip'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Affichage de {{ $activities->firstItem() }} à {{ $activities->lastItem() }}
                    sur {{ $activities->total() }} résultats
                </div>

                <div>
                    {{ $activities->links() }}
                </div>
            </div>



        </div>

    </div>
</div>
