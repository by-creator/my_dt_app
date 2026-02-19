<body>


  <!-- Section principale -->
  <div class="container py-5">
    <div class="premium-card mx-auto" style="max-width: 900px;">
      <div class="tab-content">
        <!-- Accueil -->
        <div class="text-center tab-pane fade show active" id="home">
          <img src="{{asset('templates/site/images/hero_12.jpeg')}}" class="img-fluid rounded mb-3" alt="Accueil">
          <h3><u>FORMULAIRE DE DEMANDE DE REMISE</u></h3>
          <p>Veuillez remplir le formulaire ci-dessous pour demander la remise de votre dossier.</p>
          <form method="POST" action="{{ route('dossier_facturation.remise') }}" enctype="multipart/form-data" class="form">
            @csrf
            <div class="mb-3">
              <input type="text" name="nom" class="text-center form-control" required placeholder="Nom du transitaire (ex : THIAW)">
            </div>

            <div class="mb-3">
              <input type="text" name="prenom" class="text-center form-control" required placeholder="Prénom du transitaire (ex : Moussa)">
            </div>

            <div class="mb-3">
              <input type="email" name="email" class="text-center form-control" required placeholder="Adresse mail du transitaire (ex : mail@gmail.com)">
            </div>

            <div class="mb-3">
              <input type="text" name="bl" class="text-center form-control" required placeholder="Numéro de BL (ex : S320...)">
            </div>

            <div class="mb-3">
              <input type="text" name="compte" class="text-center form-control" required placeholder="Maison de transit (ex : Dakar-Terminal SN../ND../1234)">
            </div>

            <div class="mb-3">
              <label>FACTURE DAKAR-TERMINAL</label>
              <input type="file" required name="documents[]" class="form-control" multiple>
            </div>

            <div class="mb-3">
              <label>BAD SHIPPING</label>
              <input type="file" required name="documents[]" class="form-control" multiple>
            </div>

            <div class="mb-3">
              <label>DECLARATION</label>
              <input type="file" required name="documents[]" class="form-control" multiple>
            </div>


            <button type="submit" class="btn btn-gradient w-100">ENVOYER LA DEMANDE DE REMISE</button>
          </form>

        </div>



      </div>
    </div>
  </div>

  <footer>
    <p>© 2025 Dakar-Terminal — Tous droits réservés</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @if (session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Demande de validation envoyée ✅',
      text: "{{ session('success') }}",
      showConfirmButton: true
    });
  </script>
  @elseif (session('info'))
  <script>
    Swal.fire({
      icon: 'info',
      title: 'Validation en cours  ℹ️',
      text: "{{ session('info') }}",
      showConfirmButton: true
    });
  </script>
  @elseif (session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Demande de validation échouée ❌',
      text: "{{ session('error') }}",
      showConfirmButton: true
    });
  </script>
  @endif
</body>