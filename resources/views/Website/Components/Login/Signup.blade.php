<section id="sign_up_account">
    <div class="container">
        <div class="moni_signup_wrapper">
            <div class="moni_sign_up_content">
                <h2 class="moni_sign_up_content_title">Join millions worldwide who automate their work using
                    LightNit.</h2>
                <ul class="moni_sign_up_content_list">
                    <li class="moni_up_content_list_items">
                        <i class="fa-solid fa-circle-check"></i>
                        <p>Easy setup, no coding required</p>
                    </li>
                    <li class="moni_up_content_list_items">
                        <i class="fa-solid fa-circle-check"></i>
                        <p>Free forever for core features</p>
                    </li>
                    <li class="moni_up_content_list_items">
                        <i class="fa-solid fa-circle-check"></i>
                        <p>14-day trial of premium features &amp; apps</p>
                    </li>
                </ul>
            </div>
            <div class="moni_sign_up_account">
                <div class="moni_sign_up_account_wrapper">
                    <div class="moni_sign_up_account_inner_section">
                        @if(\App\Logic\Helpers::isActive3rdPartyLogin('google'))

                            <div class="moni_same_btn google">
                                <div class="google_btn same_style g-signin2" onclick="client.requestAccessToken();"
                                     data-onsuccess="onSignIn">
                                <span class="icon_background"><i
                                        class="fa-brands fa-google"></i></span>
                                    <a href="javascript:void(0)">Sign up with Google</a>
                                </div>
                            </div>
                        @endif
                        @if(\App\Logic\Helpers::isActive3rdPartyLogin('facebook'))

                            <div class="moni_same_btn fb" onclick="loginFb()">
                                <span><i class="fa-brands fa-facebook-square"></i></span>
                                <a href="javascript:void(0)">Sign up with Facekbook</a>
                            </div>
                        @endif
                        @if(\App\Logic\Helpers::isActive3rdPartyLogin('microsoft'))

                            <div class="moni_same_btn microsoft" onclick="userLoginMicrosoft()">
                                <span><i class="fa-brands fa-microsoft"></i></span>
                                <a href="javascript:void(0)">Sign up with Microsoft</a>
                            </div>
                        @endif

                        <div class="hr_section">
                            <hr class="hr">
                            <span class="or">or</span>
                            <hr class="hr">
                        </div>
                        <form action="{{route('signupAction')}}" method="post">
                            @csrf
                            <div class="moni_email">
                                <label for="email">Work Email<span class="moni_required">(required)</span></label>
                                <input type="email" name="email" id="email" placeholder="Work Email"
                                       onfocus="arrangeMe()" required="">
                            </div>
                            <div class="moni_first_last_name">
                                <div class="moni_first_name">
                                    <label for="first_name">First Name<span
                                            class="moni_required">(required)</span></label>
                                    <input type="text" name="first_name" id="first_name" placeholder="First Name"
                                           required="">
                                </div>
                                <div class="moni_last_name">
                                    <label for="last_name">Last Name<span
                                            class="moni_required">(required)</span></label>
                                    <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                                           required="">
                                </div>
                            </div>

                            <div class="moni_email password_gd4e" style="display: none;">
                                <label for="passwordde4s">Password<span class="moni_required">(Required)</span>
                                    <input type="password" id="passwordde4s" name="password" required=""
                                           placeholder="Password">
                                </label>
                            </div>
                            <input class="moni_Get_Started_Free" type="submit" value="Get Started">
                        </form>
                        <p class="moni_sign_up_link">By signing up, you agree to LightNit's <a class="link_1" href="">
                                terms of service</a> and <a class="link_2" href="">privacy policy.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@php
    $settings = new \App\Logic\Settings;
            $googleClientId = $settings->get('googleClientId');
            $microsoftClientId = $settings->get('microsoftClientId');
            $facebookAppId = $settings->get('facebookAppId');
@endphp
@push('style')
    <meta name="google-signin-client_id"
          content="{{$googleClientId}}">
@endpush
@push('MasterScript')
    <script type="text/javascript" src="https://alcdn.msftauth.net/lib/1.2.1/js/msal.js" integrity="sha384-9TV1245fz+BaI+VvCjMYL0YDMElLBwNS84v3mY57pXNOt6xcUYch2QLImaTahcOP" crossorigin="anonymous"></script>
    <script>
        // Config object to be passed to Msal on creation
        const msalConfig = {
            auth: {
                clientId: "{{$microsoftClientId}}", // this is a fake id
                authority: "https://login.microsoftonline.com/common",
                redirectUri: "{{route('home')}}",
            },
            cache: {
                cacheLocation: "sessionStorage", // This configures where your cache will be stored
                storeAuthStateInCookie: false, // Set this to "true" if you are having issues on IE11 or Edge
            }
        };

        const myMSALObj = new Msal.UserAgentApplication(msalConfig);

        async function userLoginMicrosoft() {
            const loginRequest = {
                scopes: ["User.Read"],
            };

            myMSALObj.loginPopup(loginRequest)
                .then((loginResponse) => {

                    let profile_name = loginResponse.account.name;
                    let profile_email = loginResponse.account.userName;
                    let userId = loginResponse.account.accountIdentifier;

                    $.ajax({
                        url: '{{route('MicrosoftLogin')}}',
                        data: "userId="+userId+"&profile_name="+profile_name+"&profile_email="+profile_email,
                        type: "POST",
                        success: function (res) {
                            if (res[0].status === 200) {
                                @if(session()->get('redirectTo') !== null)
                                    window.location = '{{session()->get('redirectTo')}}';
                                @php(Session::forget('redirectTo'))
                                @else
                                location.reload();
                                @endif
                            }
                        }
                    });





                }).catch(function (error) {
                console.log(error);
            });

        }
    </script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v14.0&appId={{$facebookAppId}}&autoLogAppEvents=1" nonce="WcxKDYyW"></script>
    <script>
        function loginFb(){
            FB.login(function(response) {
                let userId = response.authResponse.userID;


                FB.api('/me', {fields: 'name,email,picture'}, function(response) {
                    console.log(response);
                    let profile_name = response.name;
                    let profile_email = response.email;
                    let profile_picture = response.picture.data.url;

                    $.ajax({
                        url: '{{route('FacebookLogin')}}',
                        data: "userId="+userId+"&profile_name="+profile_name+"&profile_email="+profile_email+"&profile_picture="+profile_picture,
                        type: "POST",
                        success: function (res) {
                            if (res[0].status === 200) {
                                @if(session()->get('redirectTo') !== null)
                                    window.location = '{{session()->get('redirectTo')}}';
                                @php(Session::forget('redirectTo'))
                                @else
                                location.reload();
                                @endif
                            }
                        }
                    });
                });






            }, {scope: 'public_profile,email'});
        }
    </script>
    <script src="https://accounts.google.com/gsi/client">
    </script>
    <script>
        function arrangeMe() {
            $(".password_gd4e").slideDown("slow");
            $(".login_countune_btn").addClass("tf44r");
        }
    </script>
    <script>
        const client = google.accounts.oauth2.initTokenClient({
            client_id: '{{$googleClientId}}',
            scope: 'https://www.googleapis.com/auth/calendar.readonly \
          https://www.googleapis.com/auth/documents.readonly \
          https://www.googleapis.com/auth/userinfo.email \
          https://www.googleapis.com/auth/userinfo.profile \
          https://www.googleapis.com/auth/photoslibrary.readonly',
            ux_mode: 'popup',
            callback: (response) => {
                $.ajax({
                    url: 'https://www.googleapis.com/oauth2/v3/userinfo?access_token=' + response.access_token,
                    success: function (data) {
                        $.ajax({
                            url: '{{route('GoogleLogin')}}',
                            data: data,
                            type: "POST",
                            success: function (res) {
                                if (res[0].status === 200) {
                                    location.reload();
                                }
                            }
                        })
                    }
                })
            },
        });
    </script>
@endpush
