<h2>Shopy</h2>
<div id="MainMenu" class="sidebar-menu">
    <div class="list-group panel">
        <a href="/admin" class="list-group-item list-group-item strong"> <i class="front-icon fa fa-home"></i> Dashboard </a>
        <a href="#users" class="list-group-item list-group-item strong" data-toggle="collapse" data-parent="#MainMenu"><i class="front-icon fa fa-user"></i> Users <i class="back-icon fa fa-chevron-down float-right "></i></a>
        <div class="collapse list-group-submenu" id="users">
            <a href="{{route('users.index')}}" class="list-group-item">All users</a>
            <a href="{{route('users.create')}}" class="list-group-item">Add user</a>
        </div>
        <a href="#pages" class="list-group-item list-group-item strong" data-toggle="collapse" data-parent="#MainMenu"><i class="front-icon fa fa-file"></i> Pages <i class="back-icon fa fa-chevron-down float-right "></i></a>
        <div class="collapse list-group-submenu" id="pages">
            <a href="/admin/page" class="list-group-item">All pages</a>
            <a href="/admin/page/create" class="list-group-item">Add new page</a>
        </div>
        <a href="#products" class="list-group-item list-group-item strong" data-toggle="collapse" data-parent="#MainMenu"><i class="front-icon fa fa-dice-five"></i> Products <i class="back-icon fa fa-chevron-down float-right "></i></a>
        <div class="collapse list-group-submenu" id="products">
            <a href="#" class="list-group-item">All Products</a>
            <a href="#" class="list-group-item">Add new product</a>
            <a href="#" class="list-group-item">Categories</a>
            <a href="#" class="list-group-item">Filters</a>
        </div>
        <a href="#posts" class="list-group-item list-group-item strong" data-toggle="collapse" data-parent="#MainMenu"><i class="front-icon fa fa-pen-square"></i> Posts <i class="back-icon fa fa-chevron-down float-right "></i></a>
        <div class="collapse list-group-submenu" id="posts">
            <a href="{{route('posts.index')}}" class="list-group-item">All Posts</a>
            <a href="{{route('posts.create')}}" class="list-group-item">Add new post</a>
            <a href="#" class="list-group-item">Tags</a>
        </div>
        <a href="#orders" class="list-group-item list-group-item strong" data-toggle="collapse" data-parent="#MainMenu"><i class="front-icon fa fa-box-open"></i> Orders <i class="back-icon fa fa-chevron-down float-right "></i></a>
        <div class="collapse list-group-submenu" id="orders">
            <a href="#" class="list-group-item">All Orders</a>
            <a href="#" class="list-group-item">Waiting Orders </a>
            <a href="#" class="list-group-item">Completed Orders</a>
        </div>

    </div>
</div>
