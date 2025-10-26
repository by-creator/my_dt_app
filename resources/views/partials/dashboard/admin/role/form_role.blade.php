<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Formulaire d'ajout de rôle</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="{{route('role.create')}}" method="post" class="form form-horizontal">
                    @csrf
                    @if (session('create'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Ajout',
                            text: "{{ session('create') }}",
                            showConfirmButton: true
                        });
                    </script>
                    @endif
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Rôle</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" name="name" class="form-control" placeholder="Entrez un rôle" id="first-name-icon">
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-user-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-primary me-1 mb-1">Submit</button>
                                <button type="reset"
                                    class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>