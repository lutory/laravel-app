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
        <li class="nav-item {{Request::is('admin') ? 'active' : ''}}">
            <a class="nav-link" href="/admin">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{Request::is('*posts','*posts/*','*post-categories','*post-categories/*') ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#posts">
                <i class="fas fa-book menu-icon"></i>
                <span class="menu-title">Posts</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{Request::is('*posts','*posts/*','*post-categories','*post-categories/*') ? 'show' : ''}}" id="posts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('*posts') ? 'active' : ''}}" href="{{route('posts.index')}}">List Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('*posts/create') ? 'active' : ''}}" href="{{route('posts.create')}}">Add new post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('*post-categories') ? 'active' : ''}}" href="{{route('post-categories.index')}}">Categories</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{Request::is('*pages','*pages/*') ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#pages">
                <i class="fas fa-newspaper menu-icon"></i>
                <span class="menu-title">Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{Request::is('*pages','*pages/*') ? 'show' : ''}}" id="pages">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('*pages') ? 'active' : ''}}" href="{{route('pages.index')}}">List Pages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('*pages/create') ? 'active' : ''}}" href="{{route('pages.create')}}">Add new page</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{Request::is('*tags','*tags/*') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('tags.index')}}">
                <i class="fas fa-tags menu-icon"></i>
                <span class="menu-title">Tags</span>
            </a>
        </li>
        <li class="nav-item {{Request::is('*users','*users/*') ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#users">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{Request::is('*users','*users/*') ? 'show' : ''}}"  id="users">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('*users') ? 'active' : ''}}" href="{{route('users.index')}}">List Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('*users/create') ? 'active' : ''}}" href="{{route('users.create')}}">Add new user</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>