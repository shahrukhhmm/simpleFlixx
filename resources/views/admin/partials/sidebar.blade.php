<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">

@php
    $rolename = Auth::user()->role;
@endphp
        @if ($rolename == 'admin')
            {{-- dashboard --}}
            <li>
                <a href="{{ url('/') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>

            {{-- users --}}
            <li>
                <a href="{{ url('users') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Users</span>
                </a>
            </li>

            {{-- doctors --}}
            <li>
                <a href="{{ url('doctors') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Doctors</span>
                </a>
            </li>

            {{-- pharmacies --}}
            <li>
                <a href="{{ url('pharmacies') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Pharmacies</span>
                </a>
            </li>

            {{-- order --}}
            <li>
                <a href="{{ url('orders') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Order</span>
                </a>
            </li>
            {{-- chat --}}
            <li>
                <a href="{{ url('chat') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Chat</span>
                </a>
            </li>

        @elseif ($rolename == 'customer')
             {{-- dashboard --}}
            <li>
                <a href="{{ url('/') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
               {{-- order --}}
            <li>
                <a href="{{ url('orders') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Order</span>
                </a>
            </li>
              {{-- chat --}}
            <li>
                <a href="{{ url('chat') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Chat</span>
                </a>
            </li>

        @elseif ($rolename == 'Doctor')

           {{-- dashboard --}}
            <li>
                <a href="{{ url('/') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
               {{-- order --}}
            <li>
                <a href="{{ url('orders') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Orders </span>
                </a>
            </li>
              {{-- chat --}}
            <li>
                <a href="{{ url('chat') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Chat</span>
                </a>
            </li>
        @elseif ($rolename == 'Pharmacy')
            {{-- dashboard --}}
            <li>
                <a href="{{ url('/') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
        @endif

        </ul>
    </div>
</div>
