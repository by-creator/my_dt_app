<!-- Modal Validation -->
<div class="modal fade" id="validateModal{{ $dossier->id }}" tabindex="-1" aria-labelledby="validateModalLabel{{ $dossier->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('dossier_facturation.facture.validate', $dossier->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="validateModalLabel{{ $dossier->id }}">Valider Proforma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr(e) de vouloir valider cette facture ?</p>
                    @if (session('successFacture'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Demande de facture définitive',
                            text: "{{ session('successFacture') }}",
                            showConfirmButton: true
                        });
                    </script>
                     @elseif (session('infoFacture'))
                    <script>
                        Swal.fire({
                            icon: 'info',
                            title: 'Demande de facture définitive',
                            text: "{{ session('infoFacture') }}",
                            showConfirmButton: true
                        });
                    </script>
                    @endif

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i> Oui</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark"></i> Non</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>