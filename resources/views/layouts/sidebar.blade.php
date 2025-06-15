    <!-- Header -->
    <header class="header-v4">
        <div class="container-menu-desktop">
            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop container">
                    <a href="{{ route('shop.home') }}" class="logo">
                        <img src="{{ asset('images/icons/logo-01.png') }}" alt="IMG-LOGO">
                    </a>

                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li class="{{ request()->routeIs('shop.home') ? 'active-menu' : '' }}">
                                <a href="{{ route('shop.home') }}">Home</a>
                            </li>
                            <li class="{{ request()->routeIs('shop.products.*') ? 'active-menu' : '' }}">
                                <a href="{{ route('shop.products.index') }}">Shop</a>
                            </li>
                            <li class="{{ request()->routeIs('shop.about') ? 'active-menu' : '' }}">
                                <a href="{{ route('shop.about') }}">About</a>
                            </li>
                            <li class="{{ request()->routeIs('shop.contact') ? 'active-menu' : '' }}">
                                <a href="{{ route('shop.contact') }}">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>

                        <a href="{{ route('shop.favorites') }}" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                            <i class="zmdi zmdi-favorite"></i>
                        </a>

                        <a href="{{ route('shop.cart') }}" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="{{ auth()->check() ? auth()->user()->activeCart?->item_count ?? 0 : session('cart_count', 0) }}">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </a>

                        @auth
                            <li class="nav-item dropdown p-l-22 p-r-11">
                                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ Auth::user()->profile_photo ?? asset('images/product-min-01.jpg') }}" alt="User" width="30" height="30" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-container" aria-labelledby="userDropdown">
                                    @if(Auth::user()->role === 'admin')
                                        <a class="dropdown-item" href="{{ route('admin.home') }}">
                                            <i class="fa fa-tachometer-alt mr-2"></i> Admin Dashboard
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('shop.profile.edit') }}">
                                        <i class="fa fa-user-edit mr-2"></i> Edit Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('logout.form') }}" class="dropdown-item text-danger">
                                        <i class="fa fa-sign-out-alt mr-2"></i> Logout
                                    </a>
                                </div>
                            </li>
                        @else
                            <a href="{{ route('login') }}" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                <i class="zmdi zmdi-account"></i>
                            </a>
                        @endauth
                    </div>
                </nav>
            </div>
        </div>

        <div class="wrap-header-mobile">
            <div class="logo-mobile">
                <a href="{{ route('shop.home') }}"><img src="{{ asset('images/icons/logo-01.png') }}" alt="IMG-LOGO"></a>
            </div>

            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>

        <div class="menu-mobile">
            <ul class="topbar-mobile">
                <li>
                    <div class="left-top-bar">
                        Free shipping for standard order over $100
                    </div>
                </li>
            </ul>

            <ul class="main-menu-m">
                <li>
                    <a href="{{ route('shop.home') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('shop.products.index') }}">Shop</a>
                </li>
                <li>
                    <a href="{{ route('shop.about') }}">About</a>
                </li>
                <li>
                    <a href="{{ route('shop.contact') }}">Contact</a>
                </li>
            </ul>
        </div>

        <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <div class="container-search-header">
                <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                    <img src="{{ asset('images/icons/icon-close2.png') }}" alt="CLOSE">
                </button>

                <form class="wrap-search-header flex-w p-l-15">
                    <button class="flex-c-m trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                    <input class="plh3" type="text" name="search" placeholder="Search...">
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar (hidden by default, toggled by 3 lines icon) -->
    <div id="sidebar" style="display:none;position:fixed;top:0;right:0;width:300px;height:100%;background:#fff;z-index:9999;box-shadow:-2px 0 5px rgba(0,0,0,0.1);padding:30px;">
        <button class="close" id="sidebarClose" style="position:absolute;top:10px;right:10px;font-size:2rem;">&times;</button>
        <ul class="list-unstyled mt-5">
            <li><a href="{{ route('shop.home') }}">Home</a></li>
            <li><a href="{{ route('shop.products.index') }}">Shop</a></li>
            <li><a href="{{ route('shop.cart') }}">Cart</a></li>
            <li><a href="{{ route('shop.about') }}">About</a></li>
            <li><a href="{{ route('shop.contact') }}">Contact</a></li>
        </ul>
        <div class="mt-4">
            <h6>Contact Information</h6>
            <p class="mb-1">SPU, Dier Ali, Ghabagheb, DR 10018</p>
            <p class="mb-1">(+963) 99 276 2770</p>
            <p class="mb-1">(+963) 98 879 7331</p>
            <p>info@cozastore.com</p>
        </div>
    </div>
    <script>
        document.getElementById('sidebarToggle').onclick = function() {
            document.getElementById('sidebar').style.display = 'block';
        };
        document.getElementById('sidebarClose').onclick = function() {
            document.getElementById('sidebar').style.display = 'none';
        };
    </script>
