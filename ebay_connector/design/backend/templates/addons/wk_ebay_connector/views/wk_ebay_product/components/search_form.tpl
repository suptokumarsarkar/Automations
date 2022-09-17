{include file="addons/wk_ebay_connector/common/components/tab.tpl"}

<div class="sidebar-row">
<h6>{__("search")}</h6>

<form action="{""|fn_url}" name="ebay_product_search_form" method="get">
{capture name="simple_search"}
<input type="hidden" name="account_id" value="{$account_id}" />
<div class="sidebar-field">
    <label>{__("listing_id")}</label>
    <input type="text" name="listing_id" size="20" value="{$search.listing_id}" class="search-input-text" />
</div>
{* <div class="sidebar-field">
    <label>{__("product_id")}</label>
    <input type="text" name="product_id" size="20" value="{$search.product_id}" class="search-input-text" />
</div>
<div class="sidebar-field">
    <label>{__("quantity")}</label>
    <input type="text" name="quantity" size="20" value="{$search.quantity}" class="search-input-text" />
</div> *}
<div class="sidebar-field">
    <label>{__("product_name")}</label>
    <input type="text" name="product_name" size="20" value="{$search.product_name}" class="search-input-text" />
</div>
<div class="sidebar-field">
    <label>{__("status")}</label>
    <select name="status" class="input-text">
        <option value="">{__("all")}</option>
        <option value="draft" {if $search.status eq 'draft'}selected{/if}>{__("draft")}</option>
        <option value="inactive" {if $search.status eq 'inactive'}selected{/if}>{__("inactive")}</option>
        <option value="active" {if $search.status eq 'active'}selected{/if}>{__("active")}</option>
        <option value="expired" {if $search.status eq 'expired'}selected{/if}>{__("expired")}</option>
    </select> 
</div>
<div class="sidebar-field">
    <label>{__("action")}</label>
    <select name="action" class="input-text">
        <option value="">{__("all")}</option>
        <option value="I" {if $search.action eq 'I'}selected{/if}>{__("import")}</option>
        <option value="E" {if $search.action eq 'E'}selected{/if}>{__("export")}</option>
    </select> 
</div>

{/capture}

{include file="common/advanced_search.tpl" simple_search=$smarty.capture.simple_search dispatch=$dispatch view_type="wk_ebay_product" in_popup=$in_popup advanced_search=false}

</form>
</div>