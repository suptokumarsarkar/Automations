<section id="sidebar">
    <div class="moni_shortcut_link_wrapper">
        <div class="moni_Create_zap_sticy">
            <a href="">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 19V13H19V11H13V5H11V11H5V13H11V19H13Z" fill="#fffdf9"></path>
                </svg>
                <p>{{\App\Logic\translate('Create Nit')}}</p></a>
        </div>
        <a class="link {{\Illuminate\Support\Facades\Request::is("apps*") ? "active" : "hover"}}"
           href="{{route('Apps.index')}}">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M2 15V22H7.29999L9.84 15H2ZM14.58 2H2V13H10.57L14.58 2ZM9.42001 22H22V11H13.43L9.42001 22ZM16.7 2L14.16 9H22V2H16.7Z"
                    fill="#2D2E2E"></path>
            </svg>
            <p style="color: #2d2e2e;">Dashboard</p></a>
        <a class="link  {{\Illuminate\Support\Facades\Request::is("zaps*") ? "active" : "hover"}}"
           href="{{route('Apps.zaps')}}">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 12H7.74996L13 5.75V12H16.25L11 18.25V16H8.99996V23.75L20.54 10H15V0.25L3.45996 14H11V12Z"
                      fill="#2D2E2E"></path>
            </svg>
            <p>{{\App\Logic\translate('Nits')}}</p></a>
        <a class="link hover" href="">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M13.5002 12H16.1102L20.3002 7L16.1102 2H13.5002L16.8602 6H4.00018V8H16.8602L13.5002 12ZM10.5002 12H7.8902L3.7002 17L7.8902 22H10.5002L7.1402 18H20.0002V16H7.1402L10.5002 12Z"
                    fill="#2D2E2E"></path>
            </svg>
            <p>Transfers</p></a>
        <a class="link hover" href="">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 11H11V3H3V11ZM5 5H9V9H5V5Z" fill="#2D2E2E"></path>
                <path d="M3 21H11V13H3V21ZM5 15H9V19H5V15Z" fill="#2D2E2E"></path>
                <path d="M13 21H21V13H13V21ZM15 15H19V19H15V15Z" fill="#2D2E2E"></path>
                <path d="M18 6V3H16V6H13V8H16V11H18V8H21V6H18Z" fill="#2D2E2E"></path>
            </svg>
            <p>My Apps</p></a>
        <a class="link hover" href="">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 2C9.34784 2 6.80432 3.05359 4.92896 4.92896C3.05359 6.80432 2 9.34784 2 12C2 14.6522 3.05359 17.1957 4.92896 19.071C6.80432 20.9464 9.34784 22 12 22C14.6522 22 17.1957 20.9464 19.071 19.071C20.9464 17.1957 22 14.6522 22 12C22 9.34784 20.9464 6.80432 19.071 4.92896C17.1957 3.05359 14.6522 2 12 2ZM12 20C9.87827 20 7.84343 19.1572 6.34314 17.6569C4.84285 16.1566 4 14.1217 4 12C4 9.87827 4.84285 7.84343 6.34314 6.34314C7.84343 4.84285 9.87827 4 12 4C14.1217 4 16.1566 4.84285 17.6569 6.34314C19.1572 7.84343 20 9.87827 20 12C20 14.1217 19.1572 16.1566 17.6569 17.6569C16.1566 19.1572 14.1217 20 12 20ZM11 11.53L7.78003 14.23L9.06995 15.77L13 12.47V7H11V11.53Z"
                    fill="#2D2E2E"></path>
            </svg>
            <p>{{\App\Logic\translate('Nit History')}}</p></a>
        <a class="link hover" href="">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.0002 2C7.53017 2 3.74017 4.95 2.46017 9H4.59017C5.42017 6.96 7.07017 5.34 9.13017 4.54L6.78017 11H2.05017C1.46017 16.89 6.10017 22 12.0002 22C17.5102 22 22.0002 17.51 22.0002 12C22.0002 6.49 17.5102 2 12.0002 2ZM11.4402 4.03C12.0102 3.99 12.0102 3.99 12.5302 4.03L15.0702 11H8.90017L11.4402 4.03ZM4.07017 13H6.78017L9.13017 19.46C6.43017 18.41 4.44017 15.96 4.07017 13ZM11.4402 19.97L8.90017 13H15.0702L12.5302 19.97C12.0202 20.01 12.0102 20.01 11.4402 19.97ZM14.8502 19.47L17.2002 13H19.9302C19.5602 15.97 17.5502 18.43 14.8502 19.47ZM17.2002 11L14.8502 4.53C17.5602 5.57 19.5602 8.03 19.9302 11H17.2002Z"
                    fill="#2D2E2E"></path>
            </svg>
            <p>{{\App\Logic\translate('Explore')}}</p></a>
        <a class="link hover" href="">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z"
                    fill="#2D2E2E"></path>
                <path
                    d="M12.0098 18.25C12.7001 18.25 13.2598 17.6904 13.2598 17C13.2598 16.3096 12.7001 15.75 12.0098 15.75C11.3194 15.75 10.7598 16.3096 10.7598 17C10.7598 17.6904 11.3194 18.25 12.0098 18.25Z"
                    fill="#2D2E2E"></path>
                <path
                    d="M12.3599 6.13C11.1799 6.12 10.1699 6.43 9.37988 6.8V8.78C9.99988 8.38 11.0299 7.88 12.2999 7.88C12.3199 7.88 12.3299 7.88 12.3499 7.88C13.6499 7.89 14.4199 8.6 14.4899 9.26C14.5699 10.14 13.5299 10.93 11.8399 11.27L11.1399 11.41L11.1499 14.49H12.8999V12.81C15.5399 12.05 16.3699 10.43 16.2399 9.08C16.0599 7.4 14.4299 6.15 12.3599 6.13Z"
                    fill="#2D2E2E"></path>
            </svg>
            <p>Get Help</p></a>
    </div>
    <hr>
    <div class="moni_free_plan">
        <div class="moni_free_plan_header">
            <span><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                        d="M5 6C4.59 6 4 5.68 4 5V4H20V2H2V19C2 20.65 3.35 22 5 22H22V6H5ZM20 20H5C4.45 20 4 19.55 4 19V7.83C4.32 7.94 4.66 8 5 8H20V20Z"
                        fill="#2D2E2E"></path><path
                        d="M16 16.25C17.2426 16.25 18.25 15.2426 18.25 14C18.25 12.7574 17.2426 11.75 16 11.75C14.7574 11.75 13.75 12.7574 13.75 14C13.75 15.2426 14.7574 16.25 16 16.25Z"
                        fill="#2D2E2E"></path></svg></span>
            <h3>{{\App\Logic\translate('Free Plan')}}</h3>
        </div>
        <div class="moni_users_content">
            <div class="moni_users">
                <div class="moni_users_wrapper">
                    <span class="moni_tasks">{{\App\Logic\translate('Tasks')}}</span>
                    <span class="moni_text_number">0 / 100</span>
                </div>
                <div class="moni_progress_bar"></div>
            </div>
            <div class="moni_users">
                <div class="moni_users_wrapper">
                    <span class="moni_tasks">{{\App\Logic\translate('Nits')}}</span>
                    <span class="moni_text_number">0 / 5</span>
                </div>
                <div class="moni_progress_bar"></div>
            </div>
            <div class="moni_reset_info_wrapper">
                <p class="moni_reset_text">{{\App\Logic\translate('Monthly usage resets in 2 weeks')}}</p>
                <a class="moni_reset_link" href="">{{\App\Logic\translate('Manage Plan')}}</a>
            </div>
        </div>
        <div class="moni_sidebar_under_btn">
            <a class="moni_sidebar_btn" href="">{{\App\Logic\translate('Upgrade plan')}}</a>
        </div>
    </div>
</section>
@push('MasterScript')
    <script>
        $("#sidebar .link").on("mouseover", function () {
            $(this).find("svg path").attr("fill", "#03989EAB");
        });
        $("#sidebar .link").on("mouseout", function () {
            $(this).find("svg path").attr("fill", "#2D2E2E");
        });
    </script>
@endpush
