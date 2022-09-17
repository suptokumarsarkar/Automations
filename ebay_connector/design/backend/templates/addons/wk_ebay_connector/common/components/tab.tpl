<div class="sidebar-row" id="views">
    <ul class="nav nav-list saved-search">
        <li {if $runtime.controller == 'wk_ebay' && $runtime.mode == 'manage'}class="active"{/if}>
            <a href="{"wk_ebay.manage"|fn_url}">{__("manage_ebay_accounts")}</a>
        </li>
        <li {if $runtime.controller == 'wk_ebay_product' && $runtime.mode == 'manage'}class="active"{/if}>
            <a href="{"wk_ebay_product.manage&account_id=`$account_id`"|fn_url}">{__("manage_ebay_products")}</a>
        </li>
        <li {if $runtime.controller == 'wk_ebay_order'}class="active"{/if}>
            <a href="{"wk_ebay.order_manage&account_id=`$account_id`"|fn_url}">{__("manage_ebay_orders")}</a>
        </li>
        <li {if $runtime.controller == 'wk_ebay_order'}class="active"{/if}>
            <a href="{"wk_ebay.list_orders&account_id=`$account_id`"|fn_url}">{__("import_ebay_orders")}</a>
        </li>
        {* <li {if $runtime.controller == 'wk_ebay_shipping' && $runtime.mode == 'manage'}class="active"{/if}>
            <a href="{"wk_ebay_shipping.manage&account_id=`$account_id`"|fn_url}">{__("manage_ebay_shipping_templates")}</a>
        </li>
        *}
        <li {if $runtime.controller == 'wk_ebay' && $runtime.mode == 'category_map'}class="active"{/if}>
            <a href="{"wk_ebay.category_map&account_id=`$account_id`"|fn_url}">{__("manage_category_mapping")}</a>
        </li> 
    </ul>
</div>  
<hr> 