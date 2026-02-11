<button class="btn btn-sm btn-outline-primary btn-edit"
    data-id="{{ $telephone->id }}"
    data-matricule="{{ $telephone->matricule }}"
    data-nom="{{ $telephone->nom }}"
    data-prenom="{{ $telephone->prenom }}"
    data-service="{{ $telephone->service }}"
    data-destination="{{ $telephone->destination }}"
    data-reference_telephone="{{ $telephone->reference_telephone }}"
    data-montant_ancien_forfait_ttc="{{ $telephone->montant_ancien_forfait_ttc }}"
    data-numero_sim="{{ $telephone->numero_sim }}"
    data-formule_premium="{{ $telephone->formule_premium }}"
    data-montant_forfait_ttc="{{ $telephone->montant_forfait_ttc }}"
    data-code_puk="{{ $telephone->code_puk }}"
    data-acquisition_date="{{ $telephone->acquisition_date }}"
    data-statut="{{ $telephone->statut }}"
    data-cause_changement="{{ $telephone->cause_changement }}"
    data-imsi="{{ $telephone->imsi }}"
    data-bs-toggle="modal"
    data-bs-target="#editModal">
    ✏️ Modifier
</button>

<button class="btn btn-sm btn-outline-danger btn-delete"
    data-id="{{ $telephone->id }}"
    data-bs-toggle="modal"
    data-bs-target="#deleteModal">
    🗑️ Supprimer
</button>
