<div class="modal_f12" style="display: none;">
    <section id="modal_2356">
        <div class="moni_248_model_wrapper">
            <div class="moni_248_model_header_row">
                <div class="moni_248_model_header_left_col">
                <span class="moni_248_model_header_left_col_icon_wrapper">
                    <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg"><g
                            clip-path="url(#clip0_5818_280673)"><path d="M3.95703 1.32031V31.6803" stroke="#1f3121"
                                                                      stroke-width="6.6" stroke-linecap="square"></path><path
                                d="M8.9541 13.3688H6.4791V18.3187H8.9541V13.3688ZM29.0367 18.3187H31.5117V13.3688H29.0367V18.3187ZM8.9541 18.3187H12.092V13.3688H8.9541V18.3187ZM15.8575 18.3187H22.1333V13.3688H15.8575V18.3187ZM25.8988 18.3187H29.0367V13.3688H25.8988V18.3187Z"
                                fill="#1f3121"></path></g><defs><clipPath id="clip0_5818_280673"><rect width="33"
                                                                                                       height="33"
                                                                                                       fill="white"></rect></clipPath></defs></svg>
                </span>
                    <div class="moni_248_model_header_left_col_icon_tag_content">
                        <h2 class="moni_248_model_header_left_col_icon_tag_content_title">{{\App\Logic\translate('Change trigger')}}</h2>
                        <p class="moni_248_model_header_left_col_icon_tag_content_about">{{\App\Logic\translate('A trigger is an event that
                            starts your Nit')}}</p>
                    </div>
                </div>
                <div class="moni_248_model_header_right_col">
                <span class="moni_248_model_header_right_col_minimize_icon_wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg"><path
                            d="M16.29 6.29001L12 10.59L7.71004 6.29001L6.29004 7.71001L10.59 12L6.29004 16.29L7.71004 17.71L12 13.41L16.29 17.71L17.71 16.29L13.41 12L17.71 7.71001L16.29 6.29001Z"
                            fill="white"></path></svg>
                </span>
                </div>
            </div>
            <div class="moni_248_model_main_row">
                <div class="moni_248_model_main_first_content">
                    <h3 class="moni_248_model_main_first_content_title">{{\App\Logic\translate('App event')}}</h3>
                    <span
                        class="moni_248_model_main_first_content_about">{{\App\Logic\translate('Start the Nit when something happens in an app')}}</span>
                </div>
                <div class="moni_248_model_main_input_box_wrapper">
                    <label for="searcher151241">
                        <input id="searcher151241" onkeyup="makeSearch(this.value)" type="text"
                               placeholder="Search apps...">
                        <span class="moni_248_model_main_search_icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                            d="M5.13405 17.4518L2.2915 20.2943L3.7057 21.7085L6.54825 18.866L5.13405 17.4518Z"
                            fill="#2D2E2E"></path><path
                            d="M13 3C8.59 3 5 6.59 5 11C5 14.75 7.98 19 13 19C17.41 19 21 15.41 21 11C21 6.59 17.41 3 13 3ZM13 17C9.2 17 7 13.79 7 11C7 7.69 9.69 5 13 5C16.31 5 19 7.69 19 11C19 14.31 16.31 17 13 17Z"
                            fill="#2D2E2E"></path></svg>
                </span>
                        <span class="moni_248_model_main_minimize_icon" onclick="makeItzero()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                            d="M19.0701 4.93C15.1601 1.02 8.83012 1.02 4.92012 4.93C1.02012 8.83 1.02012 15.17 4.92012 19.07C8.83012 22.98 15.1601 22.98 19.0701 19.07C22.9801 15.17 22.9801 8.83 19.0701 4.93ZM16.2401 14.74L14.8301 16.15L12.0001 13.33L9.17012 16.16L7.76012 14.75L10.5901 11.92L7.76012 9.08L9.17012 7.67L12.0001 10.5L14.8301 7.67L16.2401 9.08L13.4101 11.91L16.2401 14.74Z"
                            fill="#2D2E2E"></path></svg>
                </span>
                    </label>

                </div>
                <div class="moni_248_model_main_apps_row sdf154sdf1ed10d1e4d">

                </div>
            </div>
        </div>
    </section>
    <div class="overflow_99_fcq"></div>
</div>
@push('headerScript')
    <link rel="stylesheet" href="{{asset('public/css/app/modal.css')}}">
@endpush
@push('MasterScript')
    <script>
        $(".moni_248_model_header_right_col").click(function () {
            $(".modal_f12").fadeOut("slow");
        });
        let apps = null;
        function makeItzero(){
            $("#searcher151241").val("");
            makeSearch("");
        }
        let mode = 'changeTriggerNow';
        function setModalMode(modes){
            mode = modes;
            console.log(mode);
        }
        function makeSearch(string) {
            if (apps === null) {
                return false;
            }
            let html = '';
            for (let i = 0; i < apps.length; i++) {
                if (i >= 10) {
                    break;
                }
                if (apps[i].AppName.toLowerCase().match(string.toLowerCase())) {
                    html += `                <div class="moni_248_model_main_apps_col">
<div class="moni_248_model_main_apps_col_wrapper" onclick="`+mode+`('` + apps[i].AppId + `')">
                        <span class="moni_248_model_main_apps_apps_icon">
                            <img src="` + apps[i].AppLogo + `" alt="img">
                        </span>
                        <p class="moni_248_model_main_apps_apps_icon_tag">` + apps[i].AppName + `</p>
                    </div></div>`;
                }
            }
            $(".sdf154sdf1ed10d1e4d").html(html);
        }

        $(document).ready(function () {
            $.ajax({
                url: '{{route('getApps')}}',
                data: 'json=true',
                success: function (data) {
                    apps = JSON.parse(data);
                    makeSearch('');
                }
            });
        });
    </script>
@endpush
