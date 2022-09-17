<section id="pricing_plan_card_section">
    <div class="container">
        <div class="moni_pricing_plan_card_row" style="justify-content: center;">


            @foreach($plans as $plan)
                <div class="moni_pricing_plan_card_col">
                    <div class="moni_pricing_plan_card_one">

                        <div class="moni_pricing_plan_card_wrapper">
                            <div class="moni_pricing_plan_usd">
                                <div class="moni_dollor_sign">
                                    <span class="moni_dollor">$</span>
                                </div>
                                <div class="moni_0_sign">
                                    <span>{{$plan->price}}</span>
                                </div>
                                <div class="moni_usd_sign">
                                    <span class="moni_usd">USD</span>
                                </div>
                            </div>
                            <div class="moni_free_forever">
                                <p class="moni_free">{{$plan->type == 'Free' ? 'free forever' : 'per month'}}</p>
                            </div>
                            <div class="moni_line"></div>
                            <div class="moni_card_title">
                                <h3 class="card_title">{{$plan->name}}</h3>
                            </div>
                            <div class="moni_description_text">
                                <p class="description_text">{{$plan->description}}</p>
                            </div>
                            <div class="moni_btn">
                                <p href="">{{$plan->taskPerMonth}} tasks /mo</p>
                            </div>
                            <div class="moni_try_free_btn">
                                <a class="try_free_btn"
                                   href="{{route('plans.index', [$plan->id, $plan->name])}}">{{$plan->type == 'Free' ? 'Try Free' : 'Get It Now'}}</a>
                            </div>
                        </div>

                    </div>
                    <div class="moni_features_plan_card_two">
                        <div class="moni_features_title">
                            <h3 class="features_title">{{$plan->name}} plan features</h3>
                        </div>
                        <div class="moni_features_number">
                            <div class="features_number_icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div class="features_number_text tooltip_hover">
                                <p class="number_text">{{$plan->maxConnections}} Zaps</p>
                                <span class="tooltip">Zaps connect your apps and services together to automate repetitive tasks and save you time.</span>
                            </div>
                        </div>
                        <div class="moni_features_Unlimited ">
                            <div class="features_unlimeted_icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div class="features_unlimited_time tooltip_hover">
                                <p class="unlimited_time">{{$plan->taskTime}} min update time</p>
                                <span class="tooltip">How often LightNit checks for new data to start your Zap.</span>
                            </div>
                        </div>
                        <div class="moni_features_line">
                            <span class="features_line"></span>
                        </div>
                        <div class="moni_line lines"></div>
                        <ul class="moni_features_list">
                            @if($plan->multiZaps == null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <p>Single-step Zaps</p>
                                    <span class="tooltip">Single-step Zaps have one Trigger (e.g. new email lead) and one Action (e.g. add to my CRM).</span>
                                </div>
                            </li>
                            @else
                                <li class="moni_features_list_item">
                                    <div class="list_item_icon">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="list_item_text tooltip_hover">
                                        <p>Multi-step Zaps</p>
                                        <span class="tooltip">Multi-step Zaps let a single Trigger (e.g. new email lead) perform as many Actions (e.g. add to my CRM) as you want.</span>
                                    </div>
                                </li>
                            @endif
                            @if($plan->transferBeta != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Transfer (beta)</span>
                                    <span class="tooltip">Transfer lets you move data in bulk from one app to another.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->premiumApps != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Premium Apps</span>
                                    <span class="tooltip">Premium apps are select apps that are exclusively available to users on a paid plans.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->webHooks != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Connections via Webhooks</span>
                                    <span class="tooltip">Build powerful, custom integrations that connect any app with Webhooks by Zapier.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->logics != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Custom logic - paths</span>
                                    <span class="tooltip">Build advanced workflows using branching logic to run different actions based on conditions you decide.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->autoReply != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Auto Reply</span>
                                    <span class="tooltip">Intelligently retries any Task failures due to temporary errors or downtime for you.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->premiumSupport != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Premium Support</span>
                                    <span class="tooltip">Get faster, prioritized responses from our dedicated Premier Support team.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->sharedAppConnection != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Shared App Connection</span>
                                    <span class="tooltip">Connect your team’s favorite tools, like Trello, Dropbox, or Typeform, so everyone can use them in their workflows without needing to share passwords and API keys.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->sharedAccountConnection != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Shared Account Connection</span>
                                    <span class="tooltip">Connect your team’s favorite tools, like Trello, Dropbox, or Typeform, so everyone can use them in their workflows without needing to share passwords and API keys.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->folderPermission != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Folder Permission</span>
                                    <span class="tooltip">Control who can edit shared Zaps and access shared folders.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->formatters != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Formatters</span>
                                    <span class="tooltip">Formatters let you tweak numbers, dates, and text in over a dozen ways to get it in the format you need.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->filters != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Filters</span>
                                    <span class="tooltip">Filters tell your Zaps to run only if your data matches certain criteria.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->advancedAdminPermission != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Advanced Admin Permission</span>
                                    <span class="tooltip">Add unlimited teams to your account for managing workspace-level permissions.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->appsRestrictions != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Apps Restrictions</span>
                                    <span class="tooltip">Manage which apps and services employees can connect to your Zapier account.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->customDataRetention != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>Custom Data Retention</span>
                                    <span class="tooltip">Customize your Task history retention to match your company's legal and regulatory requirements.</span>
                                </div>
                            </li>
                            @endif
                            @if($plan->userProvisioning != null)
                            <li class="moni_features_list_item">
                                <div class="list_item_icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="list_item_text tooltip_hover">
                                    <span>User Provisioning</span>
                                    <span class="tooltip">Automatically create, change, disable, and delete user accounts to ensure the right people have access.</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endforeach

        </div>
        <hr class="features_hr">
    </div>
</section>
