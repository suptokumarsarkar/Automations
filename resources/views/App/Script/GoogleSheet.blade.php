<script>
    function getPersonalStatement(data) {
        return "<h6>" + data.name + "</h6><i style='font-size: 12px'>" + data.email + "</i>";
    }

    let yx = 0;

    function connectAccount() {
        client.requestCode();
        yx = 0;
    }

    function connectAccountAction() {
        client.requestCode();
        yx = 1;
    }

    function checkTrigger(trigger, accountId, AppId = "GoogleSheet") {
        $.ajax({
            url: '{{route('checkTrigger')}}',
            type: 'POST',
            data: 'trigger=' + trigger + "&accountId=" + accountId + "&AppId=" + AppId,
            beforeSend: function () {
                $(".moni_rh_567_summary_disbled_btn").html('{{\App\Logic\translate('Checking Trigger...')}}');
            },
            success: function (data) {
                $(".moni_rh_567_summary_disbled_btn").html('{{\App\Logic\translate('Rerun Trigger')}}');
                console.log(data);
                if (data.status === 200) {
                    displaySuccessToaster(data.message);
                    $(".triggerBlock").attr("open", true);
                    $(".triggerBlock").slideDown("slow");
                    $(".app_trigger_comment").html(data.data.view.view);
                    $(".app_trigger_comment").append(data.data.view.script);
                    scroll_to_id('.triggerBlock', 20)
                } else {
                    displayErrorToaster(data.message);
                }
            },
            error: function () {
                $(".moni_rh_567_summary_disbled_btn").html('{{\App\Logic\translate('Rerun Trigger')}}');
                displayErrorToaster('{{\App\Logic\translate('Something went wrong')}}');
            }
        });
    }


    function checkActionGoogleSheet(trigger, action) {
        let data = {
            trigger: trigger,
            action: action
        }
        $.ajax({
            url: '{{route('getActionForm')}}',
            type: 'POST',
            data: $.param(data),
            beforeSend: function () {
                $(".enable_now_action").html('{{\App\Logic\translate('Creating Action Manager...')}}');
            },
            success: function (data) {
                $(".enable_now_action").html('{{\App\Logic\translate('Change Action Manager')}}');
                if (data.status === 200) {
                    displaySuccessToaster(data.message);
                    $(".actionBlock").attr("open", true);
                    $(".actionBlock").show("slow");
                    $(".app_action_comment").html(data.view);
                    $(".app_action_comment_script").html(data.script);
                    scroll_to_id('.actionBlock', 20)
                } else {
                    displayErrorToaster(data.message);
                }
            },
            error: function () {
                $(".enable_now_action").html('{{\App\Logic\translate('Run Action Manager')}}');
                displayErrorToaster('{{\App\Logic\translate('Something went wrong')}}');
            }
        });
    }


</script>
@php
    $settings = new \App\Logic\Settings;
    $googleClientId = $settings->get('googleClientId');
@endphp
<script src="https://accounts.google.com/gsi/client">
</script>
<script>
    const client = google.accounts.oauth2.initCodeClient({
        client_id: '{{$googleClientId}}',
        scope: 'https://www.googleapis.com/auth/userinfo.email \
          https://www.googleapis.com/auth/userinfo.profile\
          https://www.googleapis.com/auth/drive.file\
          https://www.googleapis.com/auth/drive\
          https://www.googleapis.com/auth/spreadsheets\
             ',
        ux_mode: 'popup',
        callback: (response) => {
            response.type = 'GoogleSheet';
            $.ajax({
                url: '{{route('googleToken')}}',
                type: 'post',
                data: response,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status === 200) {
                        displaySuccessToaster(data.message);
                        if (yx) {
                            getAccountsAction();
                        } else {
                            getAccounts();
                        }
                    } else {
                        displayErrorToaster(data.message);
                    }
                }
            })
        },
    });
</script>
