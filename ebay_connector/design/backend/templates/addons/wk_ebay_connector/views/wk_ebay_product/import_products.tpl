{capture name="mainbox"}
<form action="{"wk_ebay_product.m_map_sync"|fn_url}" method="post" enctype="multipart/form-data" class="form-horizontal form-edit " name="ebay_collection_products_form" id="rkd_form">

{include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id}
<input type="hidden" class="cm-no-hide-input" value="{$account_id}" name="account_id"/>

{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}
{assign var="c_icon" value="<i class=\"icon-`$search.sort_order_rev`\"></i>"}
{assign var="c_dummy" value="<i class=\"icon-dummy\"></i>"}
{assign var="rev" value=$smarty.request.content_id|default:"pagination_contents"}
{if $product_arr}
    <div class="table-responsive-wrapper">
        <table class="table table-middle sortable table-responsive">
            <thead>
                <tr>
                    <th class="center" width="1%">{include file="common/check_items.tpl"}</th>
                    <th width="10%">{__("product_id")}</th>
					<th width="20%">Image</th>
                    <th width="20%">{__("title")}</th>
                    <th width="10%">{__("store_productId")}</th>
                    <th width="10%">{__("quantity")}</th>
                    <th width="10%">{__("price")}</th>
                    <th width="5%">&nbsp;</th>
                    
                </tr>
            </thead>
            <tbody>
                
                    {foreach from=$product_arr item="product_data"}
                    {assign var="pid" value=$product_data.ItemID}

                    <tr class="cm-row-status-{$product_data.status|lower}" id="{$product_data.ItemID}">
                        <td class="left mobile-hide" width="1%">
                        {if $cscartProductIds[{$pid}]}
                            --
                        {else}
                            <input type="checkbox" name="map_ids[]" value="{$product_data.ItemID}" class="checkbox cm-item rkd_ros"/>
                        {/if}
                        </td>
                        <td data-th='{__("product_id")}'> 
                            {$product_data.ItemID}
                        </td>
						<td data-th='{__("picturedetails")}'><img src="{if is_array($product_data.PictureDetails['PictureURL'])}{$product_data.PictureDetails['PictureURL'][0]}{else}{$product_data.PictureDetails['PictureURL']}{/if}" style="width: 70px;"></td>
                        <td data-th='{__("title")}'>{$product_data.Title}</td>
                        <td data-th='{__("store_productId")}'>{if $cscartProductIds[{$pid}]} <a href="{"products.update&product_id={$cscartProductIds[{$pid}]}"|fn_url}">{$cscartProductIds[{$pid}]}</a>{else}--{/if}</td>
                    
                        <td data-th='{__("quantity")}'> 
                            {$product_data.Quantity}
                        </td>
                        
                        <td data-th='{__("price")}'> 
                            {$product_data.SellingStatus.CurrentPrice._} {$product_data.SellingStatus.CurrentPrice.currencyID}
                        </td>
    
                        <td class="nowrap"> {*  data-th='{__("tools")}' removed *}
                            {if !$cscartProductIds[{$pid}]}
                                {include
                                    file="buttons/button.tpl"
                                    but_text="Import"
                                    but_meta="cm-post"
                                    but_role="action"
                                    but_href="wk_ebay_product.map_sync?product_id=`$product_data.ItemID`&account_id=`$account_id`"
                                }
                            {/if}
                            {* <div class="hidden-tools">
                                {capture name="tools_list"}
                                    <li>
                                    {if !$cscartProductIds[{$pid}]}
                                    
                                        <li>{btn type="list"  text= __("product_mapping") href="wk_ebay_product.map_sync?product_id=`$product_data.id`&account_id=`$account_id`&collection_id=`$product_data.collection_id`" method="POST"}</li>
                                    </li>
                                    {/if}
                                {/capture}
                                {dropdown content=$smarty.capture.tools_list}
                            </div> *}
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
        {if $product_arr}
            
            {include
                file="buttons/button.tpl"
                but_text="Import Selected"
                but_meta="cm-comet cm-process-items"
                but_role="submit-link"
                but_target_form="ebay_collection_products_form"
            }
        {/if}
{* 
    {capture name="tools_list"}
        {if $product_arr}
        <li>{btn type="list" dispatch="dispatch[wk_ebay_product.m_map_sync]" text=__("sync_product") form="ebay_collection_products_form" but_meta="cm-comet"}</li>
        {/if}
    {/capture}
    {dropdown content=$smarty.capture.tools_list} *}
{/capture}

</form>
<script>
$(document).ready(function(){
$("#rkd_form").submit(function(event){
event.preventDefault();
var values = $("input[name='map_ids[]']:checked")
              .map(function(){
			  return $(this).val();
			  }).get();
if(values.length > 0){
$(".modal-rkd").show();
$(".modal-rkd-operation #modal-rkd-counter").html("0");
$(".modal-rkd-operation #modal-rkd-total").html(values.length);
}
$i = 0;
	$.ajax({
		url: '{"wk_ebay_product.map_sync_api"|fn_url}',
		data:'account_id={$account_id}&'+'product_id='+values[$i],
		method: 'get',
		success:function(data){
			$(".modal-rkd-operation #modal-rkd-counter").html(Number($(".modal-rkd-operation #modal-rkd-counter").html()) + 1);
			if(Number($(".modal-rkd-operation #modal-rkd-counter").html()) >= values.length){
				location.reload();
			}else{
				importTimer(values, $i+1);
			}
			
			// get done operation
			
			let per = (Number($(".modal-rkd-operation #modal-rkd-counter").html()) / Number(values.length)) * 100;
			
			
			$("#myBar").animate({
			"width":per+"%"
			},500);
			
		},
		error:function(data){
		    location.reload();
		}
	});




});
});


function importTimer(values,$i){
$.ajax({
		url: '{"wk_ebay_product.map_sync_api"|fn_url}',
		data:'account_id={$account_id}&'+'product_id='+values[$i],
		method: 'get',
		success:function(data){
			$(".modal-rkd-operation #modal-rkd-counter").html(Number($(".modal-rkd-operation #modal-rkd-counter").html()) + 1);
			if(Number($(".modal-rkd-operation #modal-rkd-counter").html()) == values.length){
				location.reload();
			}else{
				importTimer(values, $i+1);
			}
			
			
			// get done operation
			
			let per = (Number($(".modal-rkd-operation #modal-rkd-counter").html()) / Number(values.length)) * 100;
			
			
			$("#myBar").animate({
			"width":per+"%"
			},500);
		}
	});
}
</script>
{/capture}
    {include file="addons/wk_ebay_connector/views/wk_ebay_product/components/modal.tpl"}

{include file="common/mainbox.tpl" title=__("import_products_from_ebay") content=$smarty.capture.mainbox title_extra=$smarty.capture.title_extra tools=$smarty.capture.tools buttons=$smarty.capture.buttons}

