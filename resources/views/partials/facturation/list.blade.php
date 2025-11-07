<div class="row">
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><u>Liste des tiers</u></h4>
            </div>
            <div class="card-body">
                <br>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>code</th>
                            <th>label</th>
                            <th>accounting Id</th>
                            <th>active</th>
                            <th>billable</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tiers as $t)
                        <tr>
                            <td>{{ $t->code }}</td>
                            <td>{{ $t->label }}</td>
                            <td>{{ $t->accounting_id }}</td>
                            <td>{{ $t->active }}</td>
                            <td>{{ $t->billable }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="validateModal" tabindex="-1" aria-labelledby="validateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="validateModalLabel">Valider la t</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir valider cette t ?</p>
                            <form id="validateForm" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="validateId" name="id">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Rejeter la t</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir rejeter cette t ?</p>
                            <form id="rejectForm" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="rejectId" name="id">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Rejeter</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let table1 = document.querySelector('#table1');

        function attachEventListeners() {

            document.querySelectorAll(".btn-validate").forEach(button => {
                button.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    document.getElementById("validateId").value = id;
                    document.getElementById("validateForm").action = "/t/validate/" + id;
                });
            });

            document.querySelectorAll(".btn-reject").forEach(button => {
                button.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    document.getElementById("rejectId").value = id;
                    document.getElementById("rejectForm").action = "/t/reject/" + id;
                });
            });
        }

        // Attacher les événements initiaux
        attachEventListeners();

        // Réattacher les événements après chaque changement de page ou rechargement du tableau
        let dataTable = new simpleDatatables.DataTable("#table1");
        dataTable.on('datatable.init', attachEventListeners);
        dataTable.on('datatable.page', attachEventListeners);
        dataTable.on('datatable.search', attachEventListeners);
    });
</script>

</div>
</div>
</div>
</div>