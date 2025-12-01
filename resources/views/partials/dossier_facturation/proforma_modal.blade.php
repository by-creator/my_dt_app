<!-- Modal Génération -->
<div class="modal fade" id="generateModal{{ $dossier->id }}" tabindex="-1" aria-labelledby="generateModalLabel{{ $dossier->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('dossier_facturation.proforma.generate', $dossier->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="generateModalLabel{{ $dossier->id }}">Générer Proforma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if (session('successProforma'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Demande de proforma',
                            text: "{{ session('successProforma') }}",
                            showConfirmButton: true
                        });
                    </script>
                    @elseif (session('infoProforma'))
                    <script>
                        Swal.fire({
                            icon: 'info',
                            title: 'Demande de proforma',
                            text: "{{ session('infoProforma') }}",
                            showConfirmButton: true
                        });
                    </script>
                    @endif
                    <label for="documentDate{{ $dossier->id }}" class="form-label">Date du document</label>
                    <input type="date"
                        name="documentDate"
                        id="documentDate{{ $dossier->id }}"
                        class="form-control"
                        required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check-to-slot"></i> Générer
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-square-xmark"></i> Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

