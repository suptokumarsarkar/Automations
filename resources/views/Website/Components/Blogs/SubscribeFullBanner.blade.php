<section id="subscribe">
    <div class="container">
        <div class="moni_subcribe_wrapper">
            <h2 class="moni_subcrcibe_title">Get productivity tips delivered straight to your inbox</h2>
            <form class="form"   method="post" action="{{route('subscribe.save')}}">
                @csrf
                <div class="moni_subcribe_email">
                    <input type="email" name="email" placeholder="Email address" required="">
                    <input type="hidden" name="type" value="full">

                </div>
                <div class="moni_subscribe_btn">
                    <button class="moni_subs_btn" style="border: none;">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</section>
