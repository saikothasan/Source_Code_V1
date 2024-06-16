<header class="main-header" style="margin-bottom:50px">
    @if (auth()->user()->is_main_branch)
        <a href="{{ route('home') }}" class="logo header-one">
            <span>{{ translate(getSetting('site_name')) }}</span>
        </a>
    @elseif(auth()->user()->branch_id)
        <a href="{{ route('home') }}" class="logo header-one">
            {{ auth()->user()->branch->name }}
        </a>
    @else
        <a href="{{ route('home') }}" class="logo header-one">
            {{ getSetting('site_name') }}
        </a>
    @endif
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top ">
        <!-- Sidebar toggle button-->

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <div>
                        @php($local = session()->has('local') ? session('local') : 'en')
                        @php($lang = \App\Model\Setting::where('key', 'language')->first())
                        <div class="topbar-text dropdown  {{ Session::get('direction') === 'rtl' ? 'ml-3' : 'm-1' }} text-capitalize"
                            style="margin-top:20%">
                            <a class="topbar-link dropdown-toggle d-flex align-items-center title-color" href="#"
                                data-toggle="dropdown">
                                @foreach (json_decode($lang['value'], true) as $data)
                                    @if ($data['code'] == $local)
                                        <img class="" width="20"
                                            src="{{ asset('/images/flags/') }}/{{ $data['code'] }}.png" alt="Eng">
                                        {{ $data['name'] }}
                                    @endif
                                @endforeach
                            </a>
                            <ul class="dropdown-menu">
                                @foreach (json_decode($lang['value'], true) as $key => $data)
                                    @if ($data['status'] == 1)
                                        <li>
                                            <a class="dropdown-item py-1" href="{{ route('lang', [$data['code']]) }}">
                                                <img class="" width="20"
                                                    src="{{ asset('/images/flags/') }}/{{ $data['code'] }}.png"
                                                    alt="{{ $data['name'] }}" />
                                                <span class="text-capitalize">{{ $data['name'] }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(auth()->user()->photo ?? 'images/blank.jpg') }}" class="user-image"
                            alt="User Image">
                        <span class="hidden-xs" style="white-space: pre;">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset(auth()->user()->photo ?? 'images/blank.jpg') }}" class="img-circle"
                                alt="User Image">

                            <p>
                                {{ Auth::user()->name }}
                                <small>Member since
                                    {{ Auth::user()->created_at->toFormattedDateString() }}</small>
                            </p>
                        </li>
                        <li class="user-footer ">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <a href="{{ route('profile') }}"
                                    class="btn btn-default btn-xs">{{ translate('Profile') }}</a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <a href="{{ route('get.password.change') }}"
                                    class="btn btn-default btn-xs">{{ translate('Password') }}</a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();"
                                    class="btn btn-default btn-xs">
                                    {{ translate('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
