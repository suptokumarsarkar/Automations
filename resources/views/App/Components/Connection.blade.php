<section id="main">
    <div class="moni_main_wrapper">
        Connect With Google:

        <div class="google_btn">
            <button class="same_style g-signin2" onclick="client.requestCode();"
                    data-onsuccess="onSignIn"><span class="icon_background"><i
                        class="fa-brands fa-google"></i></span>Continue with Google
            </button>
        </div>
    </div>
</section>

@php
    $settings = new \App\Logic\Settings;
            $googleClientId = $settings->get('googleClientId');
            $facebookAppId = $settings->get('facebookAppId');
            $microsoftClientId = $settings->get('microsoftClientId');
@endphp
@push('style')
    <meta name="google-signin-client_id"
          content="{{$googleClientId}}">
@endpush
@push("MasterScript")
    <script src="https://accounts.google.com/gsi/client">
    </script>
    <script>
        const client = google.accounts.oauth2.initCodeClient({
            client_id: '{{$googleClientId}}',
            scope: 'https://mail.google.com/ \
            https://www.googleapis.com/auth/gmail.modify\
            https://www.googleapis.com/auth/gmail.readonly\
            https://www.googleapis.com/auth/gmail.labels\
            https://www.googleapis.com/auth/gmail.metadata',
            ux_mode: 'popup',
            callback: (response) => {
                response.type = "Gmail";
                $.ajax({
                    url: '{{route('googleToken')}}',
                    type: "post",
                    data: response,
                    success: function (res) {
                        console.log(res);
                    }
                });
            },
        });
    </script>
@endpush
