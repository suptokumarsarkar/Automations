{capture name="mainbox"}

    {capture name="tabsbox"}
        {if $merchant_data.id}
            {$id = $merchant_data.id}
        {else}
            {$id = 0}
        {/if}
        <form id='form' action="{""|fn_url}" method="post" name="add_ebay_account_form" class="form-horizontal form-edit cm-disable-empty-files" enctype="multipart/form-data" id="add_ebay_account_form">
            <div class="account-manage" id="content_ebay_general">
                <input type="hidden" name="id" id="elm_company_exists_store" value="{$merchant_data.id}" />
                {include file="common/subheader.tpl" title=__("ebay_shop_details")}
                {if ("ULTIMATE"|fn_allowed_for || "MULTIVENDOR"|fn_allowed_for) && !$runtime.company_id}
                    {if $merchant_data.id}
                        <div class="control-group">
                            <label class="control-label cm-required" for="elm_company_exists_store">
                                {if "ULTIMATE"|fn_allowed_for}
                                    {__("store")}:
                                {else}
                                    {__("vendor")}:
                                {/if}
                            </label>
                            <div class="controls">
                                <p><a href='{"companies.update?company_id=`$merchant_data.company_id`"|fn_url}'>{$merchant_data.company_id|fn_get_company_name}</a></p>
                            </div>
                        </div>
                    {else}
                        {* {if "ULTIMATE"|fn_allowed_for}
                            {assign var="companies_tooltip" value=__("text_ult_product_store_field_tooltip")}
                        {/if} *}
                        {include file="views/companies/components/company_field.tpl"
                        name="merchant_data[company_id]"
                        id="merchant_data_company_id"
                        selected=$merchant_data.company_id
                        tooltip=$companies_tooltip
                        }
                    {/if}
                {/if}
                <div class="control-group {if $id}cm-hide-inputs{/if}" style="display: none">
                    <label for="elm_ebay_dev_id" class="control-label cm-required cm-trim">{__("wk_ebay.ebay_dev_id")}{include file="common/tooltip.tpl" tooltip={__("wk_ebay.ebay_dev_id_help")}}:</label>
                    <div class="controls">
                        <input type="text" class="" name="merchant_data[ebay_dev_id]" id="elm_ebay_dev_id" value="{$merchant_data.ebay_dev_id}" >
                    </div>
                </div>
                <div class="control-group {if $id}cm-hide-inputs{/if}" style="display: none">
                    <label for="elm_ebay_app_id" class="control-label cm-required cm-trim">{__("wk_ebay.app_id")}{include file="common/tooltip.tpl" tooltip={__("wk_ebay.app_id")}}:</label>
                    <div class="controls">
                        <input type="text" class="" name="merchant_data[app_id]" id="elm_ebay_app_id" value="{$merchant_data.app_id}" >
                    </div>
                </div>
                <div class="control-group {if $id}cm-hide-inputs{/if}" style="display: none">
                    <label for="elm_cert_id" class="control-label cm-required cm-trim">{__("wk_ebay.cert_id")}{include file="common/tooltip.tpl" tooltip={__("wk_ebay.cert_id_help")}}:</label>
                    <div class="controls">
                        <input type="text" class="" name="merchant_data[cert_id]" id="elm_cert_id" value="{$merchant_data.cert_id}" >
                    </div>
                </div>
                <div class="control-group " style="display: none">
                    <label for="elm_oauth_token" class="control-label cm-required cm-trim">{__("wk_ebay.oauth_tokens")}{include file="common/tooltip.tpl" tooltip={__("wk_ebay.oauth_token_help")}}:</label>
                    <div class="controls">
                        <textarea class="input-large" rows="5" cols="29" name="merchant_data[oauth_token]" id="elm_oauth_token" {if $id}disabled {/if}>{$merchant_data.oauth_token} </textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label for="elm_shop_name" class="control-label cm-required cm-trim">{__("wk_ebay.shop_name")}{include file="common/tooltip.tpl" tooltip={__("wk_ebay.shop_name_help")}}:</label>
                    <div class="controls">
                        <input type="text" class="" name="merchant_data[shop_name]" id="elm_shop_name" value="{$merchant_data.shop_name}" >
                    </div>
                </div>
                <div class="control-group" style="display: none">
                    <label for="elm_mode" class="control-label cm-required cm-trim">{__("wk_ebay.mode")}{include file="common/tooltip.tpl" tooltip={__("wk_ebay.mode")}}:</label>
                    <div class="controls">
                        <select  name="merchant_data[mode]" id="elm_mode">
                            <option value="S" {if $merchant_data.mode == "S"}selected="selected"{/if}>{__("sandbox")}</option>
                            <option value="P" {if $merchant_data.mode == "P"}selected="selected"{/if}>{__("production")}</option>
                        </select>
                    </div>
                </div>
            </div>
            {if $id}
                <div class="control-group hidden" id="content_product_settings">
                    {if $merchant_data.default_cscart_category_id}
                        {assign var="request_category_id" value=","|explode:$merchant_data.default_cscart_category_id}
                    {else}
                        {assign var="request_category_id" value=""}
                    {/if}
                    {math equation="rand()" assign="rnd"}
                    <label for="ccategories_{$rnd}_ids" class="control-label cm-required">Default CScart Category{include file="common/tooltip.tpl" tooltip={"Default CScart Category"}}:</label>
                    <div class="controls">
                        {include file="pickers/categories/picker.tpl"
                        company_ids=$merchant_data.company_id
                        rnd=$rnd
                        data_id="categories"
                        input_name="merchant_data[default_cscart_category_id]"
                        main_category=$merchant_data.default_cscart_category_id
                        item_ids=$request_category_id
                        hide_link=true
                        hide_delete_button=true
                        display_input_id="category_ids"
                        disable_no_item_text=true
                        but_meta="btn"
                        show_active_path=true}
                    </div>
                    <br>
                    <div class="control-group">
                        <label for="default_ebay_currency" class="control-label cm-trim cm-required">Ebay Currency Help{include file="common/tooltip.tpl" tooltip={"Ebay Currency Help"}}:</label>
                        <div class="controls">
                            <select id="default_ebay_currency" name="merchant_data[currency_code]">
                                <option value="0">{__("select")}</option>
                                {if $currencies}
                                    {foreach from = $currencies item=currency}
                                        <option value="{$currency.currency_code}" {if $merchant_data.currency_code == $currency.currency_code}selected{/if}>{$currency.currency_code}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>
                    </div>
                    <!--content_product_settings--></div>
                <div class="control-group hidden" id="content_order_settings">
                    {assign var="statuses" value=$smarty.const.STATUSES_ORDER|fn_get_simple_statuses}
                    <div class="control-group hidden">
                        <label for="ebay_order_status" class="control-label cm-trim">{__("ebay_order_status")}{include file="common/tooltip.tpl" tooltip={__("ebay_order_help")}}:</label>
                        <div class="controls">
                            <select id="default_ebay_order_status" name="merchant_data[status]">
                                <option value="0">{__("select")}</option>
                                {if $statuses}
                                    {foreach from=$statuses item="s" key="k"}
                                        <option value="{$k}" {if $merchant_data.status == $k}selected="selected"{/if}>{$s}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="default_payment_processor" class="control-label cm-trim cm-required">Payment Processor Help{include file="common/tooltip.tpl" tooltip={"Payment Processor Help"}}:</label>
                        <div class="controls">
                            <select id="default_payment_processor" name="merchant_data[default_payment]">
                                <option value="">{__("select")}</option>
                                {if $payment_arr}
                                    {foreach from=$payment_arr item="s" key="k"}
                                        <option value="{$s.payment_id}" {if $merchant_data.default_payment == $s.payment_id}selected="selected"{/if}>{$s.payment}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="default_shipping_method" class="control-label cm-trim cm-required">{__("shipping_method")}{include file="common/tooltip.tpl" tooltip={__("shipping_method_help")}}:</label>
                        <div class="controls">
                            <select id="default_shipping_method" name="merchant_data[default_shipping]">
                                <option value="">{__("select")}</option>
                                {if $shipping_arr}
                                    {foreach from=$shipping_arr item="s" key="k"}
                                        <option value="{$k}" {if $merchant_data.default_shipping == $k}selected="selected"{/if}>{$s}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>
                    </div>
                    <!--content_order_settings--></div>
            {/if}

        </form>
    {/capture}
    {include file="common/tabsbox.tpl" content=$smarty.capture.tabsbox active_tab=$smarty.request.selected_section track=true}

    {capture name="buttons"}
        {if $id}
            {include file="buttons/save_cancel.tpl" but_name="dispatch[wk_ebay.update]" but_target_form="add_ebay_account_form" hide_second_button=false save=$id}
        {else}
            {include file="buttons/save_cancel.tpl" but_name="dispatch[wk_ebay.authenticate]" but_target_form="add_ebay_account_form" hide_second_button=true but_text=__("ebay_authenticate")}
        {/if}
    {/capture}
    {capture name="sidebar"}
        {if $id}
            {* {include file="addons/wk_ebay_connector/common/components/tab.tpl"} *}
        {/if}
    {/capture}
{/capture}
{$but_text=__("add_ebay_merchant")}
{if $id}
    {$but_text=__("edit_ebay_merchant")}
{/if}
{include file="common/mainbox.tpl" title=$but_text content=$smarty.capture.mainbox sidebar=$smarty.capture.sidebar buttons=$smarty.capture.buttons}
{*<div class="account-manage hidden"  id="content_ebay_crons" class="hidden">
<!--content_ebay_crons--></div>*}



