<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('home') }}">Laravel</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('home') }}">LRV</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="{{ request()->is('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
      </li>
      <li class="menu-header">Master Data Konten</li>
      @if (auth()->user()->can('post-list') || auth()->user()->can('role-list'))
      <li class="dropdown{{ request()->is('panel/konten*') ? ' active' : '' }}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-newspaper"></i><span>Konten</span></a>
        <ul class="dropdown-menu">
          @can('post-list')
          <li class="{{ request()->is('panel/konten/post*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('post.index') }}">Informasi</a>
          </li>
          @endcan
          @can('category-list')
          <li class="{{ request()->is('panel/konten/categories*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('categories.index') }}">Kategori</a>
          </li>
          @endcan
        </ul>
      </li>
      @endif
      @can('user-list')
      <li class="menu-header">Master Data</li>
      <li class="{{ request()->is('panel/users*') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-users"></i><span>Pengguna</span></a>
      </li>
      @endcan
      @can('role-list')
      <li class="{{ request()->is('panel/roles*') ? 'active' : '' }}">
        <a href="{{ route('roles.index') }}" class="nav-link"><i class="fas fa-chalkboard-teacher"></i><span>Role Management</span></a>
      </li>
      @endcan
      @if (auth()->user()->hasRole('Admin'))
      <li class="{{ request()->is('backup*') ? 'active' : '' }}">
        <a href="{{ url('/backup') }}" class="nav-link"><i class="fas fa-database"></i><span>Backup Database</span></a>
      </li>
      @endif
      <li class="menu-header">Pengaturan</li>
      <li class="dropdown{{ request()->is('panel/settings*') ? ' active' : '' }}">
      <a href="#" class="nav-link has-dropdown"
          ><i class="far fa-user"></i> <span>Profil Pengguna</span></a
        >
        <ul class="dropdown-menu">
          <li class="{{ request()->is('panel/settings/change-profile*') ? 'active' : '' }}">
            <a href="{{ route('user-profile', Crypt::encrypt(auth()->user()->id)) }}">Ubah Profil</a></li>
          <li class="{{ request()->is('panel/settings/change-password*') ? 'active' : '' }}">
            <a href="{{ route('user-password', Crypt::encrypt(auth()->user()->id)) }}">Ganti Password</a>
          </li>
        </ul>
      </li>
    </ul>
    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a
        href="{{ route('logout') }}"
        class="btn btn-danger btn-lg btn-block btn-icon-split"
        onclick="event.preventDefault();
								  document.getElementById('logout-form').submit();"
      >
        <i class="fas fas fa-sign-out-alt"></i>Logout
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </div>
  </aside>
</div>