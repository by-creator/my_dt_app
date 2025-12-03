
<li class="sidebar-item">
    <a href="{{ route('dossier_facturation.validation-index') }}" class='sidebar-link'>
        <i class="fa-solid fa-check-to-slot"></i>
        <span>Validation</span>
    </a>
</li>
<li class="sidebar-item">
    <a href="{{ route('dossier_facturation.paiement-index') }}" class='sidebar-link'>
        <i class="fa-solid fa-money-bill"></i>
        <span>Paiement</span>
    </a>
</li>
<li class="sidebar-item">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-clipboard-list"></i>
        <span>Demande de réduction</span>
    </a>
</li>
<li class="sidebar-item  has-sub ">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-circle-info"></i>
        <span>Comment ça marche </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a href="{{ route('dossier_facturation.tuto-pdf-index') }}"><i class="fa-solid fa-clipboard-list"></i> Format PDF</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('dossier_facturation.tuto-video-index') }}"><i class="fa-solid fa-video"></i> Format VIDEO</a>
        </li>
    </ul>
</li>