<!DOCTYPE html>
<html lang="ar" dir="rtl" class="no-js">

<head>
    <meta charset="utf-8">
    <title>@yield('title',env('APP_NAME'))</title>
    <meta name="description" content="The description should optimally be between 150-160 characters.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Madeon08">

    <!-- ================= Favicons ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="{{asset('assets/frontend/img/favicon.png')}}">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/frontend/img/favicon-retina-ipad.png')}}">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/frontend/img/favicon-retina-iphone.png')}}">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/frontend/img/favicon-standard-ipad.png')}}">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/frontend/img/favicon-standard-iphone.png')}}">

    <!-- ============== Resources style ============== -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/style.css')}}" />

    <!-- Modernizr runs quickly on page load to detect features -->
    <script src="{{asset('assets/frontend/js/modernizr.custom.js')}}"></script>
</head>

<body>

<!-- *** LOADING *** -->

<div id="loading">

    <div class="loader">
        <span class="dots">	.</span>
        <span class="dots">	.</span>
        <span class="dots">	.</span>
        <span class="dots">	.</span>
        <span class="dots">	.</span>
        <span class="dots">	.</span>
        <p class="loader__label">Saphir | <span data-words="Loading|Chargement|Lädt|Cargando|加载中"></span></p>
    </div>
</div>

<!-- *** / LOADING *** -->

<!-- *** Menu icon for opening/closing the menu on small screen *** -->

<button id="small-screen-menu">

    <span class="custom-menu"></span>

</button>

<!-- *** / Menu icon *** -->

<!-- *** Constellation *** -->
<canvas id="constellationel"></canvas> <!-- Canvas displaying the animation -->

<div id="constellation"></div> <!-- Used to display your background picture, set up the path to your picture in your css/style.css file OR replace the img/constellation.jpg file by yours -->

<!-- The overlay that you can see over the animation is generated with the following CSS rule : .custom-overlay, it can be found in your style.css file under 2. GENERIC STYLES part -->
<div class="custom-overlay"></div>

<!-- Logo on top right -->
<a class="brand-logo" href="#Home">
    <img src="{{asset('assets/frontend/img/logo.png')}}" alt="Our company logo" class="img-fluid" />
</a>

@yield('content')

<footer>

    <div class="line"></div>

    <div class="row">

        <div class="col-12 col-xl-4 footer-nav">

            <ul id="bottomMenu" class="on-left">

                <li data-menuanchor="Home" class="active">
                    <a href="#Home">Home</a>
                </li>
                @guest()
                <li >
                    <a href="{{route('login')}}">تسجيل الدخول</a>
                </li>
                @endguest
                @auth()
                    <li >
                        <a href="{{url('/home')}}">لوحة التحكم</a>
                    </li>
                    <li >
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endauth

{{--                <li data-menuanchor="Works">--}}
{{--                    <a href="#Works">Works</a>--}}
{{--                </li>--}}

{{--                <li data-menuanchor="Contact">--}}
{{--                    <a href="#Contact">Contact</a>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a class="trigger open_somedialog_1">Notify Me</a>--}}
{{--                </li>--}}
            </ul>
        </div>

        <div class="col-12 col-xl-4 footer-copyright">
            <p>© SAPHIR - Made for Great People</p>
        </div>

        <div class="col-12 col-xl-4 footer-nav">

            <ul class="on-right">

{{--                <li>--}}
{{--                    <a href="https://www.facebook.com/themehelite" target="_blank"><i class="fab fa-facebook-f"></i></a>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="https://twitter.com/themehelite" target="_blank"><i class="fab fa-twitter"></i></a>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
</footer>

<!-- ///////////////////\\\\\\\\\\\\\\\\\\\ -->
<!-- ********** jQuery Resources ********** -->
<!-- \\\\\\\\\\\\\\\\\\\/////////////////// -->

<!-- * Libraries jQuery, Easing and Bootstrap - Be careful to not remove them * -->
<script src="{{asset('assets/frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.easings.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.min.js')}}"></script>

<!-- Countdown plugin -->
<script src="{{asset('assets/frontend/js/jquery.countdown.js')}}"></script>

<!-- FullPage plugin -->
<script src="{{asset('assets/frontend/js/jquery.fullPage.js')}}"></script>

<!-- Constellation plugin -->
<script src="{{asset('assets/frontend/js/constellation.js')}}"></script>

<!-- Contact form plugin -->
<script src="{{asset('assets/frontend/js/contact-me.js')}}"></script>

<!-- Popup Newsletter Form -->
<script src="{{asset('assets/frontend/js/classie.js')}}"></script>
<script src="{{asset('assets/frontend/js/dialogFx.js')}}"></script>

<!-- Newsletter plugin -->
<script src="{{asset('assets/frontend/js/notifyMe.js')}}"></script>

<!-- Gallery plugin -->
<script src="{{asset('assets/frontend/js/jquery.detect_swipe.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/featherlight.js')}}"></script>
<script src="{{asset('assets/frontend/js/featherlight.gallery.js')}}"></script>

<!-- Main JS File -->
<script src="{{asset('assets/frontend/js/main.js')}}"></script>

</body>

</html>
