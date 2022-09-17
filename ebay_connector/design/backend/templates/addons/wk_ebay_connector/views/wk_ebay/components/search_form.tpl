{*{include file="addons/wk_etsy_connector/common/components/tab.tpl"}*}

<div class="sidebar-row">
<h6>{__("search")}</h6>

<form action="{""|fn_url}" name="etsy_merchant_search_form" method="get">
{capture name="simple_search"}

<div class="sidebar-field">
    <label>{__("merchant_id")}</label>
    <input type="text" name="merchant_id" size="20" value="{$search.merchant_id}" class="search-input-text" />
</div>
<div class="sidebar-field">
    <label>{__("country")}</label>
    <select name="country_code" class="input-text">
        <option value="">{__("all")}</option>
        <option value="br" {if $search.country_code eq 'br'}selected{/if}>{"br"|fn_get_country_name}</option>
        <option value="in" {if $search.country_code eq 'in'}selected{/if}>{"in"|fn_get_country_name}</option>
        <option value="ca" {if $search.country_code eq 'ca'}selected{/if}>{"ca"|fn_get_country_name}</option>
        <option value="us" {if $search.country_code eq 'us'}selected{/if}>{"us"|fn_get_country_name}</option>
        <option value="mx" {if $search.country_code eq 'mx'}selected{/if}>{"mx"|fn_get_country_name}</option>
        <option value="de" {if $search.country_code eq 'de'}selected{/if}>{"de"|fn_get_country_name}</option>
        <option value="es" {if $search.country_code eq 'es'}selected{/if}>{"es"|fn_get_country_name}</option>
        <option value="fr" {if $search.country_code eq 'fr'}selected{/if}>{"fr"|fn_get_country_name}</option>
        <option value="it" {if $search.country_code eq 'it'}selected{/if}>{"it"|fn_get_country_name}</option>
        <option value="gb" {if $search.country_code eq 'gb'}selected{/if}>{"gb"|fn_get_country_name}</option>
        <option value="jp" {if $search.country_code eq 'jp'}selected{/if}>{"jp"|fn_get_country_name}</option>
        <option value="cn" {if $search.country_code eq 'cn'}selected{/if}>{"cn"|fn_get_country_name}</option>
    </select> 
</div>

<div class="sidebar-field">
    <label>{__("status")}</label>
    <select name="status" class="input-text">
        <option value="">{__("all")}</option>
        <option value="A" {if $search.status eq 'A'}selected{/if}>{__("active")}</option>
        <option value="D" {if $search.status eq 'D'}selected{/if}>{__("disable")}</option>
    </select> 
</div>

{/capture}

{include file="common/advanced_search.tpl" simple_search=$smarty.capture.simple_search dispatch=$dispatch view_type="wk_etsy" in_popup=$in_popup advanced_search=false}

</form>
</div>