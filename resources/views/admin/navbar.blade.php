<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Home </a>
            </li>
            <li class="nav-item {{ Request::is('admin/setup') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.setup') }}">Setup </a>
            </li>
            <li class="nav-item {{ Request::is('admin/teacher') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.teacher') }}">Teacher </a>
            </li>
            <li class="nav-item {{ Request::is('admin/course') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.course') }}">Course </a>
            </li>
            <li class="nav-item {{ Request::is('admin/schedule') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.schedule') }}">Schedule </a>
            </li>
        </ul>
        <div class="my-2 my-lg-0">

            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth()->user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="dropdownMenuLink">
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <input type="submit" value="Logout" class="dropdown-item">
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
