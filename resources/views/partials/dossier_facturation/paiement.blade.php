@extends('partials.app')

@section('content')


<body>


  <!-- Section principale -->
  <div class="container py-5">
    <div class="premium-card mx-auto" style="max-width: 900px;">
      <div class="tab-content">
        <!-- Accueil -->
        <div class="text-center tab-pane fade show active" id="home">
          <img src="{{asset('templates/site/images/hero_9.png')}}" class="img-fluid rounded mb-3" alt="Contact">
          <h3><u>PAIEMENT</u></h3>
          <p>Afin d'accéder à la plateforme de paiement cliqez sur le bouton ci-dessous : </p>
          <a href="https://mytouchpoint.net/dakar_terminal" target="_blank" class="btn btn-gradient w-100">PAIEMENT</a>
        
        </div>
   
        
      </div>
    </div>
  </div>

  <footer>
    <p>© 2025 Dakar-Terminal — Tous droits réservés</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @if (session('sendValidation'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Demande de validation envoyée ✅',
      text: "{{ session('sendValidation') }}",
      showConfirmButton: true
    });
  </script>
  @elseif (session('info'))
  <script>
    Swal.fire({
      icon: 'warning',
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

@endsection