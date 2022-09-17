
<section id="coustomer_stories_card">
    <div class="container">
        <div class="moni_coustomer_stories_card_row">

            @foreach($posts as $key => $post)
                @if($key == 4) @include('Website.Components.Blogs.BlogPostsWithSubscribe') @endif

                <div class="moni_coustomer_stories_card_col">
                    <div class="moni_coustomer_stories_card_img">
                        <a href="{{$post->getURI()}}"><img class="card_img"
                                                           src="{{$post->getThumbnail()}}"
                                                           alt="img"></a>
                    </div>
                    <div class="moni_coustomer_stories_content">
                        {{--                        <a class="moni_small_title" href=""><p>Small business tips</p></a>--}}
                        <a href="{{$post->getURI()}}">
                            <p class="moni_type_of_title">{{$post->title}}</p>
                            <p class="moni_type_of_description">{{$post->sortDescription}}</p>
                        </a>
                        <div class="moni_read">
                            <a href="{{$post->getURI()}}"><p class="moni_same_style">{{$post->author()->f_name}} {{$post->author()->l_name}}</p></a>
                            <a href="{{$post->getURI()}}"><p class="moni_same_style bold">.</p></a>
                            <a href="{{$post->getURI()}}"><p class="moni_same_style">{{$post->postTime()}}</p></a>
                        </div>
                    </div>
                </div>

            @endforeach


        </div>
        @if($showall)
            <div class="moni_See_all_articles_btn">
                <a class="moni_see_all_btn" href="">See all articles</a>
            </div>
        @endif
    </div>
</section>
