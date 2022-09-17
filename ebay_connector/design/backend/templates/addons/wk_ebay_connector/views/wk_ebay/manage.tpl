{capture name="mainbox"}

<form action="{""|fn_url}" method="post" enctype="multipart/form-data" name="ebay_account_form">

{include file="common/pagination.tpl" save_current_url=true}

{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}
{assign var="c_icon" value="<i class=\"icon-`$search.sort_order_rev`\"></i>"}
{assign var="c_dummy" value="<i class=\"icon-dummy\"></i>"}
{assign var="rev" value=$smarty.request.content_id|default:"pagination_contents"}
{if $merchant_accounts}
<div class="table-responsive-wrapper">
<table class="table table-middle sortable table-responsive">
<thead>
    <tr>
        <th class="center" width="1%">{include file="common/check_items.tpl"}</th>
        <th width="5%"><a class="cm-ajax" href="{"`$c_url`&sort_by=id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("id")}{if $search.sort_by == "id"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        {if !$runtime.company_id}
        <th width="15%"><a>{if "MULTIVENDOR"|fn_allowed_for}{__("vendor")}{else}{__("store")}{/if}</a></th>
        {/if}
        <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=shop_id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>Shop Name{if $search.sort_by == "shop_id"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        <th width="15%"><a class="cm-ajax" href="{"`$c_url`&sort_by=timestamp&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("date")}{if $search.sort_by == "timestamp"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        <th width="5%">&nbsp;</th>
        <th width="10%" class="right"><a class="cm-ajax" href="{"`$c_url`&sort_by=status&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("status")}{if $search.sort_by == "status"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
    </tr>
</thead>

<tbody>
{foreach from=$merchant_accounts item="merchant_account"}
<tr class="cm-row-status-{$merchant_account.status|lower}">
    <td class="left mobile-hide" width="1%" >
        <input type="checkbox" name="ebay_merchant_ids[]" value="{$merchant_account.id}" class="checkbox cm-item" />
    </td>
    <td class="row-status" data-th='{__("id")}'>
        <a href="{"wk_ebay.update?id=`$merchant_account.id`"|fn_url}" class="nowrap row-status">{$merchant_account.id}</a>
    </td>
    {if !$runtime.company_id}
    <td class="row-status" data-th='{if "MULTIVENDOR"|fn_allowed_for}{__("vendor")}{else}{__("store")}{/if}'><a href="{"companies.update&company_id=`$merchant_account.company_id`"|fn_url}" class="nowrap row-status">{$merchant_account.company_id|fn_get_company_name}</a></td>
    {/if}
    <td class="row-status" data-th='{__("shop_name")}'>{$merchant_account.shop_name}</td>

    <td class="row-status" data-th='{__("date")}'>{$merchant_account.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</td>
    <td class="nowrap" data-th='{__("tools")}'>
        <div class="hidden-tools">
            {capture name="tools_list"}
                <li>{btn type="list" text=__("edit_account") href="wk_ebay.update?id=`$merchant_account.id`"}</li>
                <li>{btn type="list" class="cm-confirm" text=__("delete_account") href="wk_ebay.delete?id=`$merchant_account.id`" method="POST"}</li>
                <li>{btn type="list" text=__("manage_ebay_products") href="wk_ebay_product.manage?account_id=`$merchant_account.id`"}</li>
                <li>{btn type="list" text=__("manage_ebay_orders") href="wk_ebay.order_manage?account_id=`$merchant_account.id`"}</li>
                <li>{btn type="list" text=__("import_ebay_orders") href="wk_ebay.list_orders?account_id=`$merchant_account.id`"}</li>
                <li>{btn type="list" text=__("manage_category_mapping") href="wk_ebay.category_map&account_id=`$merchant_account.id`"}</li>
            {/capture}
            {dropdown content=$smarty.capture.tools_list}
        </div>
    </td>
    <td class="right nowrap" data-th='{__("status")}'>
        {include file="common/select_popup.tpl" id=$merchant_account.id status=$merchant_account.status|default:'A' hidden="" object_id_name="id" table="wk_ebay_account_list" popup_additional_class="cm-no-hide-input"}
    </td>
</tr>
{/foreach}
</tbody>
</table>
</div>
{else}
    <p class="no-items">{__("no_data")}</p>
{/if}

{include file="common/pagination.tpl"}

{capture name="buttons"}
    {capture name="tools_list"}
        {if $merchant_accounts}
            <li>{btn type="delete_selected" dispatch="dispatch[wk_ebay.m_delete]" form="ebay_account_form"}</li>
        {/if}
    {/capture}
    {dropdown content=$smarty.capture.tools_list}
{/capture}

{capture name="adv_buttons"}

    {include file="common/tools.tpl" tool_href="wk_ebay.add" prefix="top" hide_tools=true link_text="<span style='color:white'>Connect eBay Account</span>" title="Connect eBay Account"}
{/capture}

{capture name="sidebar"}
    {include file="addons/wk_ebay_connector/views/wk_ebay/components/search_form.tpl" dispatch="wk_ebay.manage"}
{/capture}

</form>

{/capture}
{include file="common/mainbox.tpl" title=__("manage_ebay_accounts") content=$smarty.capture.mainbox title_extra=$smarty.capture.title_extra tools=$smarty.capture.tools sidebar=$smarty.capture.sidebar adv_buttons=$smarty.capture.adv_buttons buttons=$smarty.capture.buttons}
