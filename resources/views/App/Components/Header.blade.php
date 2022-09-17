<header id="header">
    <nav class="moni_flex_div">
        <div class="moni_nav_left moni_flex_div">
            <span class="minimize" onclick="sidebarAction()">
                <svg class="closer-124" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg"><path
                        d="M16.29 6.29001L12 10.59L7.71004 6.29001L6.29004 7.71001L10.59 12L6.29004 16.29L7.71004 17.71L12 13.41L16.29 17.71L17.71 16.29L13.41 12L17.71 7.71001L16.29 6.29001Z"
                        fill="#2D2E2E"></path></svg>
                <svg class="opener-124" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg"><path d="M20 6H4V8H20V6Z" fill="#2D2E2E"></path><path
                        d="M20 11H4V13H20V11Z" fill="#2D2E2E"></path><path d="M20 16H4V18H20V16Z" fill="#2D2E2E"></path></svg>
            </span>
            <span class="logo">
                <img src="{{\App\Logic\Settings::getLogo()}}" alt="{{\App\Logic\translate('LightNit')}}"
                     style="width: 69px">
            </span>
        </div>
        <div class="moni_nav_middle moni_flex_div search_div-rx hidden-rx">
            <div class="moni_search_box">
                <input autocomplete="off" type="text" id="rjsearch" placeholder="Search by apps">
                <div class="moni_search_icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.13405 17.4518L2.2915 20.2943L3.7057 21.7085L6.54825 18.866L5.13405 17.4518Z"
                              fill="#2D2E2E"></path>
                        <path
                            d="M13 3C8.59 3 5 6.59 5 11C5 14.75 7.98 19 13 19C17.41 19 21 15.41 21 11C21 6.59 17.41 3 13 3ZM13 17C9.2 17 7 13.79 7 11C7 7.69 9.69 5 13 5C16.31 5 19 7.69 19 11C19 14.31 16.31 17 13 17Z"
                            fill="#95928E"></path>
                    </svg>
                </div>
            </div>
            <div class="moni_times_icon" onclick="showHideSearch();">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16.29 6.29001L12 10.59L7.71004 6.29001L6.29004 7.71001L10.59 12L6.29004 16.29L7.71004 17.71L12 13.41L16.29 17.71L17.71 16.29L13.41 12L17.71 7.71001L16.29 6.29001Z"
                        fill="#2D2E2E"></path>
                </svg>
            </div>
        </div>
        <div class="moni_nav_right moni_flex_div">
            <label for="rjsearch">

                <div class="moni_nav_right_search_icon" onclick="showHideSearch();">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.13405 17.4518L2.2915 20.2943L3.7057 21.7085L6.54825 18.866L5.13405 17.4518Z"
                              fill="#2D2E2E"></path>
                        <path
                            d="M13 3C8.59 3 5 6.59 5 11C5 14.75 7.98 19 13 19C17.41 19 21 15.41 21 11C21 6.59 17.41 3 13 3ZM13 17C9.2 17 7 13.79 7 11C7 7.69 9.69 5 13 5C16.31 5 19 7.69 19 11C19 14.31 16.31 17 13 17Z"
                            fill="#2D2E2E"></path>
                    </svg>
                </div>
            </label>

            <div class="moni_nav_right_user_shortcut_name">
                {{--                <p class="shortcut_name">ms</p>--}}
                <div class="moni_user_img_wrapper" style="cursor: pointer" onclick="pupupUserLogout()">
                    <img class="moni_user_img" src="{{Auth::user()->getProfilePicture()}}" alt="">
                </div>

                <div class="user_card_dropdrown">
                    <div class="moni_user_card_email">
                        <span>{{Auth::user()->email}}</span>
                    </div>
                    <div class="moni_user_card_wrapper">
                        <a href="">
                            <div class="moni_user_settings">
                            <span class="moni_setting_icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg"><path
                                        d="M19.9 8.90001C19.12 8.45001 18.64 7.62001 18.64 6.72001L18.65 4.30001L15.36 2.40001L13.27 3.62001C12.49 4.07001 11.53 4.07001 10.75 3.62001L8.65 2.39001L5.36 4.29001L5.37 6.71001C5.37 7.61001 4.89 8.44001 4.11 8.89001L2 10.1V13.91L4.1 15.11C4.88 15.56 5.36 16.39 5.36 17.29L5.35 18.92L7.36 17.74V17.3C7.37 15.68 6.5 14.18 5.09 13.37L4 12.74V11.26L5.1 10.63C6.51 9.83001 7.38 8.32001 7.37 6.70001V5.44001L8.64 4.70001L9.73 5.34001C11.13 6.16001 12.87 6.16001 14.27 5.34001L15.36 4.70001L16.64 5.44001V6.70001C16.63 8.32001 17.5 9.82001 18.91 10.63L20.01 11.26V12.74L18.91 13.37C17.5 14.17 16.63 15.68 16.64 17.3V18.56L15.36 19.3L14.27 18.66C13.57 18.25 12.79 18.05 12 18.05C11.21 18.05 10.43 18.25 9.73 18.66L6.66 20.46L8.65 21.61L10.74 20.39C11.52 19.94 12.48 19.94 13.26 20.39L15.35 21.61L18.64 19.71L18.63 17.29C18.63 16.39 19.11 15.56 19.89 15.11L21.99 13.91V10.1L19.9 8.90001Z"
                                        fill="#2D2E2E"></path><path
                                        d="M12 16.5C14.48 16.5 16.5 14.48 16.5 12C16.5 9.52 14.48 7.5 12 7.5C9.52 7.5 7.5 9.52 7.5 12C7.5 14.48 9.52 16.5 12 16.5ZM12 9.5C13.38 9.5 14.5 10.62 14.5 12C14.5 13.38 13.38 14.5 12 14.5C10.62 14.5 9.5 13.38 9.5 12C9.5 10.62 10.62 9.5 12 9.5Z"
                                        fill="#2D2E2E"></path></svg>
                            </span>
                                <span class="moni_setting_text">Settings</span>
                            </div>
                        </a>
                        <a href="{{route('logout')}}">
                            <div class="moni_user_settings">
                            <span class="moni_setting_icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg"><path
                                            d="M3 21H5V3H3V21ZM17.27 6H14.66L18.86 11H7V13H18.86L14.66 18H17.27L22.27 12L17.27 6Z"
                                            fill="#2D2E2E"></path></svg>
                            </span>
                                <span class="moni_setting_text">Log out</span>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </nav>
</header>
@push('headerScript')
    <style>
        .rj-moni-dj-dancing {
            width: 28px;
            margin-right: 12px;
        }

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
@push('MasterScript')

    <script>
        function sidebarAction() {
            $("#sidebar").toggleClass("responsive1440");
            $(".minimize").toggleClass("closers");
            $.ajax({
                url: '{{route('session.sideBar')}}',
                method: 'POST'
            });
        }

        @if(\Illuminate\Support\Facades\Session::get('sidebar'))
        sidebarAction();
        @endif

        function showHideSearch() {
            $(".search_div-rx").toggleClass('hidden-rx');
            $(".logo").toggleClass('hidden-rx');
        }

        $(document).ready(function () {
            const window_height = $("body").innerHeight();
            const banner = $("#unfixed_header").innerHeight();
            const header = $("#header").innerHeight();
            let height = window_height - (banner + header);
            $("#sidebar").css('height', height + "px");
        });
        $("body").click(function (event) {
            if ($(".user_card_dropdrown").hasClass("open-dropdown")) {
                $(".user_card_dropdrown").slideUp();
                $(".user_card_dropdrown").removeClass("open-dropdown");
            }
        });

        function pupupUserLogout() {
            $(".user_card_dropdrown").slideToggle();
            setTimeout(() => {
                $(".user_card_dropdrown").toggleClass('open-dropdown');
            }, 1000);
        }
    </script>
    <script>
        $.ajax({
            url: '{{route('getApps')}}',
            data: 'json=true',
            success: function (data) {
                data = JSON.parse(data);
                autocomplete(document.getElementById("rjsearch"), data);
            }
        });

        function justLeaveItAloneV2($func, $gcc) {
            if ($func == null) {
                window.location = '{{route('Apps.index')}}/' + $gcc;
            }
        }
    </script>
@endpush
