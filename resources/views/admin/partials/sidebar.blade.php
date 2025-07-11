<div class="sidebar" id="sidebar">
    <div class="nav-scroll">
        <ul class="nav-menu" style="padding-left: 2px;">
            @php
                $rolename = Auth::user()->role;
            @endphp

            <style>
                .sidebar {
                    width: 244px;
                    background: white;
                    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
                    height: 100vh;
                    position: fixed;
                    transition: all 0.3s ease;
                    left: 0;
                    z-index: 999;
                }

                .sidebar.closed {
                    width: 70px;
                }

                .nav-scroll {
                    height: 100%;
                    overflow-y: auto;
                    padding-top: 10px;
                }

                .nav-menu {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .menu-item {
                    display: flex;
                    align-items: center;
                    padding: 12px 20px;
                    margin: 6px 12px;
                    border-radius: 8px;
                    text-decoration: none;
                    color: #333;
                    transition: all 0.3s ease;
                    white-space: nowrap;
                    overflow: hidden;
                }

                .menu-item:hover {
                    background-color: #e4e4e4;
                }

                .menu-item.active {
                    background-color: pink;
                    color: white;
                }

                .menu-item.active i,
                .menu-item.active span {
                    color: white;
                }

                .menu-item i {
                    font-size: 18px;
                    width: 24px;
                    min-width: 24px;
                }

                .menu-item span {
                    margin-left: 12px;
                    transition: opacity 0.3s;
                }

                .sidebar.closed .menu-item {
                    justify-content: center;
                    padding: 12px 0;
                    padding-left: 5px;
                }

                .sidebar.closed .menu-item span {
                    opacity: 0;
                    width: 0;
                    margin-left: 0;
                }

                .nav-menu li {
                    margin: 6px 0;
                }

                @media (max-width: 1200px) {
                    .sidebar {
                        width: 70px;
                        left: 0;
                    }
                    .sidebar .menu-item {
                        justify-content: center;
                        padding: 12px 0;
                        padding-left: 5px;
                    }
                    .sidebar .menu-item span {
                        opacity: 0;
                        width: 0;
                        margin-left: 0;
                    }
                    .sidebar.show {
                        width: 250px;
                    }
                    .sidebar.show .menu-item {
                        justify-content: flex-start;
                        padding: 12px 20px;
                    }
                    .sidebar.show .menu-item span {
                        opacity: 1;
                        width: auto;
                        margin-left: 12px;
                    }
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const hamburger = document.querySelector('.hamburger');
                    const sidebar = document.getElementById('sidebar');

                    hamburger.addEventListener('click', function() {
                        if(window.innerWidth <= 1200) {
                            sidebar.classList.toggle('show');
                        } else {
                            sidebar.classList.toggle('closed');
                        }
                    });
                });
            </script>

            @if ($rolename == 'admin')
                <li>
                    <a href="{{ url('/') }}" class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                        <i class="fas fa-home text-blue-500"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('users') }}" class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                        <i class="fas fa-users text-green-500"></i>
                        <span>Users</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('doctors') }}" class="menu-item {{ request()->is('doctors') ? 'active' : '' }}">
                        <i class="fas fa-user-md text-red-500"></i>
                        <span>Doctors</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('pharmacies') }}" class="menu-item {{ request()->is('pharmacies') ? 'active' : '' }}">
                        <i class="fas fa-clinic-medical text-purple-500"></i>
                        <span>Pharmacies</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('orders') }}" class="menu-item {{ request()->is('orders') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart text-yellow-500"></i>
                        <span>Order</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('chat') }}" class="menu-item {{ request()->is('chat') ? 'active' : '' }}">
                        <i class="fas fa-comments text-indigo-500"></i>
                        <span>Chat</span>
                    </a>
                </li>

            @elseif ($rolename == 'customer')
                <li>
                    <a href="{{ url('/') }}" class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                        <i class="fas fa-home text-blue-500"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('orders') }}" class="menu-item {{ request()->is('orders') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart text-yellow-500"></i>
                        <span>Order</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('chat') }}" class="menu-item {{ request()->is('chat') ? 'active' : '' }}">
                        <i class="fas fa-comments text-indigo-500"></i>
                        <span>Chat</span>
                    </a>
                </li>

            @elseif ($rolename == 'doctor')
                <li>
                    <a href="{{ url('/doctor/dashboard') }}" class="menu-item {{ request()->is('/doctor/dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home text-blue-500"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('orders/doctor') }}" class="menu-item {{ request()->is('orders/doctor') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart text-yellow-500"></i>
                        <span>Orders</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('chat') }}" class="menu-item {{ request()->is('chat') ? 'active' : '' }}">
                        <i class="fas fa-comments text-indigo-500"></i>
                        <span>Chat</span>
                    </a>
                </li>

            @elseif ($rolename == 'pharmacy')
                <li>
                    <a href="{{ url('/pharmacy/dashboard') }}" class="menu-item {{ request()->is('/pharmacy/dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home text-blue-500"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/orders/pharmacy') }}" class="menu-item {{ request()->is('/orders/pharmacy') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart text-yellow-500"></i>
                        <span>Orders</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
