<div class=" backgound_img moni_coustomer_stories_card_col">
    <div class="moni_col_inner">
        <h2 class="moni_coustomer_stories_inner_card_title">Productivity tips straight to your inbox</h2>
        <form class="moni_innr_form" method="post" action="{{route('subscribe.save')}}">
            @csrf
            <div class="moni_inner_email">
                <input class="input" type="email" name="email" placeholder="Email address" required="">
                <input type="hidden" name="type" value="blogs">
            </div>
            <div class="moni_inner_subscribe_btn">
                <button class="moni_inner_subs_btn" style="border: none">Subscribe</button>
            </div>
        </form>
    </div>
</div>
