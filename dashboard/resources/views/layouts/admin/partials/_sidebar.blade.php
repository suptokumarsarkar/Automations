<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container text-capitalize">
            <div class="navbar-vertical-footer-offset">
                <div class="navbar-brand-wrapper justify-content-between">
                    <!-- Logo -->

                    @php($logo=\App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value)
                    <a class="navbar-brand" href="{{route('admin.dashboard')}}" aria-label="Front">
                        <img class="navbar-brand-logo"
                             onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.png')}}'"
                             src="{{asset('storage/app/public/logo/'.$logo)}}"
                             alt="Logo">
                        <img class="navbar-brand-logo-mini"
                             onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.png')}}'"
                             src="{{asset('storage/app/public/logo/'.$logo)}}" alt="Logo">
                    </a>

                    <!-- End Logo -->

                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                            class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.dashboard')}}" title="Dashboards">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('dashboard')}}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <small
                                class="nav-subtitle">{{\App\CentralLogics\translate('All Settings')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/website*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-category nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CentralLogics\translate('Website Settings')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/website*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/website/posts/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.addPost')}}"
                                       title="add new category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('Add Post')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/website/posts')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.allPosts')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('View Posts')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/website/category/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.addCategory')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('Add Category')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/website/category')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.allCategory')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('All Categories')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/category/add-sub-category')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('Languages')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/website/terms-and-conditions')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.termsAndConditions')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('Terms And Conditions')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/website/privacy-policy')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.privacyPolicy')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('Privacy Policy')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/website/cookie-policy')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.cookiePolicy')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('Cookie Policy')}}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/payment-settings')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.paymentSettings')}}" title="Payment Gateway">
                                <i class="tio-credit-card nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('Payment Gateway')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/apps*')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.appsList')}}" title="Apps Manager">
                                <i class="tio-appstore nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('Apps Manager')}}
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/pricing*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-dollar nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CentralLogics\translate('Pricing Management')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/pricing*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/pricing/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.pricingAdd')}}"
                                       title="add new category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('Add Offer')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/pricing/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.pricingList')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('View Offers')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/users*')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-user nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CentralLogics\translate('Users')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/users*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/users/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.userAdd')}}"
                                       title="add new category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('Add User')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/users/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.userList')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('View Users')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/admin*')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-user nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CentralLogics\translate('Admins')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/admin*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/admin/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.adminAdd')}}"
                                       title="Add New Admin To Manage The Dashboard">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('Add Admins')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/admin/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.adminList')}}"
                                       title="All Admins Who Has Access Or Not Accessed.">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('View Admins')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/subscribers*')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-subscribe nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CentralLogics\translate('Subscribers')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/subscribers*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/subscribers/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.subscriberAdd')}}"
                                       title="add new category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('Add Subscriber')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/subscribers/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.subscriberList')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('View Subscribers')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/seo*')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-sync nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CentralLogics\translate('Seo')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/seo*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/seo/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.seoAdd')}}"
                                       title="add new category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('Add Page')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/seo/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.seoList')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('View Page')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/login-setup')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.loginSetup')}}" title="Login Setup, 3rd Party Management">
                                <i class="tio-sign-in nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('Login Setup')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/general-settings')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.generalSettings')}}" title="General Settings">
                                <i class="tio-settings nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('General Settings')}}
                                </span>
                            </a>
                        </li>

                        <!-- End Dashboards -->
                        {{--
                        <li class="nav-item">
                            <small
                                class="nav-subtitle">{{\App\CentralLogics\translate('Movies')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        &lt;!&ndash; Pages &ndash;&gt;
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/movie/add-movie')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.movie.addMovie')}}"
                            >
                                <i class="tio-apps nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('Add Movie')}}
                                </span>
                            </a>
                        </li>
                        &lt;!&ndash; End Pages &ndash;&gt;
                         &lt;!&ndash; Pages &ndash;&gt;
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/movie/*') && !Request::is('admin/movie/add-movie')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.movie.list')}}"
                            >
                                <i class="tio-apps nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('All Movie')}}
                                </span>
                            </a>
                        </li>
                        &lt;!&ndash; End Pages &ndash;&gt;

                        &lt;!&ndash; Pages &ndash;&gt;
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.business-settings.setup')}}"
                            >
                                <i class="tio-apps nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('App Settings')}}
                                </span>
                            </a>
                        </li>
                        &lt;!&ndash; End Pages &ndash;&gt;


                        &lt;!&ndash; Pages &ndash;&gt;
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/category*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-category nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CentralLogics\translate('category')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/category*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/category/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add')}}"
                                       title="add new category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('category')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/category/add-sub-category')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add-sub-category')}}"
                                       title="add new sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('sub_category')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/category/add-sub-sub-category')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add-sub-sub-category')}}"
                                       title="add new sub sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">Sub-Sub-Category</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        <!-- End Pages -->


                        <li class="nav-item" style="padding-top: 100px">
                            <div class="nav-divider"></div>
                        </li>
                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>


{{--<script>
    $(document).ready(function () {
        $('.navbar-vertical-content').animate({
            scrollTop: $('#scroll-here').offset().top
        }, 'slow');
    });
</script>--}}
