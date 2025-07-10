<div class="header">
    <div class="header-content clearfix">
        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="fas fa-bars"></i></span>
            </div>
        </div>
        <div class="header-left">
            <div class="input-group icons">
                <div class="search-input-wrapper">
                    <input type="search" class="form-control search-input" placeholder="Search Dashboard" aria-label="Search Dashboard">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <div class="drop-down animated flipInX d-md-none">
                    <form action="#">
                        <input type="text" class="form-control" placeholder="Search">
                    </form>
                </div>
            </div>
        </div>
        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{ asset('adminAssets/images/avatar/avatar-square1.png') }}" height="60" width="60" alt="">
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="{{ url('profile') }}"><i class="fas fa-user" style="color: #4154f1"></i> <span>Profile</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void()">
                                        <i class="fas fa-envelope" style="color: #2eca6a"></i> <span>Inbox</span> <div class="badge gradient-3 badge-pill gradient-1">3</div>
                                    </a>
                                </li>
                                <hr class="my-2">
                                <li><a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt" style="color: #ff771d"></i> <span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
.search-input-wrapper {
    position: relative;
    width: 350px; /* Increased from 100% */
    margin-left: 20px;
}

.search-input {
    padding: 8px 35px 8px 15px;
    border-radius: 50px !important;
    border: 1px solid #ddd;
    width: 100%;
}

.search-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

.hamburger {
    padding: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.hamburger:hover {
    background-color: #dddddd;
    border-radius: 6px;
}

.hamburger:hover .toggle-icon i {
    color: #4154f1;
}
.active{
    background-color: #dddddd;
}
</style>
