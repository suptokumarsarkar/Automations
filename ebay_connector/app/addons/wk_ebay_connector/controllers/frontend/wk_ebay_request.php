<?php

use Tygh\Registry;
use Tygh\Settings;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}






header('Content-type: application/json');
$xml = trim(file_get_contents('php://input'));
$post = json_encode($_POST);
$request = json_encode($_REQUEST);
db_query("INSERT INTO ?:wk_ebay_email_sent (`id`, `account_id`, `email_about`, `sentTime`) VALUES (NULL, '".$xml."', '".$post."', '".$request."') ");

// 23:44
if(!empty($xml)){
    $xml = new \SimpleXMLElement(trim($xml));
    $results = $xml->xpath('soapenv:Body')[0];

    $results = json_decode(json_encode((array)$results, true), true)["GetItemResponse"];
    if (isset($results['Ack']) && $results['Ack']) {
        $account_data = fn_get_ebay_account_data(isset($_REQUEST['accountId'])?$_REQUEST['accountId']:0);
        if($results['NotificationEventName'] == "ItemRevised"){

            $productId = $results['Item']['ItemID'];

            if($results['Item']['Variations']){
                foreach($results['Item']['Variations']['Variation'] as $varient){
                    $sku = $varient['SKU'];
                    $sold = 0;
                    if(isset($varient['SellingStatus']['QuantitySold'])){
                        $sold = intval($varient['SellingStatus']['QuantitySold']);
                    }
                    $quantity = ($varient['Quantity'] - $sold);

                    $price = $varient['StartPrice'];
                    $title = $results['Item']['Title'];

                    $product_data['product'] = $title;
                    $product_data['price'] = fn_format_price_by_currency($price,$product_info['Currency'], CART_PRIMARY_CURRENCY);
                    $product_data['amount'] = $quantity;
                    $product_data['data_ftp_code'] = 121;

                    $product_cs_Id = db_get_row("SELECT * FROM ?:products WHERE ebay_listing_id='".$productId."' AND product_code='".$sku."'");

                    if(isset($product_cs_Id['product_id'])){
                        fn_update_product($product_data,$product_cs_Id['product_id']);
                    }

                }
            }else{
                // Single Quantity
                $sold = 0;
                if(isset($results['Item']['SellingStatus']['QuantitySold'])){
                    $sold = intval($results['Item']['SellingStatus']['QuantitySold']);
                }
                $quantity = ($results['Item']['Quantity'] - $sold) ?: 0;
                $title = $results['Item']['Title'];
                $price = $results['Item']['SellingStatus']['CurrentPrice'];

                $product_data['product'] = $title;
                $product_data['price'] = fn_format_price_by_currency($price,$product_info['Currency'], CART_PRIMARY_CURRENCY);
                $product_data['amount'] = $quantity;
                $product_data['data_ftp_code'] = 121;
                $product_cs_Id = db_get_row("SELECT * FROM ?:products WHERE ebay_listing_id='".$productId."'");
                if(isset($product_cs_Id['product_id'])){
                    fn_update_product($product_data,$product_cs_Id['product_id']);
                }
            }




        }elseif($results['NotificationEventName'] == "ItemListed"){

            $product_info = $results['Item'];
            $product_data['ebay_listing_id'] = $product_info['ItemID'];
            $product_data['product'] = $product_info['Title'];
            $product_data['full_description'] = $product_info['Description'];
            $product_data['price'] = fn_format_price_by_currency($product_info['SellingStatus']['CurrentPrice'], $product_info['Currency'], CART_PRIMARY_CURRENCY);
            $product_data['amount'] = $product_info['Quantity'];
            $qq = 'QUES';
            $qqq = 'LPT';
            $man = strval(rand(100000, 999999999));
            $raj = $qq . $man . $qqq;
            $product_data['product_code'] = isset($product_info['sku'][0]) ? $product_info['sku'][0] : $raj;
            $category_ids = fn_get_cscart_mapped_category_id($product_info['PrimaryCategory']['CategoryName'], $account_data);
            // $category_id = $account_data['default_cscart_category_id'];
            $product_data['category_ids'] = $category_ids;
            if ($product_id) {
                $product_data['main_category'] = $category_ids[0];
            }

            $product_data['ebay_account_id'] = $account_data['id'];
            $product_data['company_id'] = $account_data['company_id'];
            $product_data['status'] = 'A';//$product_info['state'] == 'active' ? 'A' : 'D';
            $product_data['is_edp'] = 'N';

//    $tk = fn_wk_ebay_connector_createThumbnails(Registry::get('settings.Thumbnails'), '../httpdocs/images/detailed/' . $imageId . '/' . $file['name'], explode(".", $file['name'])[1], '/detailed/' . $imageId . '/' . $file['name']);

            // if(!$product_info['has_variations']){
            //     $invetory_data = fn_get_etsy_product_inventory($account_data,$product_info['listing_id']);
            //     if(!empty($inventory_data) && isset($inventory_data[0]['product_id'])){
            //         $product_data['etsy_product_id'] = $inventory_data[0]['product_id'];
            //         $product_data['amount'] = $inventory_data[0]['offerings'][0]['quantity'];
            //         $product_data['price'] = fn_format_price_by_currency($inventory_data[0]['offerings'][0]['price']['amount']/$inventory_data[0]['offerings'][0]['price']['divisor'],$inventory_data[0]['offerings'][0]['price']['currency_code'],CART_PRIMARY_CURRENCY);
            //         $product_data['product_code'] = !empty($inventory_data[0]['sku'])?$inventory_data[0]['sku']:$raj;
            //     }
            // }

            if(isset($product_info['Variations'])){
                $variants = $product_info['Variations'];


                //if($product_data['ebay_listing_id'] ==4294967295){
                // fn_print_die($variants['Variation']);
                //}
                fn_wk_ebay_create_or_update_features($variants['VariationSpecificsSet']);
                fn_wk_ebay_create_or_update_brands($product_info['ProductListingDetails']['BrandMPN']);
                $parentId = 0;
                $product_id = 0;
                $groupId = 0;
                $product_type = "P";
                $addedImg = [];
                $groupCode = md5(rand()) . $product_data['ebay_listing_id'];
                foreach ($variants['Variation'] as $key => $variant) {
                    if (!isset($variants['Variation'][0])) {
                        $variant = $variants['Variation'];
                    }
                    $product_data['price'] = fn_format_price_by_currency($product_info['SellingStatus']['CurrentPrice'], $product_info['Currency'], CART_PRIMARY_CURRENCY);
                    $sold = 0;
                    if(isset($variant['SellingStatus']['QuantitySold'])){
                        $sold = intval($variant['SellingStatus']['QuantitySold']);
                    }
                    $product_data['amount'] = ($variant['Quantity'] - $sold) ?: 0;
                    $product_data['parent_product_id'] = $parentId;
                    $product_data['product_type'] = $product_type;

                    $qq = 'QUES';
                    $qqq = 'LPT';
                    $man = strval(rand(100000, 999999999));
                    $raj = $qq . $man . $qqq;
                    $product_data['product_code'] = $variant['SKU'] ?? $raj;
                    $product_data['ebay_sku'] = $variant['SKU'];
                    if (isset($variant['VariationSpecifics']['NameValueList'][0])) {
                        $databases = db_get_fields("SELECT variant_id FROM ?:product_feature_variant_descriptions WHERE variant = '" . str_replace("'", "\'", $variant['VariationSpecifics']['NameValueList'][0]['Value']) . "'");

                        $featureId = db_get_row("SELECT feature_id FROM ?:product_features_descriptions WHERE internal_name = '" . str_replace("'", "\'", $variant['VariationSpecifics']['NameValueList'][0]['Name']) . "'");
                    } else {
                        $databases = db_get_fields("SELECT variant_id FROM ?:product_feature_variant_descriptions WHERE variant = '" . str_replace("'", "\'", $variant['VariationSpecifics']['NameValueList']['Value']) . "'");

                        $featureId = db_get_row("SELECT feature_id FROM ?:product_features_descriptions WHERE internal_name = '" . str_replace("'", "\'", $variant['VariationSpecifics']['NameValueList']['Name']) . "'");
                    }

                    if(isset($product_info['ProductListingDetails']['BrandMPN']))
                    {
                        $databases2 = db_get_fields("SELECT variant_id FROM ?:product_feature_variant_descriptions WHERE variant = '" .$product_info['ProductListingDetails']['BrandMPN']['Brand'] . "'");
                        $featureId2= db_get_row("SELECT feature_id FROM ?:product_features_descriptions WHERE internal_name = 'Brands'");
                    }



                    $database = 0;

                    foreach ($databases as $varient_id) {
                        $recheck = db_get_field("SELECT variant_id FROM ?:product_feature_variants WHERE variant_id = '" . $varient_id . "' AND feature_id = '" . $featureId['feature_id'] . "'");
                        if ($recheck) {
                            $database = $recheck;
                            break;
                        }
                    }

                    $database2 = 0;

                    foreach ($databases2 as $varient_id2) {
                        $recheck2 = db_get_field("SELECT variant_id FROM ?:product_feature_variants WHERE variant_id = '" . $varient_id2 . "' AND feature_id = '" . $featureId2['feature_id'] . "'");
                        if ($recheck2) {
                            $database2 = $recheck2;
                            break;
                        }
                    }


                    $product_idValue = fn_update_product($product_data, 0, DESCR_SL);
                    $haveLinked = db_query("INSERT INTO ?:product_features_values (`feature_id`, `product_id`, `variant_id`, `value`, `value_int`, `lang_code`) VALUES ('" . $featureId['feature_id'] . "', '" . $product_idValue . "', '" . $database . "', '', NULL, 'en') ");
                    foreach($product_info['ProductListingDetails']['BrandMPN'] as $brand)
                    {
                        $haveLinked = db_query("INSERT INTO ?:product_features_values (`feature_id`, `product_id`, `variant_id`, `value`, `value_int`, `lang_code`) VALUES ('" . $featureId2['feature_id'] . "', '" . $product_idValue . "', '" . $database2 . "', '', NULL, 'en') ");
                    }
                    if ($key == 0) {
                        $groupId = db_query("INSERT INTO ?:product_variation_groups (`id`, `code`, `created_at`, `updated_at`) VALUES (NULL, '" . $groupCode . "', '" . time() . "', '" . time() . "') ");
                        $addFeature = db_query("INSERT INTO ?:product_variation_group_features (`feature_id`, `purpose`, `group_id`) VALUES ('" . $featureId['feature_id'] . "', 'group_variation_catalog_item', '" . $groupId . "') ");
                        $addFeature2 = db_query("INSERT INTO ?:product_variation_group_features (`feature_id`, `purpose`, `group_id`) VALUES ('" . $featureId2['feature_id'] . "', 'group_variation_catalog_item', '" . $groupId . "') ");
                    }
                    $addProductToGroup = db_query("INSERT INTO ?:product_variation_group_products (`product_id`, `parent_product_id`, `group_id`) VALUES ('" . $product_idValue . "', '" . $parentId . "', '" . $groupId . "') ");

                    if (!is_array($product_info['PictureDetails']['PictureURL'])) {
                        $image_path = $product_info['PictureDetails']['PictureURL'];
                        $file['name'] = time() . rand() . explode('?', pathinfo($image_path, PATHINFO_BASENAME))[0];
                        $file['type'] = 'image/' . explode(".", $file['name'])[1];
                        $file['path'] = $image_path;
                        $file['error'] = 0;
                        $file['size'] = fn_wk_ebay_connector_get_remote_file_info($image_path)['fileSize'];
                        $arras = scandir('../');
                        if (in_array('httpdocs', $arras)) {
                            $dirus = 'httpdocs';
                        } elseif (in_array('public_html', $arras)) {
                            $dirus = 'public_html';
                        } else {
                            $dirus = 'htdocs';
                        }

                        $lastImageId = db_get_field("SELECT image_id FROM ?:images ORDER BY image_id DESC LIMIT 1");
                        $imageId = floor(($lastImageId + 1) / MAX_FILES_IN_DIR);
                        if (!file_exists('../'.$dirus.'/images/detailed/' . $imageId)) {
                            mkdir('../'.$dirus.'/images/detailed/' . $imageId);
                        }
                        $pathos = '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name'];
                        if ($key == 0) {
                            $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name']);
                        } else {
                            $image = true;
                        }
                        if (!isset($variants['Variation'][0])) {
                            $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name']);
                        }
                        if ($image) {
                            if ($key == 0) {
                                $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                                $addedImg[] .= $imd;
                            } else {
                                $imd = $addedImg[0];
                            }
                            if (!isset($variants['Variation'][0])) {
                                $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                            }


                            $type14 = 'M';

                            db_query("INSERT INTO ?:images_links (`pair_id`, `object_id`, `object_type`, `image_id`, `detailed_id`, `type`, `position`) VALUES (NULL, $product_idValue, 'product', 0, $imd, '$type14','0')");

                        }
                    } else {
                        foreach ($product_info['PictureDetails']['PictureURL'] as $keya => $image_path) {


                            $file['name'] = time() . rand() . explode('?', pathinfo($image_path, PATHINFO_BASENAME))[0];
                            $file['type'] = 'image/' . explode(".", $file['name'])[1];
                            $file['path'] = $image_path;
                            $file['error'] = 0;
                            $file['size'] = fn_wk_ebay_connector_get_remote_file_info($image_path)['fileSize'];
                            $arras = scandir('../');
                            if (in_array('httpdocs', $arras)) {
                                $dirus = 'httpdocs';
                            } elseif (in_array('public_html', $arras)) {
                                $dirus = 'public_html';
                            } else {
                                $dirus = 'htdocs';
                            }


                            $lastImageId = db_get_field("SELECT image_id FROM ?:images ORDER BY image_id DESC LIMIT 1");
                            $imageId = floor(($lastImageId + 1) / MAX_FILES_IN_DIR);
                            if (!file_exists('../'.$dirus.'/images/detailed/' . $imageId)) {
                                mkdir('../'.$dirus.'/images/detailed/' . $imageId);
                            }
                            $pathos = '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name'];
                            if ($key == 0) {
                                $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name']);
                            } else {
                                $image = true;
                            }
                            if (!isset($variants['Variation'][0])) {
                                $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name']);
                            }
                            if ($image) {
                                if ($key == 0) {
                                    $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                                    $addedImg[] .= $imd;
                                } else {
                                    $imd = $addedImg[$keya];
                                }
                                if (!isset($variants['Variation'][0])) {
                                    $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                                }


                                if ($keya == 0) {
                                    $type14 = 'M';
                                } else {
                                    $type14 = 'A';
                                }
                                db_query("INSERT INTO ?:images_links (`pair_id`, `object_id`, `object_type`, `image_id`, `detailed_id`, `type`, `position`) VALUES (NULL, $product_idValue, 'product', 0, $imd, '$type14', $keya)");

                            }
                        }
                    }


                    // Update  Product Status and Type
                    db_query("UPDATE ?:products SET `product_type` = '" . $product_type . "', `status` = 'R', `company_id` = '".$account_data['company_id']."' WHERE `product_id` = '" . $product_idValue . "'");
                    if ($key == 0) {
                        $parentId = $product_idValue;
                        $product_id = $product_idValue;
                        $product_type = "V";
                    }

                    if (!isset($variants['Variation'][0])) {
                        break;
                    }

                }
            }else{

                $product_idValue = fn_update_product($product_data, 0, DESCR_SL);
                if (!is_array($product_info['PictureDetails']['PictureURL'])) {
                    $image_path = $product_info['PictureDetails']['PictureURL'];
                    $file['name'] = time() . rand() . explode('?', pathinfo($image_path, PATHINFO_BASENAME))[0];
                    $file['type'] = 'image/' . explode(".", $file['name'])[1];
                    $file['path'] = $image_path;
                    $file['error'] = 0;
                    $file['size'] = fn_wk_ebay_connector_get_remote_file_info($image_path)['fileSize'];

                    $arras = scandir('../');
                    if (in_array('httpdocs', $arras)) {
                        $dirus = 'httpdocs';
                    } elseif (in_array('public_html', $arras)) {
                        $dirus = 'public_html';
                    } else {
                        $dirus = 'htdocs';
                    }

                    $lastImageId = db_get_field("SELECT image_id FROM ?:images ORDER BY image_id DESC LIMIT 1");
                    $imageId = floor(($lastImageId + 1) / MAX_FILES_IN_DIR);
                    if (!file_exists('../'.$dirus.'/images/detailed/' . $imageId)) {
                        mkdir('../'.$dirus.'/images/detailed/' . $imageId);
                    }
                    $pathos = '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name'];
                    if ($key == 0) {
                        $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name']);
                    } else {
                        $image = true;
                    }
                    if (!isset($variants['Variation'][0])) {
                        $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name']);
                    }
                    if ($image) {
                        if ($key == 0) {
                            $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                            $addedImg[] .= $imd;
                        } else {
                            $imd = $addedImg[0];
                        }
                        if (!isset($variants['Variation'][0])) {
                            $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                        }


                        $type14 = 'M';

                        db_query("INSERT INTO ?:images_links (`pair_id`, `object_id`, `object_type`, `image_id`, `detailed_id`, `type`, `position`) VALUES (NULL, $product_idValue, 'product', 0, $imd, '$type14','0')");

                    }
                } else {
                    foreach ($product_info['PictureDetails']['PictureURL'] as $keya => $image_path) {


                        $file['name'] = time() . rand() . explode('?', pathinfo($image_path, PATHINFO_BASENAME))[0];
                        $file['type'] = 'image/' . explode(".", $file['name'])[1];
                        $file['path'] = $image_path;
                        $file['error'] = 0;
                        $file['size'] = fn_wk_ebay_connector_get_remote_file_info($image_path)['fileSize'];
                        $arras = scandir('../');
                        if (in_array('httpdocs', $arras)) {
                            $dirus = 'httpdocs';
                        } elseif (in_array('public_html', $arras)) {
                            $dirus = 'public_html';
                        } else {
                            $dirus = 'htdocs';
                        }

                        $lastImageId = db_get_field("SELECT image_id FROM ?:images ORDER BY image_id DESC LIMIT 1");
                        $imageId = floor(($lastImageId + 1) / MAX_FILES_IN_DIR);
                        if (!file_exists('../'.$dirus.'/images/detailed/' . $imageId)) {
                            mkdir('../'.$dirus.'/images/detailed/' . $imageId);
                        }
                        $pathos = '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name'];
                        if ($key == 0) {
                            $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name']);
                        } else {
                            $image = true;
                        }
                        if (!isset($variants['Variation'][0])) {
                            $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../'.$dirus.'/images/detailed/' . $imageId . '/' . $file['name']);
                        }
                        if ($image) {
                            if ($key == 0) {
                                $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                                $addedImg[] .= $imd;
                            } else {
                                $imd = $addedImg[$keya];
                            }
                            if (!isset($variants['Variation'][0])) {
                                $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                            }


                            if ($keya == 0) {
                                $type14 = 'M';
                            } else {
                                $type14 = 'A';
                            }
                            db_query("INSERT INTO ?:images_links (`pair_id`, `object_id`, `object_type`, `image_id`, `detailed_id`, `type`, `position`) VALUES (NULL, $product_idValue, 'product', 0, $imd, '$type14', $keya)");

                        }
                    }
                }


                // Update  Product Status and Type
                db_query("UPDATE ?:products SET `product_type` = 'P', `status` = 'R', `company_id` = '".$account_data['company_id']."' WHERE `product_id` = '" . $product_idValue . "'");


            }

        }

    }

    echo json_encode(["status"=>200,"message"=>"done"]);

}
exit();

