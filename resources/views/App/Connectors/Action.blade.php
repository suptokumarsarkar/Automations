<section id="dropdown">
    <div class="moni_container">
        <div class="moni_rh_567_dropdown_wrapper">
            <details class="moni_rh_567_dropdown_details mySelfAction" style="display: none;">
                <summary class="moni_rh_567_dropdown_summary">
                    <div class="moni_rh_567_dropdown_summary_apps_icon_wrapper">
                        <span class="moni_rh_567_img">
                            <img class="AppActionLogo"
                                 style="height: 40px; width: 40px; border-radius: 0; object-fit: contain;"
                                 src="{{$app->getLogo()}}" alt="{{$app->app->AppName}}">
                        </span>
                        <div class="moni_rh_567_dropdown_summary_apps_icon_tag_content">
                            <div class="moni_rh_567_dropdown_summary_apps_icon_tag_content_heading_wrapper">
                                <span class="moni_rh_567_dropdown_summary_apps_icon_tag_content_svg_icon_tag">
                                   {{\App\Logic\translate('Action')}}
                                </span>
                            </div>
                            <div
                                class="moni_rh_567_dropdown_summary_apps_icon_tag_content_svg_icon_tag_title actions_140">
                                <h2 class="AppActionName">{{\App\Logic\translate($app->getActions()[0]['name'])}}</h2>
                                <h6 class="AppActionDescription">{{\App\Logic\translate($app->getActions()[0]['description'])}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="moni_rh_567_right_content">
                        <span class="moni_rh_567_right_content_svg_icon_wrapper balmiki_action">
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

                <details class="moni_rh_567_dropdown_details_inner_details actionFirst" open="">
                    <summary class="moni_rh_567_dropdown_summary_inner_summary">
                        <h3 class="moni_rh_567_dropdown_summary_inner_summary_heading"><i
                                class="fa-solid fa-angle-down"></i>{{\App\Logic\translate('Choose app & event')}}</h3>
                        <span class="moni_rh_567_dropdown_summary_inner_summary_heading_svg_icon balmiki_action">
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C13.9778 22 15.9112 21.4135 17.5557 20.3147C19.2002 19.2159 20.4819 17.6541 21.2388 15.8268C21.9957 13.9996 22.1937 11.9889 21.8079 10.0491C21.422 8.10929 20.4696 6.32746 19.0711 4.92894C17.6725 3.53041 15.8907 2.578 13.9509 2.19215C12.0111 1.8063 10.0004 2.00433 8.17316 2.76121C6.3459 3.51809 4.78412 4.79981 3.6853 6.4443C2.58649 8.08879 2 10.0222 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C6.8043 20.9464 9.34784 22 12 22ZM8.21 10.79L11 13.59L16.29 8.29L17.71 9.71L11 16.41L6.79 12.21L8.21 10.79Z"
                                    fill="#0F884E"></path></svg>
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22ZM11 7H13V13H11V7ZM12 14.75C12.69 14.75 13.25 15.31 13.25 16C13.25 16.69 12.69 17.25 12 17.25C11.31 17.25 10.75 16.69 10.75 16C10.75 15.31 11.31 14.75 12 14.75Z"
                                    fill="#DFB900"></path></svg>
                        </span>
                    </summary>

                    <div class="moni_rh_567_summary_content_wrapper">
                        <div class="moni_rh_567_summary_content_first_row_wrapper">
                            <div class="moi_rh_567_summary_content_first_row_left_content">
                                <span class="moni_rh_567_summary_content_first_row_left_content_img">
                                    <img class="AppActionLogo"
                                         style="height: 30px; width: 30px; border-radius: 0; object-fit: contain;"
                                         src="{{$app->getLogo()}}" alt="img">
                                </span>
                                <span
                                    class="moni_rh_567_summary_content_first_row_left_content_img_tag AppName">{{\App\Logic\translate($app->app->AppName)}}</span>
                            </div>
                            <div class="moi_rh_567_summary_content_first_row_right_content">
                                <button
                                    class="moi_rh_567_summary_content_first_row_right_content_btn"
                                    onclick="changeAction()">{{\App\Logic\translate('Change')}}</button>
                            </div>
                        </div>
                        <div class="moni_rh_567_summary_content_secend_row_wrapper">
                            <label for="actions">{{\App\Logic\translate('Action')}}<p>
                                    ({{\App\Logic\translate('Required')}})</p></label>
                            <select name="actions" id="actions" class="niceSelect full-width"
                                    onchange="changeMode(this, 'actions_140')">
                                @foreach($app->getActions() as $actions)
                                    <option title="{{$actions['description']}}"
                                            name="{{$actions['name']}}"
                                            value="{{$actions['id']}}">{{$actions['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="moni_rh_567_summary_description">
                            <p>{{\App\Logic\translate('We are so close to finish.')}}</p>
                        </div>
                        <div class="moni_rh_567_summary_btn_wrapper">
                            <button class="moni_rh_567_summary_btn"
                                    onclick="goNextAction()">{{\App\Logic\translate('Continue')}}</button>
                        </div>
                    </div>

                </details>

                <details class="moni_rh_567_dropdown_details_inner_details" id="action_next" style="display: none;">
                    <summary class="moni_rh_567_dropdown_summary_inner_summary">
                        <h3 class="moni_rh_567_dropdown_summary_inner_summary_heading"><i
                                class="fa-solid fa-angle-down"></i>{{\App\Logic\translate('Choose account')}}</h3>
                        <span class="moni_rh_567_dropdown_summary_inner_summary_heading_svg_icon balmiki_action">
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C13.9778 22 15.9112 21.4135 17.5557 20.3147C19.2002 19.2159 20.4819 17.6541 21.2388 15.8268C21.9957 13.9996 22.1937 11.9889 21.8079 10.0491C21.422 8.10929 20.4696 6.32746 19.0711 4.92894C17.6725 3.53041 15.8907 2.578 13.9509 2.19215C12.0111 1.8063 10.0004 2.00433 8.17316 2.76121C6.3459 3.51809 4.78412 4.79981 3.6853 6.4443C2.58649 8.08879 2 10.0222 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C6.8043 20.9464 9.34784 22 12 22ZM8.21 10.79L11 13.59L16.29 8.29L17.71 9.71L11 16.41L6.79 12.21L8.21 10.79Z"
                                    fill="#0F884E"></path></svg>
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22ZM11 7H13V13H11V7ZM12 14.75C12.69 14.75 13.25 15.31 13.25 16C13.25 16.69 12.69 17.25 12 17.25C11.31 17.25 10.75 16.69 10.75 16C10.75 15.31 11.31 14.75 12 14.75Z"
                                    fill="#DFB900"></path></svg>

                        </span>
                    </summary>
                    <input type="hidden" name="accountIdAction" id="apiAccountIdAction">
                    <div class="moni_rh_567_summary_content_wrapper">
                        <div class="zap_rd_rox_action"></div>
                        <div class="moni_rh_567_summary_content_first_row_wrapper">
                            <div class="moi_rh_567_summary_content_first_row_left_content">
                                <span class="moni_rh_567_summary_content_first_row_left_content_img">
                                    <img class="AppActionLogo"
                                         style="height: 30px; width: 30px; border-radius: 0; object-fit: contain;"
                                         src="{{$app->getLogo()}}" alt="img">
                                </span>
                                <span
                                    class="moni_rh_567_summary_content_first_row_left_content_img_tag">{{\App\Logic\translate('Connect New Account')}}</span>
                            </div>
                            <div class="moi_rh_567_summary_content_first_row_right_content">
                                <button
                                    class="moi_rh_567_summary_content_first_row_right_content_sign_in_btn ghnfghfgjfghdghhhgjjgh"
                                    onclick="connectAccountAction()">{{\App\Logic\translate('Sign In')}}</button>
                            </div>
                        </div>
                        <div class="moni_rh_567_summary_description">
                            <span
                                class=""><b class="AppName">{{\App\Logic\translate($app->app->AppName)}}</b> {{\App\Logic\translate('is a secure partner with LightNit')}}. {{\App\Logic\translate('Your credentials are encrypted & can be removed at any time.')}} <a
                                    href="">{{\App\Logic\translate('You can manage all of your connected accounts here.')}}</a></span>
                        </div>
                        <div class="moni_rh_567_summary_btn_wrapper">
                            <button
                                class="moni_rh_567_summary_disbled_btn_action enable_now_action">{{\App\Logic\translate('Test App')}}</button>
                        </div>
                    </div>

                </details>


                <details class="moni_rh_567_dropdown_details_inner_details actionBlock" open="" style="display: none;">
                    <summary class="moni_rh_567_dropdown_summary_inner_summary">
                        <h3 class="moni_rh_567_dropdown_summary_inner_summary_heading"><i
                                class="fa-solid fa-angle-down"></i>{{\App\Logic\translate('App Action')}}</h3>
                        <span class="moni_rh_567_dropdown_summary_inner_summary_heading_svg_icon balmiki_action">
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C13.9778 22 15.9112 21.4135 17.5557 20.3147C19.2002 19.2159 20.4819 17.6541 21.2388 15.8268C21.9957 13.9996 22.1937 11.9889 21.8079 10.0491C21.422 8.10929 20.4696 6.32746 19.0711 4.92894C17.6725 3.53041 15.8907 2.578 13.9509 2.19215C12.0111 1.8063 10.0004 2.00433 8.17316 2.76121C6.3459 3.51809 4.78412 4.79981 3.6853 6.4443C2.58649 8.08879 2 10.0222 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C6.8043 20.9464 9.34784 22 12 22ZM8.21 10.79L11 13.59L16.29 8.29L17.71 9.71L11 16.41L6.79 12.21L8.21 10.79Z"
                                    fill="#0F884E"></path></svg>
                            <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="M12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22ZM11 7H13V13H11V7ZM12 14.75C12.69 14.75 13.25 15.31 13.25 16C13.25 16.69 12.69 17.25 12 17.25C11.31 17.25 10.75 16.69 10.75 16C10.75 15.31 11.31 14.75 12 14.75Z"
                                    fill="#DFB900"></path></svg>
                        </span>
                    </summary>

                    <div class="moni_rh_567_summary_content_wrapper">
                        <div class="moni_rh_567_summary_content_secend_row_wrapper app_action_comment">

                        </div>
                        <div class="moni_rh_567_summary_btn_wrapper moni_rh_567_other_btn_wrapper101220001220">
                            <button class="moni_rh_567_summary_btn d1f2s10ad2f1010df0d2d1d0f1sd2f1sd0f2sd5f4ds2"
                                    onclick="createZap()">{{\App\Logic\translate('Create Nit')}}</button>
                            <button class="moni_rh_567_summary_btn asdf1d154asd5f454ds4d5f4s5f45ds moni_rh_567_other_color12012450" style="display: none;"
                                    onclick="createZapConfirm()">{{\App\Logic\translate('Publish Now')}}</button>
                        </div>
                    </div>

                </details>


            </details>
        </div>
        <input type="hidden" id="actionAppIdRgx" value="{{$app->app->AppId}}">
        <input type="hidden" id="AppIdRgx" value="{{$first->app->AppId}}">
    </div>
</section>
@push('MasterScript')
<div class="app_action_comment_script"></div>
    <script>
        function changeAction() {
            $(".modal_f12").show("slow");
            setModalMode("changeActionNow");
            makeItzero();
        }

        function createZap() {
            $.ajax({
                url: '{{route('createZap')}}',
                type: 'POST',
                data: $("#action_suffer").serialize(),
                beforeSend:function(){
                    $(".d1f2s10ad2f1010df0d2d1d0f1sd2f1sd0f2sd5f4ds2").html('{{\App\Logic\translate('Checking Automation...')}}');
                },
                success: function (data) {
                    data = JSON.parse(data);
                    if(data.status === 200){
                        $(".d1f2s10ad2f1010df0d2d1d0f1sd2f1sd0f2sd5f4ds2").html('{{\App\Logic\translate('Recheck Nit')}}');
                        $(".asdf1d154asd5f454ds4d5f4s5f45ds").show();
                        $(".asdf1d154asd5f454ds4d5f4s5f45ds").html("{{\App\Logic\translate('Checkup Success ! Publish Nit Now.')}}");
                        displaySuccessToaster(data.message);
                    }else{
                        $(".d1f2s10ad2f1010df0d2d1d0f1sd2f1sd0f2sd5f4ds2").html('{{\App\Logic\translate('Recheck Nit')}}');
                        displayErrorToaster(data.message);
                    }
                },
                error:function(){
                    $(".d1f2s10ad2f1010df0d2d1d0f1sd2f1sd0f2sd5f4ds2").html('{{\App\Logic\translate('Recheck Nit')}}');

                    displayErrorToaster("{{\App\Logic\translate('Something went wrong.')}}");
                }
            });
        }

        function createZapConfirm() {
            $.ajax({
                url: '{{route('publishZap')}}',
                type: 'POST',
                data: $("#action_suffer").serialize(),
                beforeSend:function(){
                    $(".asdf1d154asd5f454ds4d5f4s5f45ds").html('{{\App\Logic\translate('Publishing Nit...')}}')
                },
                success: function (data) {
                    data = JSON.parse(data);
                    if(data.status === 200){
                        window.location = data.url;
                    }else{
                        $(".asdf1d154asd5f454ds4d5f4s5f45ds").html('{{\App\Logic\translate('Try Again')}}');
                        displayErrorToaster(data.message);
                    }
                },
                error:function(){
                    $(".asdf1d154asd5f454ds4d5f4s5f45ds").html('{{\App\Logic\translate('Try Again')}}');
                    displayErrorToaster("{{\App\Logic\translate('Something went wrong.')}}");
                }
            });
        }

        function changeActionNow(AppId) {
            $.ajax({
                url: '{{route('getApp')}}',
                type: 'POST',
                data: 'AppId=' + AppId,
                success: function (data) {
                    app = JSON.parse(data);
                    getAccountsAction(app.AppId, app.getLogo);
                    setEventAction(app.getActions);
                    setEnvironmentsAction(app);
                    $("#actionAppIdRgx").val(AppId);
                    $(".appScriptSectionAction").html(app.script);
                }
            });
            $(".modal_f12").fadeOut("slow");
        }

        function setEventAction(events) {
            let html = '';
            for (let i = 0; i < events.length; i++) {
                html += `
                <option title="` + events[i].description + `"
                                            name="` + events[i].name + `"
                                            value="` + events[i].id + `">` + events[i].name + `</option>
                `;
            }
            $("#actions").html(html);
            $("#actions").niceSelect("update");
        }

        function setEnvironmentsAction(app) {
            $(".AppActionLogo").attr('src', app.getLogo);
            $(".AppName").html(app.AppName);
            $(".AppActionName").html($("#actions").find('option:selected').attr("name"));
            $(".AppActionDescription").html($("#actions").find('option:selected').attr("title"));
        }


        let accountsAction = null;

        function goNextAction() {
            $('#action_next').slideDown();
            document.getElementById('action_next').open = true;
            scroll_to_id('#action_next', 20)
        }

        function getAccountsAction(AppId = '{{$app->app->AppId}}', logo = '{{$app->getLogo()}}', selectText = '{{\App\Logic\translate('Select')}}') {
            $.ajax({
                url: '{{route('getAccounts')}}',
                type: 'POST',
                data: 'AppId=' + AppId,
                success: function (data) {
                    accountsAction = JSON.parse(data);
                    setAccountsAction(logo, selectText);
                }
            });
        }

        function selectAccountAction(lastId) {
            $("#apiAccountIdAction").val(lastId);
            $(".connection_bajar_action").removeClass('activeHeroAccount141');
            $(".classBajar_action" + lastId).addClass('activeHeroAccount141');
            $(".connection_bajar_action").find('button.moi_rh_567_summary_content_first_row_right_content_sign_in_btn').text('{{\App\Logic\translate('select')}}');
            $(".classBajar_action" + lastId).find('button.moi_rh_567_summary_content_first_row_right_content_sign_in_btn').text('{{\App\Logic\translate('selected')}}');
        }

        function setAccountsAction(logo = '{{$app->getLogo()}}', selectText = '{{\App\Logic\translate('Select')}}') {
            if (accountsAction != null) {
                let html = '';
                let lastId = null;
                for (let i = 0; i < accountsAction.length; i++) {
                    let account = accountsAction[i];
                    lastId = account.id;
                    let data = JSON.parse(account.data);
                    let token = JSON.parse(account.token);
                    let displayName = getPersonalStatement(data);
                    html += `
<div class="connection_bajar_action classBajar_action` + account.id + `">
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
                                    class="moi_rh_567_summary_content_first_row_right_content_sign_in_btn" onclick='selectAccountAction("` + account.id + `")'>` + selectText + `</button>
                            </div>
                        </div>
</div>
                    `;

                }
                if (html !== '') {
                    html += " <div class='orConnector'>Or</div>"
                }
                $(".zap_rd_rox_action").html(html);
                selectAccountAction(lastId);
            }
        }

        $(document).ready(function () {
            getAccountsAction();

            $(".AppActionName").html($("#actions").find('option:selected').attr("name"));
            $(".AppActionDescription").html($("#actions").find('option:selected').attr("title"));

            let clanCastleAction = setInterval(() => {
                $(".balmiki_action").addClass('oisoriya');
                if ($("#apiAccountId").val() !== '') {
                    $(".moni_rh_567_summary_disbled_btn_action").addClass('enable_now_action');
                    $("#action_next .balmiki_action").addClass('oisoriya');
                    $(".moni_rh_567_dropdown_summary_apps_icon_wrapper .balmiki_action").addClass('oisoriya');
                } else {
                    $(".moni_rh_567_dropdown_summary_apps_icon_wrapper .balmiki_action").removeClass('oisoriya');
                    $("#action_next .balmiki_action").removeClass('oisoriya');
                    $(".moni_rh_567_summary_disbled_btn_action").removeClass('enable_now_action');
                }
            }, 1000);

            $(".enable_now_action").click(function () {
                let actionFireList = {
                    action_id: $("#actions").val(),
                    account_id: $("#apiAccountIdAction").val(),
                    AppId: $("#actionAppIdRgx").val()
                };
                let triggerFireList = {
                    action_id: $("#triggers").val(),
                    account_id: $("#apiAccountId").val(),
                    AppId: $("#AppIdRgx").val(),
                    Data: $('#triggerForm').serializeArray()
                };
                checkAction{{$first->app->AppId}}(triggerFireList, actionFireList);
            });
        });
    </script>
    <div class="appScriptSectionAction">
        @if($app->app->AppId !== $first->app->AppId)
            @includeIf('App.Script.'.$app->app->AppId)
        @endif
    </div>
@endpush
