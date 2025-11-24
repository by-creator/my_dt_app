 <div class="col-12">
     <div class="card">
         <div class="card-header">
             <h4 class="card-title"><u>Formulaire d'ajout des ordinateurs</u></h4>
         </div>
         <div class="card-content">
             <div class="card-body">
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
                 <form action="{{route('ordinateur.create')}}" method="post" id="userForm"
                     class="form form-horizontal">
                     @csrf
                     <div class="form-body">
                         <div class="row">
                            <div class="col-md-4">
                                 <label>Date de réception</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="date_reception" id="date_reception" type="datetime-local" class="form-control">
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-calendar"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <label>Date de déploiement</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="date_deploiement" id="date_deploiement" type="datetime-local" class="form-control">
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-calendar"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <label>Numéro de série</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="serie" id="serie" type="text" class="form-control"
                                             placeholder="Saisissez un serie" required>
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-file-signature"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <label>Modèle</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="model" id="model" type="text" class="form-control"
                                             placeholder="Saisissez un model" required>
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-file-signature"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <label>Type</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <select name="type" id="" class="form-control">
                                            <option value="">Choisissez le type</option>
                                            <option value="DESKTOP">DESKTOP</option>
                                            <option value="LAPTOP">LAPTOP</option>
                                         </select>
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-file-signature"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <label>Utilisateur</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="utilisateur" id="utilisateur" type="text" class="form-control"
                                             placeholder="Saisissez un utilisateur" required>
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-file-signature"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <label>Service</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="service" id="service" type="text" class="form-control"
                                             placeholder="Saisissez un service" required>
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-file-signature"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <label>Site</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="site" id="site" type="text" class="form-control"
                                             placeholder="Saisissez un site" required>
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-file-signature"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-12 d-flex justify-content-end">
                                 <button type="submit" class="btn btn-primary me-1 mb-1"><i class="fa-solid fa-check-to-slot"></i> Valider</button>
                                 <button type="reset" class="btn btn-danger me-1 mb-1"><i class="fa-solid fa-square-xmark"></i> Annuler</button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>