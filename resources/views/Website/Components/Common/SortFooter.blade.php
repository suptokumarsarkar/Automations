<footer id="footer">
    <div class="container">
        <div class="footer-linkIcon-link-wrapper">
            <div class="footer-linkIcon-wrapper">
                <h2 class="footer-follow-us">Followus</h2>
                <ul class="footer-linkIcon">
                    <li><a href="{{\App\Logic\Settings::fastGet('facebookUrl')}}"><i class="fb fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="{{\App\Logic\Settings::fastGet('linkedInUrl')}}"><i class="in fa-brands fa-linkedin-in"></i></a></li>
                    <li><a href="{{\App\Logic\Settings::fastGet('googlePlusUrl')}}"><i class="wifi fa-brands fa-google-plus"></i></a></li>
                    <li><a href="{{\App\Logic\Settings::fastGet('twitterUrl')}}"><i class="twitter fa-brands fa-twitter"></i></a></li>
                    <li><a href="{{\App\Logic\Settings::fastGet('youtubeUrl')}}"><i class="youtube fa-brands fa-youtube"></i></a></li>
                </ul>
            </div>
            <ul class="footer-link-wrapper">
                <li><a href="">Pricing</a></li>
                <li><a href="">Help</a></li>
                <li><a href="">Developer Platform</a></li>
                <li><a href="">Press</a></li>
                <li><a href="">Jobs</a></li>
                <li><a href="">LightNit for Companies</a></li>
                <li><a href="">Transfer</a></li>
            </ul>
        </div>
        <div class="footer-copy-right-wrapper">
            <div class="footer-copy-right-img">
                <img src="{{\App\Logic\Settings::getLogo()}}" alt="{{\App\Logic\translate('LightNit')}}" style="width: 82px">
            </div>
            <div class="footer-copy-right-link">
                <p class="copy-right">{{\App\Logic\translate(\App\Logic\Settings::fastGet('copyrightText'))}}</p>
                <ul class="footer-copy-right-link-list">
                    <li><a href="{{route('policy.cookie')}}">{{\App\Logic\translate('Manage Cookies')}}</a></li>
                    <li class="line"><a  href="{{route('policy.termsAndConditions')}}">{{\App\Logic\translate('Terms And Conditions')}}</a></li>
                    <li><a href="{{route('policy.privacy')}}">{{\App\Logic\translate('Privacy')}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
