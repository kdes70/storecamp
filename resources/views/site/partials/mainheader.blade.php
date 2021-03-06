<?php
/**
 * @var \Illuminate\Auth\AuthManager
 */
$user = $auth->user() ? $auth->user() : null; ?>
<header class="main-header">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="/home" class="navbar-brand"><img src="{{asset('img/Logo!.png')}}" style="    height: 80%;
    padding-top: 14px;
    width: 120px;" alt="storecamp"
                                                          class="img-responsive"></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    {{--<li class=" ">--}}
                        {{--<a class="nav-link" href="/credit">Credit</a>--}}
                    {{--</li>--}}
                    {{--<li class=" ">--}}
                        {{--<a class="nav-link" href="warranty">Warranty</a>--}}
                    {{--</li>--}}
                    {{--<li class=" ">--}}
                        {{--<a class="nav-link" href="/contacts">Contacts</a>--}}
                    {{--</li>--}}
                    {{--<li class=" ">--}}
                        {{--<a class="nav-link" href="/about">About</a>--}}
                    {{--</li>--}}
                    @include('site.partials.toggle-language')
                </ul>
                <div class="form-inline pull-left">
                    <form class="navbar-form active" id="search-type" method="get" role="search">
                        <div class="input-group" style="width: 300px;">
                            <input name="search" type="search" class="form-control search-input pull-right"
                                   style="width: inherit; position: relative; margin-right: 1px; border: 1px solid #ddd; background-color: #e5e5e5;"
                                   placeholder="Search">
                            {{--<span class="input-group-btn">--}}
							{{--<button type="submit" class="btn btn-default">--}}
								{{--<span class="glyphicon glyphicon-search">--}}
									{{--<span class="sr-only">Search</span>--}}
								{{--</span>--}}
							{{--</button>--}}
						</span>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    @if(!empty($user) && $user->hasRole('Admin'))
                    <li class="nav-menu">
                        <!-- Menu Toggle Button -->
                        <a href="{!! route('admin::dashboard') !!}" class="" data-toggle="">
                            <i class="fa fa-user-plus"></i> Admin Page
                        </a>
                    </li>
                    @endif
                    <!-- Messages: style can be found in dropdown.less-->
                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="cart-menu">
                        <!-- Menu Toggle Button -->
                        <a href="{!! route('site::cart::show') !!}" class="" data-toggle="">
                            <i class="fa fa-cart-plus"></i>
                            <?php $countItems = $navigation['cartSystem']->count(); ?>
                            @if($countItems)
                                <span class="label label-primary">{{$countItems}}</span>
                            @else
                                <span class="label label-yellow">0</span>
                            @endif
                        </a>
                    </li>
                    <!-- User Account Menu -->
                    @if(!$auth->guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{str_limit(
                            $auth->user()->name,
                            20
                            )}}
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><!-- start notification -->
                                    <a class="dropdown-item" href="profile">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/history">Orders History</a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                                        logout
                                    </a>
                                </li>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                    <input type="submit" value="logout" style="display: none;">
                                </form>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>
@include('cookieConsent::index')
@include('site.partials.search.search-block')