<section id="main">
    <div class="moni_main_wrapper">
        <h1 class="moni_main_heading">{{\App\Logic\translate("Welcome to LightNit!")}}</h1>
        <div class="moni_workflow_box">
            <h2 class="moni_wrokflow_box_title">Create your own workflow</h2>
            <p class="moni_wrokflow_box_description">Know exactly what you want to build? Select the apps you want to
                connect to start your custom setup.</p>
            <div class="moni_wrokflow_box_search_app_row">
                <div class="moni_wrokflow_box_search_app_col">
                    <label class="moni_label"
                           for="connect_1"><span>{{\App\Logic\translate('with this one!')}}</span></label>
                    <input type="text" @if(isset($apps))
                        value = '{{$apps->AppName}}'
                           @endif
                           id="connect_1" onkeyup="cht1()" autocomplete="off"
                           placeholder="Search for an app">
                    <span class="moni_svg_icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                                d="M5.13405 17.4518L2.2915 20.2943L3.7057 21.7085L6.54825 18.866L5.13405 17.4518Z"
                                fill="#2D2E2E"></path><path
                                d="M13 3C8.59 3 5 6.59 5 11C5 14.75 7.98 19 13 19C17.41 19 21 15.41 21 11C21 6.59 17.41 3 13 3ZM13 17C9.2 17 7 13.79 7 11C7 7.69 9.69 5 13 5C16.31 5 19 7.69 19 11C19 14.31 16.31 17 13 17Z"
                                fill="#2D2E2E"></path></svg>
                    </span>
                </div>
                <div class="moni_wrokflow_box_search_app_col">
                    <label class="moni_label"
                           for="connect_2"><span>{{\App\Logic\translate('Connect this app...')}} </span> </label>
                    <input type="text" id="connect_2" onkeyup="cht2()" autocomplete="off"
                           placeholder="Search for an app">
                    <span class="moni_svg_icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                                d="M5.13405 17.4518L2.2915 20.2943L3.7057 21.7085L6.54825 18.866L5.13405 17.4518Z"
                                fill="#2D2E2E"></path><path
                                d="M13 3C8.59 3 5 6.59 5 11C5 14.75 7.98 19 13 19C17.41 19 21 15.41 21 11C21 6.59 17.41 3 13 3ZM13 17C9.2 17 7 13.79 7 11C7 7.69 9.69 5 13 5C16.31 5 19 7.69 19 11C19 14.31 16.31 17 13 17Z"
                                fill="#2D2E2E"></path></svg>
                    </span>
                </div>
            </div>
            <div class="continue_integration">
                <button class="continue">{{\App\Logic\translate('Continue')}}</button>
            </div>
        </div>
    </div>
</section>


@push("MasterScript")

    <script>
        $.ajax({
            url: '{{route('getApps')}}',
            data: 'json=true',
            success: function (data) {
                data = JSON.parse(data);
                autocomplete(document.getElementById("connect_1"), data, 'action_checkup');
                autocomplete(document.getElementById("connect_2"), data, 'action_checkup2');
            }
        });
        let hook1 = null;
        @if(isset($apps))
            hook1 = '{{$apps->AppId}}';
        @endif
        let hook2 = null;

        function cht2() {
            hook2 = null;
            checkButton();
        }

        function cht1() {
            hook1 = null;
            console.log(hook1);
            checkButton();
        }

        function justLeaveItAlone(func, id) {
            setTimeout(() => {
                if (func === 'action_checkup') {
                    hook1 = id;
                }
                if (func === 'action_checkup2') {
                    hook2 = id;
                }
                checkButton();
            }, 300);

        }

        function checkButton() {
            if (hook1 != null && hook2 != null) {
                $(".continue_integration .continue").show();
            } else {
                $(".continue_integration .continue").hide();
            }
        }

        $(".continue_integration").click(function (){
            window.location = '{{route('Apps.index')}}/'+hook1+"/"+hook2;
        });
    </script>
@endpush
