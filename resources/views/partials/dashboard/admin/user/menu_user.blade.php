<li class="sidebar-item">
    <a href="{{ route('dashboard') }}" class='sidebar-link'>
        <i class="fa-solid fa-user-lock"></i>
        <span>Gestion des rôles</span>
    </a>
</li>

<li class="sidebar-item  active">
    <a href="{{ route('user.index') }}" class='sidebar-link'>
        <i class="fa-solid fa-users"></i>
        <span>Gestion des utilisateurs</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Unify</span>
    </a>
    <ul class="submenu ">
        <li class="submenu-item ">
            
            <a href="form-editor-quill.html"><i class="fa-solid fa-clipboard-list"></i>  Formulaire</a>
        </li>
        <li class="submenu-item ">
            <a href="form-editor-ckeditor.html"><i class="fa-solid fa-list"></i>  Liste</a>
        </li>
         <li class="submenu-item ">
            <a href="form-editor-ckeditor.html"><i class="fa-solid fa-circle-info"></i>  Tutoriel</a>
        </li>
        <li class="submenu-item ">
            <a href="form-editor-summernote.html"><i class="fa-solid fa-toolbox"></i>  Admin</a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a href="{{ route('settings') }}" class='sidebar-link'>
        <i class="fa-solid fa-gear"></i>
        <span>Paramètres</span>
    </a>
</li>