<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><u>Formulaire d'ajout de compte</u></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" action="route{{ ('user_accounts.create') }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="created-date-column">Date de début</label>
                                        <input type="datetime-local" id="created-date-column" class="form-control"
                                          name="created_date">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="employee-end-date-column">Date de fin</label>
                                        <input type="datetime-local" id="employee-end-date-column" class="form-control"
                                          name="employee_end_date">
                                    </div>
                                </div>
                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="display-name-column">Nom & prénom(s)</label>
                                        <input type="text" id="display-name-column" class="form-control"
                                            placeholder="Entrez le nom et prénom(s)" name="display_name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="department-column">Département</label>
                                        <input type="text" id="department-column" class="form-control"
                                            placeholder="Entrez le département" name="department">
                                    </div>
                                </div>
                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-column">Email</label>
                                        <input type="email" id="email-column" class="form-control"
                                            placeholder="Entrez l'adresse mail" name="email">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="job-title-column">Job Tiltle</label>
                                        <input type="text" id="job-title-column" class="form-control"
                                            placeholder="Entrez le Job Tiltle" name="job_title">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit"
                                        class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset"
                                        class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
