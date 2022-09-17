{capture name="mainbox"}
<style>
    .category_container{
        width: 45%;
        padding: 5px;
    }
    .inner_category_container{
        margin:5px;
        {*float:left;*}
    }
    #content_etsy_categories_map label{
        margin:10px;
    }
    #categories {
        margin-right:5%;
    }
    #content_etsy_categories_map label input{
        vertical-align:top;
        margin-right:5px;
    }
    .select_box_container{
        display:block;
      
    }
    .help-block, .help-inline {
    color: red;
    }
</style>

<form action="{""|fn_url}" method="post" enctype="multipart/form-data" name="ebay_category_mapped_form">
{if $categories_mapped}
{include file="common/pagination.tpl" save_current_url=true}
{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}
{assign var="c_icon" value="<i class=\"icon-`$search.sort_order_rev`\"></i>"}
{assign var="c_dummy" value="<i class=\"icon-dummy\"></i>"}
{assign var="rev" value=$smarty.request.content_id|default:"pagination_contents"}
<input type="hidden" name="id"  value="{$merchant_data.id}" />
<div class="table-responsive-wrapper">
<table class="table table-middle sortable table-responsive">
<thead>
    <tr>
        {*<th class="left" width="3%">{include file="common/check_items.tpl"}</th>*}
        <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=category_id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>Hypd4 Category Id{if $search.sort_by == "category_id"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        <th width="15%"><a class="cm-ajax" href="{"`$c_url`&sort_by=category&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>Hypd4 Category{if $search.sort_by == "category"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        <th width="10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=ebay_category_id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>Ebay Category Id{if $search.sort_by == "ebay_category_id"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
        <th width="15%"><a class="cm-ajax" href="{"`$c_url`&sort_by=ebay_category&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>Ebay Category{if $search.sort_by == "ebay_category"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</th>
         <th width="5%">&nbsp;</th>
    </tr>
</thead>
<tbody>
{foreach from=$categories_mapped item="category_map"}
<tr class="cm-row-status-{$category_map.status|lower}">
    {*<td class="left" width="3%">
        <input type="checkbox" name="etsy_ids[]" value="{$category_map.id}" class="checkbox cm-item" />
    </td>*}
    <td class="row-status" data-th='{__("cscart_category_id")}'><a href="{"categories.update?category_id=`$category_map.category_id`"|fn_url}">{$category_map.category_id}</a></td>
    <td class="row-status" data-th='{__("cscart_category")}'><a href="{"categories.update?category_id=`$category_map.category_id`"|fn_url}">{$category_map.category_id|fn_get_category_name}</a></td>
    <td class="row-status" data-th='{__("ebay_category_id")}'>{$category_map.ebay_category_id}</td>
    <td class="row-status" data-th='{__("ebay_category")}'>{$category_map.ebay_category}</td>
     <td class="nowrap" data-th='{__("tools")}'>
        <div class="hidden-tools">
		{if $isVendor == 0}
            {capture name="tools_list"}
                <li>{btn type="list" class="cm-confirm" text=__("delete") href="wk_ebay.delete_category_map?id=`$category_map.id`&account_id=`$category_map.account_id`" method="POST"}</li>
            {/capture}
            {dropdown content=$smarty.capture.tools_list}
			
		{/if}
        </div>
    </td>
</tr>
{/foreach}
</tbody>
</table>
</div>
{include file="common/pagination.tpl"}
{*{capture name="buttons"}
    {*{capture name="tools_list"}
            <li>{btn type="delete_selected" dispatch="dispatch[wk_etsy.m_delete_category_map]" form="etsy_category_mapped_form"}</li>
    {/capture}*}
    {*{dropdown content=$smarty.capture.tools_list}*}
{*{/capture}*}

{else}
    <p class="no-items">{__("no_data")}</p>
{/if}

{capture name="adv_buttons"}
	{include file="common/popupbox.tpl"
		act="create"
		text=__("map_new_category")
		title=__("map_new_category")
		id="ebay_categories_map"
        icon="icon-plus"
		content=""
	}
{/capture}

</form>

{capture name="sidebar"}
{include file="addons/wk_ebay_connector/common/components/tab.tpl"}
{/capture}

{/capture}
{include file="common/mainbox.tpl" title=__("manage_category_mapping") content=$smarty.capture.mainbox sidebar=$smarty.capture.sidebar buttons=$smarty.capture.buttons adv_buttons=$smarty.capture.adv_buttons}

<div class="hidden" title="{__('map_new_category')}" id="content_ebay_categories_map">
    <form id='form' action="{""|fn_url}" method="post" name="map_ebay_category_form" class="form-horizontal form-edit cm-disable-empty-files" enctype="multipart/form-data">
            <input type="hidden" name="account_id" value="{$account_id}"> 
            <div class="cscart_categories pull-left category_container" >
                <div class="select_box_container">
                    {math equation="rand()" assign="rnd"}
                    <label for="ccategories_{$rnd}_ids" class="control-label ">Hypd4 Categories</label>
                        {include file="pickers/categories/picker.tpl"
                            company_id=$runtime.company_id|default:$merchant_data.company_id
                            rnd=$rnd
                            data_id="categories"
                            input_name="cs_cart_category"
                            hide_link=true
                            hide_delete_button=true
                            display_input_id="category_ids"
                            disable_no_item_text=true
                            but_meta="btn"
                            show_active_path=true
                        }
                </div>
            </div>
            <div class="etsy_categories pull-right category_container" id="categories" >
                <div class="control-group">
                    <label class="control-label" for="elm_ebay_categories">{__("ebay_categories")}:</label>
                    <div class="controls">
                    <select name="ebay_category" id="elm_ebay_categories">
                        {foreach from=$ebay_categories item="category_map"}
                            <option value="{$category_map.id}">{$category_map.title}</option>
                        {/foreach}
                    </select>
                    <input type="hidden" name="ebay_category_name" id="ebay_category_name" value="{$ebay_categories.0.title}">
                    </div>
                </div>
                
            </div>

            <div class="buttons-container buttons-container-picker">
                {include file="buttons/button.tpl"  but_text=__("close") but_role="close" but_target_form="map_ebay_category_form"  but_meta="btn cm-dialog-closer"}

                {include file="buttons/button.tpl" but_role="submit" but_name="dispatch[wk_ebay.category_map]" but_target_form="map_ebay_category_form" but_text=Map but_meta="btn btn-primary cm-submit"}
            </div>
    </form>
<!--content_etsy_categories--></div>
<script type="text/javascript">
    (function(_,$){
        $('#elm_ebay_categories').on('change',function() {
            var colName = $(".etsy_categories option:selected").text();
            $('#ebay_category_name').val(colName);
        });
    }(Tygh,Tygh.$));
</script>
