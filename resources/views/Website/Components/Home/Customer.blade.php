
<!-- customer start -->
<section id="customer_part">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="customer_lft">
                    <h2>From what if to what’s next</h2>
                    <p>LightNit users automate their way to awesome every day. But don’t take our word for it!</p>
                    <a href="#">Meet our customer</a>
                </div>
            </div>
            <div class="col-lg-8">
                @php
                    $posts = \App\Models\StoryPost::where("tags", 'like', '%home%')->take(4)->get();
                @endphp
                <div class="row">
                    @foreach($posts as $key=>$post)
                    <div class="col-md-6">
                        <a href="{{$post->getURI()}}">
                        <div class="customer_right rosndafd4d">
                            <div class="right_img">
                                <img src="{{$post->getThumbnail()}}" class="img-fluid" alt="customer image">
                                <div class="pos_img">
                                    <img src="{{asset('public/images/cus-min'.($key+1).'.jpg')}}" class="img-fluid" alt="min image">
                                </div>
                            </div>
                            <div class="right_txt">
                                <p>{{$post->sortDescription}}</p>
                                <p class="right_p">{{$post->author()->f_name}}</p>
                            </div>
                        </div>
                        </a>
                    </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@push('headerScript')
<style>
    .rosndafd4d p{
        color: #292929;
    }
</style>
@endpush
<!-- customer end -->
