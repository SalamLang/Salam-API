<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route("index") }}">
                <img src="{{ asset("./assets/images/salam_logo.png") }}" alt="Tabler"
                     class="navbar-brand-image rounded-2">
            </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="فعالسازی حالت تاریک"
                   data-bs-toggle="tooltip"
                   data-bs-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="فعالسازی حالت روشن"
                   data-bs-toggle="tooltip"
                   data-bs-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                        <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/>
                    </svg>
                </a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                   aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                          style="background-image: url({{ asset("./assets/images/admin.png") }}); background-repeat: repeat; background-color: transparent; border:0; box-shadow: none"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ user()["name"] }}</div>
                        <div class="mt-1 small text-secondary">مدیر</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Status</a>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <li class="nav-item @if(substr(in_route(), 0, strpos(in_route(), '?') !== false ? strpos(in_route(), '?') : strlen(in_route())) === route("admin.home")) active @endif">
                        <a class="nav-link" href="{{ route("admin.home") }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                   viewBox="0 0 24 24"
                                   stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                   stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path
                                          d="M5 12l-2 0l9 -9l9 9l-2 0"/><path
                                          d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/><path
                                          d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"/></svg>
                            </span>
                            <span class="nav-link-title">صفحه نخست</span>
                        </a>
                    </li>
                    <li class="nav-item @if(substr(in_route(), 0, strpos(in_route(), '?') !== false ? strpos(in_route(), '?') : strlen(in_route())) === route("users.index")) active @endif">
                        <a class="nav-link" href="{{ route("users.index") }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            </span>
                            <span class="nav-link-title">کاربران</span>
                        </a>
                    </li>
                    <li class="nav-item @if(substr(in_route(), 0, strpos(in_route(), '?') !== false ? strpos(in_route(), '?') : strlen(in_route())) === route("codes.index")) active @endif">
                        <a class="nav-link" href="{{ route("codes.index") }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-code"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 8l-4 4l4 4" /><path d="M17 8l4 4l-4 4" /><path d="M14 4l-4 16" /></svg>
                            </span>
                            <span class="nav-link-title">کد ها</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>