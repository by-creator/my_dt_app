<li class="sidebar-item">
    <a href="{{ route('dashboard') }}" class='sidebar-link'>
        <i class="fa-solid fa-lock"></i>
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
        <i class="bi bi-pen-fill"></i>
        <span>Form Editor</span>
    </a>
    <ul class="submenu ">
        <li class="submenu-item ">
            <a href="form-editor-quill.html">Quill</a>
        </li>
        <li class="submenu-item ">
            <a href="form-editor-ckeditor.html">CKEditor</a>
        </li>
        <li class="submenu-item ">
            <a href="form-editor-summernote.html">Summernote</a>
        </li>
        <li class="submenu-item ">
            <a href="form-editor-tinymce.html">TinyMCE</a>
        </li>
    </ul>
</li>