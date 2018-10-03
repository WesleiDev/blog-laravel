<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category">
            <span class="nav-link">BLOG</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.posts')}}">
                <span class="menu-title">Post</span>
                <i class="icon-speedometer menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.authors')}}">
                <span class="menu-title">Autor</span>
                <i class="icon-wrench menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.categories')}}">
                <span class="menu-title">Categoria</span>
                <i class="icon-wrench menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.tags')}}">
                <span class="menu-title">Tags</span>
                <i class="icon-wrench menu-icon"></i>
            </a>
        </li>

    </ul>
</nav>