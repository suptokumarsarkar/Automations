{capture name="mainbox"}
{capture name="currencies"}
{/capture}
<form action="{""|fn_url}" method="post" enctype="multipart/form-data" class="" name="ebay_manage_products_form">
<input type="hidden" class="cm-no-hide-input" name="fake" value="1" />
{include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id}
<input type="hidden" class="cm-no-hide-input" value="{$account_id}" name="account_id"/>
{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}
{assign var="c_icon" value="<i class=\"icon-`$search.sort_order_rev`\"></i>"}
{assign var="c_dummy" value="<i class=\"icon-dummy\"></i>"}
{assign var="rev" value=$smarty.request.content_id|default:"pagination_contents"}

{if $product_list}
<div class="table-responsive-wrapper">
<table class="table table-middle sortable table-responsive">
<thead>
    <tr>
        {* <th class="center" width="1%">{include file="common/check_items.tpl"}</th> *}
        <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=product_id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("product_id")}{if $search.sort_by == "product_id"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=listing_id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("listing_id")}{if $search.sort_by == "listing_id"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        <th width="20%"><a class="cm-ajax" href="{"`$c_url`&sort_by=product&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("product_name")}{if $search.sort_by == "product"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        {* <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=price&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("price")}({$currencies.$secondary_currency.symbol}){if $search.sort_by == "price"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=quantity&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("quantity")}{if $search.sort_by == "quantity"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th> *}
        {* <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=action&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("action")}{if $search.sort_by == "action"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th> *}
        {* <th width="5%">&nbsp;</th> *}
        <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=state&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("status")}{if $search.sort_by == "state"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
    </tr>
</thead>
<tbody>
{foreach from=$product_list item="product_data"}

<tr class="cm-row-status-{$product_data.status|lower}" id="{$product_data.listing_id}">
    {* <td class="left mobile-hide" width="1%">
        <input type="checkbox" name="map_ids[]" value="{$product_data.id}" class="checkbox cm-item"/>
    </td> *}
    <td data-th='{__("product_id")}'> 
       <a href="{"products.update&product_id=`$product_data.product_id`"|fn_url}"> {$product_data.product_id}</a>
    </td>
    <td data-th='{__("listing_id")}'>{$product_data.listing_id}</td>
    <td class="row-status" data-th='{__("product_name")}'> <a href="{"products.update&product_id=`$product_data.product_id`"|fn_url}">{$product_data.product}</a></td>
    {* <td class="row-status" data-th='{__("price")}'>{$product_data.price|fn_format_price_by_currency}</td>
    <td class="row-status" data-th='{__("quantity")}'>{$product_data.amount}</td> *}

    {* <td class="row-status" data-th='{__("action")}'>{if $product_data.action == 'I'}{__("import")}{else}{__("export")}{/if}{if $product_data.map == 'N'}
        ({__("not_mapped")})
        {/if}
    </td> *}

    {* <td class="nowrap" data-th='{__("tools")}'>
        <div class="hidden-tools">
            {capture name="tools_list"}
                <li>
                    {$map_text = __("delete_mapping")} 
                    {if $product_data.map == 'N'}
                        {$map_text = __("product_mapping")}
                    {/if}
                    <li>{btn type="list"  text=$map_text href="wk_ebay_product.map_sync?product_id=`$product_data.product_id`&account_id={$account_id}" method="POST"}</li>
                </li>
                <li>{btn type="list" class="cm-confirm" text=__("delete") href="wk_ebay_product.delete?account_id=`$account_id`&product_id=`$product_data.product_id`" method="POST"}</li>
            {/capture}
            {dropdown content=$smarty.capture.tools_list}
        </div>
    </td> *}
    
    <td class="row-status" data-th='{__("status")}'>{$product_data.state}</td>
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
    {* {capture name="tools_list"}
        {if $product_list}
            <li>{btn type="delete_selected" class="cm-confirm" dispatch="dispatch[wk_ebay_product.m_delete]" form="ebay_manage_products_form"}</li>
            <li>{btn type="list" dispatch="dispatch[wk_ebay_product.m_map_sync]" text=__("update_product_synchronization") form="ebay_manage_products_form"}</li>
        {/if}
    {/capture} *}
    {include file="buttons/save_cancel.tpl" but_name="dispatch[wk_ebay_product.import_products]" but_title=__("import_products_from_ebay") but_text=__("import_product") but_target_form="ebay_manage_products_form" but_meta="btn btn-primary" but_id="import_product_btn"}
    
{/capture}

{capture name="sidebar"}
    {include file="addons/wk_ebay_connector/views/wk_ebay_product/components/search_form.tpl" dispatch="wk_ebay_product.manage"}
{/capture}

</form>

{/capture}

{include file="common/mainbox.tpl" title=__("manage_ebay_products") content=$smarty.capture.mainbox title_extra=$smarty.capture.title_extra tools=$smarty.capture.tools sidebar=$smarty.capture.sidebar adv_buttons=$smarty.capture.adv_buttons buttons=$smarty.capture.buttons}







