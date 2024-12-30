@auth
   <nav>
    <ul class="nav">
        <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="/">Home</a></li>
        <li><a class="{{ request()->routeIs('entries') ? 'active' : '' }}" href="/entries">Time Entry</a></li>
        <li><a class="{{ request()->routeIs('approval') ? 'active' : '' }}" href="/approval">Time Approval</a></li>
        <li><a class="{{ request()->routeIs('settings') ? 'active' : '' }}" href="/settings">Settings</a></li>
        @if (Auth::user()->IsAdmin())
            <li><a class="{{ request()->routeIs('admin') ? 'active' : '' }}" href="/admin">Admin</a></li>
        @endif
        <li class="authenticate" ><a href="/logout">Logout</a></li>
    </ul>
   </nav>
@endauth

