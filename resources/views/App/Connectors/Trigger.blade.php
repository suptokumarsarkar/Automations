<section id="dropdown">
    <div class="moni_container">
        <div class="moni_rh_567_dropdown_wrapper">
            <details class="moni_rh_567_dropdown_details mySelfTrigger" open="">
                <summary class="moni_rh_567_dropdown_summary">
                    <div class="moni_rh_567_dropdown_summary_apps_icon_wrapper">
                        <span class="moni_rh_567_img">
                            <img class="AppTriggerLogo"
                                 style="height: 40px; width: 40px; border-radius: 0; object-fit: contain;"
                                 src="{{$app->getLogo()}}" alt="{{$app->app->AppName}}">
                        </span>
                        <div class="moni_rh_567_dropdown_summary_apps_icon_tag_content">
                            <div class="moni_rh_567_dropdown_summary_apps_icon_tag_content_heading_wrapper">
                                <span class="moni_rh_567_dropdown_summary_apps_icon_tag_content_svg_icon_tag">
                                   {{\App\Logic\translate('Trigger')}}
                                </span>
                            </div>
                            <div
                                class="moni_rh_567_dropdown_summary_apps_icon_tag_content_svg_icon_tag_title triggers_140">
                                <h2 class="AppTriggerName">{{\App\Logic\translate($app->getTriggers()[0]['name'])}}</h2>
                                <h6 class="AppTriggerDescription">{{\App\Logic\translate($app->getTriggers()[0]['description'])}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="moni_rh_567_right_content">
                        <span class="moni_rh_567_right_content_svg_icon_wrapper balmiki">
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C13.9778 22 15.9112 21.4135 17.5557 20.3147C19.2002 19.2159 20.4819 17.6541 21.2388 15.8268C21.9957 13.9996 22.1937 11.9889 21.8079 10.0491C21.422 8.10929 20.4696 6.32746 19.0711 4.92894C17.6725 3.53041 15.8907 2.578 13.9509 2.19215C12.0111 1.8063 10.0004 2.00433 8.17316 2.76121C6.3459 3.51809 4.78412 4.79981 3.6853 6.4443C2.58649 8.08879 2 10.0222 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C6.8043 20.9464 9.34784 22 12 22ZM8.21 10.79L11 13.59L16.29 8.29L17.71 9.71L11 16.41L6.79 12.21L8.21 10.79Z"
                                    fill="#0F884E"></path></svg>
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22ZM11 7H13V13H11V7ZM12 14.75C12.69 14.75 13.25 15.31 13.25 16C13.25 16.69 12.69 17.25 12 17.25C11.31 17.25 10.75 16.69 10.75 16C10.75 15.31 11.31 14.75 12 14.75Z"
                                    fill="#DFB900"></path></svg>
                        </span>
                    </div>
                </summary>

                <details class="moni_rh_567_dropdown_details_inner_details triggerFirst" open="">
                    <summary class="moni_rh_567_dropdown_summary_inner_summary">
                        <h3 class="moni_rh_567_dropdown_summary_inner_summary_heading"><i
                                class="fa-solid fa-angle-down"></i>{{\App\Logic\translate('Choose app & event')}}</h3>
                        <span class="moni_rh_567_dropdown_summary_inner_summary_heading_svg_icon balmiki">
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C13.9778 22 15.9112 21.4135 17.5557 20.3147C19.2002 19.2159 20.4819 17.6541 21.2388 15.8268C21.9957 13.9996 22.1937 11.9889 21.8079 10.0491C21.422 8.10929 20.4696 6.32746 19.0711 4.92894C17.6725 3.53041 15.8907 2.578 13.9509 2.19215C12.0111 1.8063 10.0004 2.00433 8.17316 2.76121C6.3459 3.51809 4.78412 4.79981 3.6853 6.4443C2.58649 8.08879 2 10.0222 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C6.8043 20.9464 9.34784 22 12 22ZM8.21 10.79L11 13.59L16.29 8.29L17.71 9.71L11 16.41L6.79 12.21L8.21 10.79Z"
                                    fill="#0F884E"></path></svg>
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22ZM11 7H13V13H11V7ZM12 14.75C12.69 14.75 13.25 15.31 13.25 16C13.25 16.69 12.69 17.25 12 17.25C11.31 17.25 10.75 16.69 10.75 16C10.75 15.31 11.31 14.75 12 14.75Z" fill="#DFB900"></path></svg>
                        </span>
                    </summary>

                    <div class="moni_rh_567_summary_content_wrapper">
                        <div class="moni_rh_567_summary_content_first_row_wrapper">
                            <div class="moi_rh_567_summary_content_first_row_left_content">
                                <span class="moni_rh_567_summary_content_first_row_left_content_img">
                                    <img class="AppTriggerLogo"
                                         style="height: 30px; width: 30px; border-radius: 0; object-fit: contain;"
                                         src="{{$app->getLogo()}}" alt="img">
                                </span>
                                <span
                                    class="moni_rh_567_summary_content_first_row_left_content_img_tag AppName">{{\App\Logic\translate($app->app->AppName)}}</span>
                            </div>
                            <div class="moi_rh_567_summary_content_first_row_right_content">
                                <button
                                    class="moi_rh_567_summary_content_first_row_right_content_btn"
                                    onclick="changeTrigger()">{{\App\Logic\translate('Change')}}</button>
                            </div>
                        </div>
                        <div class="moni_rh_567_summary_content_secend_row_wrapper">
                            <label for="triggers">{{\App\Logic\translate('Event')}}<p>
                                    ({{\App\Logic\translate('Required')}})</p></label>
                            <select name="triggers" id="triggers" class="niceSelect full-width"
                                    onchange="changeMode(this, 'triggers_140')">
                                @foreach($app->getTriggers() as $triggers)
                                    <option title="{{$triggers['description']}}"
                                            name="{{$triggers['name']}}"
                                            value="{{$triggers['id']}}">{{$triggers['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="moni_rh_567_summary_description">
                            <p>{{\App\Logic\translate('This is performed when the Nit runs')}}</p>
                        </div>
                        <div class="moni_rh_567_summary_btn_wrapper">
                            <button class="moni_rh_567_summary_btn"
                                    onclick="goNext()">{{\App\Logic\translate('Continue')}}</button>
                        </div>
                    </div>

                </details>

                <details class="moni_rh_567_dropdown_details_inner_details" id="trigger_next" style="display: none;">
                    <summary class="moni_rh_567_dropdown_summary_inner_summary">
                        <h3 class="moni_rh_567_dropdown_summary_inner_summary_heading"><i
                                class="fa-solid fa-angle-down"></i>{{\App\Logic\translate('Choose account')}}</h3>
                        <span class="moni_rh_567_dropdown_summary_inner_summary_heading_svg_icon balmiki">
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C13.9778 22 15.9112 21.4135 17.5557 20.3147C19.2002 19.2159 20.4819 17.6541 21.2388 15.8268C21.9957 13.9996 22.1937 11.9889 21.8079 10.0491C21.422 8.10929 20.4696 6.32746 19.0711 4.92894C17.6725 3.53041 15.8907 2.578 13.9509 2.19215C12.0111 1.8063 10.0004 2.00433 8.17316 2.76121C6.3459 3.51809 4.78412 4.79981 3.6853 6.4443C2.58649 8.08879 2 10.0222 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C6.8043 20.9464 9.34784 22 12 22ZM8.21 10.79L11 13.59L16.29 8.29L17.71 9.71L11 16.41L6.79 12.21L8.21 10.79Z"
                                    fill="#0F884E"></path></svg>
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22ZM11 7H13V13H11V7ZM12 14.75C12.69 14.75 13.25 15.31 13.25 16C13.25 16.69 12.69 17.25 12 17.25C11.31 17.25 10.75 16.69 10.75 16C10.75 15.31 11.31 14.75 12 14.75Z" fill="#DFB900"></path></svg>

                        </span>
                    </summary>
                    <input type="hidden" name="accountId" id="apiAccountId">
                    <div class="moni_rh_567_summary_content_wrapper">
                        <div class="zap_rd_rox"></div>
                        <div class="moni_rh_567_summary_content_first_row_wrapper">
                            <div class="moi_rh_567_summary_content_first_row_left_content">
                                <span class="moni_rh_567_summary_content_first_row_left_content_img">
                                    <img class="AppTriggerLogo"
                                         style="height: 30px; width: 30px; border-radius: 0; object-fit: contain;"
                                         src="{{$app->getLogo()}}" alt="img">
                                </span>
                                <span
                                    class="moni_rh_567_summary_content_first_row_left_content_img_tag">{{\App\Logic\translate('Connect New Account')}}</span>
                            </div>
                            <div class="moi_rh_567_summary_content_first_row_right_content">
                                <button
                                    class="moi_rh_567_summary_content_first_row_right_content_sign_in_btn moni_rh_567_btn_40140"
                                    onclick="connectAccount()">{{\App\Logic\translate('Sign In')}}</button>
                            </div>
                        </div>
                        <div class="moni_rh_567_summary_description">
                            <span
                                class=""><b class="AppName">{{\App\Logic\translate($app->app->AppName)}}</b> {{\App\Logic\translate('is a secure partner with LightNit')}}. {{\App\Logic\translate('Your credentials are encrypted & can be removed at any time.')}} <a
                                    href="">{{\App\Logic\translate('You can manage all of your connected accounts here.')}}</a></span>
                        </div>
                        <div class="moni_rh_567_summary_btn_wrapper">
                            <button class="moni_rh_567_summary_disbled_btn enable_now">{{\App\Logic\translate('Run Trigger')}}</button>
                        </div>
                    </div>

                </details>


                <details class="moni_rh_567_dropdown_details_inner_details triggerBlock" open="" style="display: none;">
                    <summary class="moni_rh_567_dropdown_summary_inner_summary">
                        <h3 class="moni_rh_567_dropdown_summary_inner_summary_heading"><i
                                class="fa-solid fa-angle-down"></i>{{\App\Logic\translate('App Trigger')}}</h3>
                        <span class="moni_rh_567_dropdown_summary_inner_summary_heading_svg_icon balmiki">
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C13.9778 22 15.9112 21.4135 17.5557 20.3147C19.2002 19.2159 20.4819 17.6541 21.2388 15.8268C21.9957 13.9996 22.1937 11.9889 21.8079 10.0491C21.422 8.10929 20.4696 6.32746 19.0711 4.92894C17.6725 3.53041 15.8907 2.578 13.9509 2.19215C12.0111 1.8063 10.0004 2.00433 8.17316 2.76121C6.3459 3.51809 4.78412 4.79981 3.6853 6.4443C2.58649 8.08879 2 10.0222 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C6.8043 20.9464 9.34784 22 12 22ZM8.21 10.79L11 13.59L16.29 8.29L17.71 9.71L11 16.41L6.79 12.21L8.21 10.79Z"
                                    fill="#0F884E"></path></svg>
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22ZM11 7H13V13H11V7ZM12 14.75C12.69 14.75 13.25 15.31 13.25 16C13.25 16.69 12.69 17.25 12 17.25C11.31 17.25 10.75 16.69 10.75 16C10.75 15.31 11.31 14.75 12 14.75Z" fill="#DFB900"></path></svg>
                        </span>
                    </summary>

                    <div class="moni_rh_567_summary_content_wrapper">
                        <div class="moni_rh_567_summary_content_secend_row_wrapper app_trigger_comment">

                        </div>
                        <div class="moni_rh_567_summary_btn_wrapper">
                            <button class="moni_rh_567_summary_btn"
                                    onclick="goActionPage()">{{\App\Logic\translate('Check Action')}}</button>
                        </div>
                    </div>

                </details>


            </details>
        </div>

    </div>
</section>
@push('MasterScript')

    <script>
        function changeTrigger() {
            $(".modal_f12").show("slow");
            setModalMode("changeTriggerNow");
            makeItzero();
        }

        function goActionPage() {
            $(".mySelfTrigger").attr("open", false);
            $(".mySelfAction").slideDown();
            scroll_to_id(".mySelfAction",20);
            console.log($("#triggerForm").serialize());
            $(".mySelfAction").attr("open", true);
        }

        function changeTriggerNow(AppId) {
            $.ajax({
                url: '{{route('getApp')}}',
                type: 'POST',
                data: 'AppId=' + AppId,
                success: function (data) {
                    app = JSON.parse(data);
                    getAccounts(app.AppId, app.getLogo);
                    setEvent(app.getTriggers);
                    setEnvironments(app);
                    $(".appScriptSection").html(app.script);
                }
            });
            $(".modal_f12").fadeOut("slow");
        }

        function setEvent(events) {
            let html = '';
            console.log(events);
            for (let i = 0; i < events.length; i++) {
                html += `
                <option title="` + events[i].description + `"
                                            name="` + events[i].name + `"
                                            value="` + events[i].id + `">` + events[i].name + `</option>
                `;
            }
            $("#triggers").html(html);
            $("#triggers").niceSelect("update");
        }

        function setEnvironments(app) {
            $(".AppTriggerLogo").attr('src', app.getLogo);
            $(".AppName").html(app.AppName);
            $(".AppTriggerName").html($("#triggers").find('option:selected').attr("name"));
            $(".AppTriggerDescription").html($("#triggers").find('option:selected').attr("title"));
        }


        let accounts = null;

        function goNext() {
            $('#trigger_next').slideDown();
            document.getElementById('trigger_next').open = true;
            scroll_to_id('#trigger_next', 20)
        }

        function getAccounts(AppId = '{{$app->app->AppId}}', logo = '{{$app->getLogo()}}', selectText = '{{\App\Logic\translate('Select')}}') {
            $.ajax({
                url: '{{route('getAccounts')}}',
                type: 'POST',
                data: 'AppId=' + AppId,
                success: function (data) {
                    accounts = JSON.parse(data);
                    setAccounts(logo, selectText);
                    getAccountsAction();
                }
            });
        }

        function selectAccount(lastId) {
            $("#apiAccountId").val(lastId);
            $(".connection_bajar").removeClass('activeHeroAccount141');
            $(".classBajar" + lastId).addClass('activeHeroAccount141');
            $(".connection_bajar").find('button.moi_rh_567_summary_content_first_row_right_content_sign_in_btn').text('{{\App\Logic\translate('select')}}');
            $(".classBajar" + lastId).find('button.moi_rh_567_summary_content_first_row_right_content_sign_in_btn').text('{{\App\Logic\translate('selected')}}');
        }

        function setAccounts(logo = '{{$app->getLogo()}}', selectText = '{{\App\Logic\translate('Select')}}') {
            if (accounts != null) {
                let html = '';
                let lastId = null;
                for (let i = 0; i < accounts.length; i++) {
                    let account = accounts[i];
                    lastId = account.id;
                    let data = JSON.parse(account.data);
                    let token = JSON.parse(account.token);
                    let displayName = getPersonalStatement(data);
                    html += `
<div class="connection_bajar classBajar` + account.id + `">
   <div class="moni_rh_567_summary_content_first_row_wrapper">
                            <div class="moi_rh_567_summary_content_first_row_left_content">
                                <span class="moni_rh_567_summary_content_first_row_left_content_img">
                                    <img style="height: 30px; width: 30px; border-radius: 0; object-fit: contain;"
                                         src="` + logo + `" alt="img">
                                </span>
                                <span
                                    class="moni_rh_567_summary_content_first_row_left_content_img_tag">` + displayName + `</span>
                            </div>
                            <div class="moi_rh_567_summary_content_first_row_right_content">
                                <button
                                    class="moi_rh_567_summary_content_first_row_right_content_sign_in_btn" onclick='selectAccount("` + account.id + `")'>` + selectText + `</button>
                            </div>
                        </div>
</div>
                    `;

                }
                if (html !== '') {
                    html += " <div class='orConnector'>Or</div>"
                }
                $(".zap_rd_rox").html(html);
                selectAccount(lastId);
            }
        }

        $(document).ready(function () {
            getAccounts();

            $(".AppTriggerName").html($("#triggers").find('option:selected').attr("name"));
            $(".AppTriggerDescription").html($("#triggers").find('option:selected').attr("title"));

            let clanCastle = setInterval(() => {
                $(".balmiki").addClass('oisoriya');
                if($("#apiAccountId").val() !== ''){
                    $(".moni_rh_567_summary_disbled_btn").addClass('enable_now');
                    $("#trigger_next .balmiki").addClass('oisoriya');
                    $(".moni_rh_567_dropdown_summary_apps_icon_wrapper .balmiki").addClass('oisoriya');
                }else{
                    $(".moni_rh_567_dropdown_summary_apps_icon_wrapper .balmiki").removeClass('oisoriya');
                    $("#trigger_next .balmiki").removeClass('oisoriya');
                    $(".moni_rh_567_summary_disbled_btn").removeClass('enable_now');
                }
            }, 1000);

            $(".enable_now").click(function(){
                checkTrigger($("#triggers").val(),$("#apiAccountId").val());
            });
        });
    </script>
    <div class="appScriptSection">
        @includeIf('App.Script.'.$app->app->AppId)
    </div>
@endpush
