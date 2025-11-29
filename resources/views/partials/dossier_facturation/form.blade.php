
<h1>Ajouter un dossier</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('dossier_facturation.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Proforma (plusieurs fichiers)</label>
    <input type="file" name="proforma[]" multiple>

    <label>Facture (plusieurs fichiers)</label>
    <input type="file" name="facture[]" multiple>

    <label>Bon (plusieurs fichiers)</label>
    <input type="file" name="bon[]" multiple>

    <button type="submit">Envoyer</button>
</form>
