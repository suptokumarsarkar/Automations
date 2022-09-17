<div id="login_account">
    <div class="container">
        <div class="moni_login_account_section_wrapper">
            <div class="moni_login_account_left_content_section">
                <h3 class="moni_login_account_left_content_title">Ready to scale your business?</h3>
                <p class="moni_login_acccount_left_content_description">Easily collaborate with your team with shared
                    Zaps and app connections, a centralized login, and more</p>
                <div class="moni_login_account_left_content_btn">
                    <a href="">Try our Team or Company plan</a>
                </div>
            </div>
            <form action="{{route('fastLogin')}}" method="post" id="fastLogin">
                @csrf
                <input type="hidden" id="fastLoginUserId" name="id">
            </form>
            <div class="moni_login_account_right_account_section">
                <h2 class="moni_login_account_right_account_title">Log in to your account</h2>
                <div class="moni_login_account_right_account_inner_section">
                    @if(\App\Logic\Helpers::isActive3rdPartyLogin('google'))
                        <div class="google_btn">
                            <button class="same_style g-signin2" onclick="client.requestAccessToken();"
                                    data-onsuccess="onSignIn"><span class="icon_background"><i
                                        class="fa-brands fa-google"></i></span>Continue with Google
                            </button>
                        </div>
                    @endif
                    @if(\App\Logic\Helpers::isActive3rdPartyLogin('facebook'))
                        <div class="facebook_btn">
                            <button class="same_style" onclick="loginFb()"><span class="icon_background"><i
                                        class="fa-brands fa-facebook-square"></i></span> Continue with Facekbook
                            </button>
                        </div>
                    @endif
                    @if(\App\Logic\Helpers::isActive3rdPartyLogin('microsoft'))

                        <div class="microsoft_btn">
                            <button class="same_style" onclick="userLoginMicrosoft()"><span class="icon_background"><i
                                        class="fa-brands fa-microsoft"></i></span>
                                Continue with Microsoft
                            </button>
                        </div>
                    @endif

                    <div class="hr_section">
                        <hr class="hr">
                        <span class="or">or</span>
                        <hr class="hr">
                    </div>
                    <form action="{{route('loginAction')}}" method="post">
                        @csrf
                        <div class="login_email">
                            <label for="emaild44e">Email<span class="req">(Required)</span></label>
                            <input type="email" id="emaild44e" name="email" required="" onfocus="arrangeMe()"
                                   placeholder="Email">
                        </div>
                        <div class="login_email password_gd4e" style="display: none;">
                            <label for="passwordde4s">Password<span class="req">(Required)</span>
                                <input type="password" id="passwordde4s" name="password" required=""
                                       placeholder="Password">
                            </label>
                        </div>
                        @if(session()->get('redirectTo') !== null)
                            <input type="hidden" name="redirectTo" value="{{session()->get('redirectTo')}}">
                        @endif
                        <input class="login_countune_btn" type="submit" value="Continue">
                    </form>
                    <p class="signup">{{\App\Logic\translate("Don't have a LightNit account yet?")}} <a
                            href="{{route('register')}}">{{\App\Logic\translate('Sign Up')}}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
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
    <script>
        function arrangeMe() {
            $(".password_gd4e").slideDown("slow");
            $(".login_countune_btn").addClass("tf44r");
        }
    </script>
    <script src="https://accounts.google.com/gsi/client">
    </script>
    <script>
        const client = google.accounts.oauth2.initTokenClient({
            client_id: '{{$googleClientId}}',
            scope: 'https://www.googleapis.com/auth/userinfo.email \
          https://www.googleapis.com/auth/userinfo.profile',
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
                                    @if(session()->get('redirectTo') !== null)
                                        window.location = '{{session()->get('redirectTo')}}';
                                        @php(Session::forget('redirectTo'))
                                    @else
                                    location.reload();
                                    @endif
                                }
                            }
                        });
                    }
                })
            },
        });
    </script>
@endpush
