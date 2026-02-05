<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire de gestion des items</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                
                <form method="POST" action="{{ route('rapport.yard.list') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label for="date">Item number</label>
                                <div class="d-flex gap-2">

                                    <input list="yards_list" name="item_number" class="form-control"
                                        placeholder="Saisir ou choisir un item" required>

                                    <datalist id="yards_list">
                                        @foreach ($item_numbers as $item_number)
                                            <option value="{{ $item_number }}">
                                        @endforeach
                                    </datalist>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="submit" class="btn btn-sm btn-outline-primary me-2">
                                            🔒 Bloquer
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-outline-primary me-2">
                                            🔓 Débloquer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
</div>
