<section class="red" id="subscribe_2">
    <div class="container">
        <div class="moni_subcribe_wrapper">
            <h2 class="moni_subcrcibe_title title">Get productivity tips delivered straight to your inbox</h2>
            <form class="form"  method="post" action="{{route('subscribe.save')}}">
                @csrf
                <div class="moni_subcribe_email">
                    <input type="email" name="email" placeholder="Email address" required="">
                    <input type="hidden" name="type" value="full">
                </div>
                <div class="moni_subscribe_btn">
                    <button class="moni_subs_btn" style="border: none;">Subscribe</button>
                </div>
            </form>
            <p class="moni_subcribe_under_text">We’ll email you 1-3 times per week—and never share your information.</p>
        </div>
    </div>
</section>
