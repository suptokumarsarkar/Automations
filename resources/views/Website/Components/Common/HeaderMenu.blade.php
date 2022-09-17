<!-- navbar start -->
<nav class="navbar navbar-expand-lg navbar-light  full-menu"
     style="position: sticky; top: 0; width: 100%; background: white; z-index: 100">
    <div class="container-xl">
        <div class="part_maker">
            <button class="navbar-toggler" style="border:none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{route('home')}}" aria-label="Go to the LightNit Homepage">
                <img src="{{\App\Logic\Settings::getLogo()}}" alt="{{\App\Logic\translate('LightNit')}}"
                     style="width: 82px">
            </a>

        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                        Products
                    </a>
                    <ul class="hover_menu">
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('products.howItWorks')}}">{{\App\Logic\translate('how_it_works')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('products.features')}}">{{\App\Logic\translate('features')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('products.customerStories')}}">{{\App\Logic\translate('customer_stories')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('products.security')}}">{{\App\Logic\translate('security')}}</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                        Explore
                    </a>
                    <ul class="hover_menu">
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('explore.apps')}}">{{\App\Logic\translate('apps_that_works_with_lightNit')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('explore.roles')}}">{{\App\Logic\translate('apps_by_job_role')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('explore.popular')}}">{{\App\Logic\translate('popular_way_to_use')}}</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)">
                        Resources
                    </a>
                    <ul class="hover_menu">
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('products.customerStories')}}">{{\App\Logic\translate('help')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('products.customerStories')}}">{{\App\Logic\translate('blog')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('products.customerStories')}}">{{\App\Logic\translate('about_us')}}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link hover_item"
                                                href="{{route('products.customerStories')}}">{{\App\Logic\translate('contact_us')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('team-and-companies')}}">Team and Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('pricing')}}">Pricing</a>
                </li>

            </ul>
            @if(Auth::check())
                <ul class="login-signup-wrapper">
                    <li class="signup"><a class="signup-link"
                                          href="{{route('logout')}}">{{\App\Logic\translate('Logout')}}</a></li>
                </ul>
            @else
                <ul class="login-signup-wrapper">
                    <li class="login"><a class="login-link"
                                         href="{{route('login')}}">{{\App\Logic\translate('login')}}</a></li>
                    <li class="signup"><a class="signup-link"
                                          href="{{route('register')}}">{{\App\Logic\translate('sign_up')}}</a></li>
                </ul>
            @endif
        </div>
        <form style="position:absolute; display: none;" class="autocomplete" id="rjsearch_result">

            <span class="search_icon"><i class="fa-solid fa-magnifying-glass"></i></span>

            <input class="form-control me-2" autocomplete="off" type="search" placeholder="Search" aria-label="Search"
                   id="rjsearch">

        </form>
        <div class="login_btn">
            <label for="rjsearch" style="cursor:pointer;" onclick="rjSearch(this)">
                <span class="mx-3"><i class="fas fa-search"></i></span>
            </label>
            @if(Auth::check())
                <a href="{{ route("logout") }}" class="btn btn-md sign">{{\App\Logic\translate('Logout')}}</a>
            @else
                <a href="{{ route("login") }}" class="btn btn-md last-login-try">{{\App\Logic\translate('login')}}</a>
                <a href="{{ route("register") }}" class="btn btn-md sign">{{\App\Logic\translate('sign_up')}}</a>
            @endif

        </div>
    </div>
</nav>
<!-- navbar end -->
@push("headerScript")
    <style>
        .autocomplete {
            /*the container must be positioned relative:*/
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
@endpush
@push("MasterScript")
    <script>
        $.ajax({
            url: '{{route('getApps')}}',
            data: 'json=true',
            success: function (data) {
                data = JSON.parse(data);
                autocomplete(document.getElementById("rjsearch"), data);
            }
        });

        function justLeaveItAlone($func, $gcc) {
            window.location = '{{route('Apps.index')}}/' + $gcc;
        }
    </script>
@endpush
