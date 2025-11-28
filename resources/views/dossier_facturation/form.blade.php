@extends('partials.app')

@section('content')

<form action="{{ route('dossier_facturation.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Proforma (PDF) :</label>
    <input type="file" name="proforma" accept="application/pdf">

    <label>Facture (PDF) :</label>
    <input type="file" name="facture" accept="application/pdf">

    <label>Bon (PDF) :</label>
    <input type="file" name="bon" accept="application/pdf">

    <button type="submit">Enregistrer</button>
</form>
@endsection

