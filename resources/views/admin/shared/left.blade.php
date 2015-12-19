<ul class="nav nav-pills nav-stacked">
    <li><a href="{{ route('admin.root') }}">Home</a></li>
    <li><a href="{{ route('admin.menu') }}">Menus <span class="badge">{{ $total->menu }}</span></a></li>
    <li><a href="{{ route('admin.cat') }}">Categories <span class="badge">{{ $total->category }}</span></a></li>
    <li><a href="">Contents</a></li>
    <li><a href="">Settings</a></li>
</ul>
