<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="user-wrapper">
                    <div class="profile-image">
                        <img src="{{ (Auth::user()->photo) ?  Auth::user()->photo->getUserImagePath(Auth::user()->photo->file) : "/images/profile/default.jpg"}}" alt="profile image">
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name">{{Auth::user()->name}}</p>
                        <div>
                            <small class="designation text-muted">{{Auth::user()->role->name}}</small>
                            <span class="status-indicator online"></span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#posts" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-content-copy"></i>
                <span class="menu-title">Posts</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="posts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('posts.index')}}">List Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('posts.create')}}">Add new post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('post-categories.index')}}">Categories</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('tags.index')}}">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title">Tags</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-content-copy"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="users">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('users.index')}}">List Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('users.create')}}">Add new user</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>