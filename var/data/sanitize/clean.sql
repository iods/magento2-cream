##########################################################
# PRODUCTS
##########################################################
DELETE FROM `catalog_product_bundle_option`;
DELETE FROM `catalog_product_bundle_option_value`;
DELETE FROM `catalog_product_bundle_selection`;
DELETE FROM `catalog_product_entity_datetime`;
DELETE FROM `catalog_product_entity_decimal`;
DELETE FROM `catalog_product_entity_gallery`;
DELETE FROM `catalog_product_entity_int`;
DELETE FROM `catalog_product_entity_media_gallery`;
DELETE FROM `catalog_product_entity_media_gallery_value`;
DELETE FROM `catalog_product_entity_text`;
DELETE FROM `catalog_product_entity_tier_price`;
DELETE FROM `catalog_product_entity_varchar`;
DELETE FROM `catalog_product_link`;
DELETE FROM `catalog_product_link_attribute_decimal`;
DELETE FROM `catalog_product_link_attribute_int`;
DELETE FROM `catalog_product_link_attribute_varchar`;
DELETE FROM `catalog_product_option`;
DELETE FROM `catalog_product_option_price`;
DELETE FROM `catalog_product_option_title`;
DELETE FROM `catalog_product_option_type_price`;
DELETE FROM `catalog_product_option_type_title`;
DELETE FROM `catalog_product_option_type_value`;
DELETE FROM `catalog_product_super_attribute_label`;
DELETE FROM `catalog_product_super_attribute`;
DELETE FROM `catalog_product_super_link`;
DELETE FROM `catalog_product_website`;
DELETE FROM `catalog_category_product_index`;
DELETE FROM `catalog_category_product`;
DELETE FROM `cataloginventory_stock_item`;
DELETE FROM `cataloginventory_stock_status`;
DELETE FROM `catalog_product_entity`;

DELETE FROM `url_rewrite` WHERE `entity_type` = 'product';

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `catalog_product_bundle_option`;
TRUNCATE TABLE `catalog_product_bundle_option_value`;
TRUNCATE TABLE `catalog_product_bundle_selection`;
TRUNCATE TABLE `catalog_product_entity_datetime`;
TRUNCATE TABLE `catalog_product_entity_decimal`;
TRUNCATE TABLE `catalog_product_entity_gallery`;
TRUNCATE TABLE `catalog_product_entity_int`;
TRUNCATE TABLE `catalog_product_entity_media_gallery`;
TRUNCATE TABLE `catalog_product_entity_media_gallery_value`;
TRUNCATE TABLE `catalog_product_entity_text`;
TRUNCATE TABLE `catalog_product_entity_tier_price`;
TRUNCATE TABLE `catalog_product_entity_varchar`;
TRUNCATE TABLE `catalog_product_link`;
TRUNCATE TABLE `catalog_product_link_attribute_decimal`;
TRUNCATE TABLE `catalog_product_link_attribute_int`;
TRUNCATE TABLE `catalog_product_link_attribute_varchar`;
TRUNCATE TABLE `catalog_product_option`;
TRUNCATE TABLE `catalog_product_option_price`;
TRUNCATE TABLE `catalog_product_option_title`;
TRUNCATE TABLE `catalog_product_option_type_price`;
TRUNCATE TABLE `catalog_product_option_type_title`;
TRUNCATE TABLE `catalog_product_option_type_value`;
TRUNCATE TABLE `catalog_product_super_attribute_label`;
TRUNCATE TABLE `catalog_product_super_attribute`;
TRUNCATE TABLE `catalog_product_super_link`;
TRUNCATE TABLE `catalog_product_website`;
TRUNCATE TABLE `catalog_category_product_index`;
TRUNCATE TABLE `catalog_category_product`;
TRUNCATE TABLE `cataloginventory_stock_item`;
TRUNCATE TABLE `cataloginventory_stock_status`;
TRUNCATE TABLE `catalog_product_entity`;
SET FOREIGN_KEY_CHECKS = 1;

##########################################################
# REVIEWS
##########################################################
DELETE FROM `rating_option_vote`;
DELETE FROM `rating_option_vote_aggregated`;
DELETE FROM `review`;
DELETE FROM `review_detail`;
DELETE FROM `review_entity_summary`;
DELETE FROM `review_store`;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `rating_option_vote`;
TRUNCATE TABLE `rating_option_vote_aggregated`;
TRUNCATE TABLE `review`;
TRUNCATE TABLE `review_detail`;
TRUNCATE TABLE `review_entity_summary`;
TRUNCATE TABLE `review_store`;
SET FOREIGN_KEY_CHECKS = 1;

##########################################################
# CATEGORIES
##########################################################
DELETE FROM `catalog_category_entity`;
DELETE FROM `catalog_category_entity_datetime`;
DELETE FROM `catalog_category_entity_decimal`;
DELETE FROM `catalog_category_entity_int`;
DELETE FROM `catalog_category_entity_text`;
DELETE FROM `catalog_category_entity_varchar`;
DELETE FROM `catalog_category_product`;
DELETE FROM `catalog_category_product_index`;

DELETE FROM `url_rewrite` WHERE `entity_type` = 'category';

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `catalog_category_entity`;
TRUNCATE TABLE `catalog_category_entity_datetime`;
TRUNCATE TABLE `catalog_category_entity_decimal`;
TRUNCATE TABLE `catalog_category_entity_int`;
TRUNCATE TABLE `catalog_category_entity_text`;
TRUNCATE TABLE `catalog_category_entity_varchar`;
TRUNCATE TABLE `catalog_category_product`;
TRUNCATE TABLE `catalog_category_product_index`;
INSERT INTO `catalog_category_entity` (`entity_id`, `attribute_set_id`, `parent_id`, `created_at`, `updated_at`, `path`, `position`, `level`, `children_count`) VALUES
(1, 0, 0, '2016-05-09 08:03:52', '2016-05-09 08:03:52', '1', 0, 0, 1),
(2, 3, 1, '2016-05-09 08:03:52', '2016-05-09 08:03:52', '1/2', 1, 1, 0);
SET FOREIGN_KEY_CHECKS = 1;

##########################################################
# CUSTOMERS
##########################################################
DELETE FROM `customer_address_entity`;
DELETE FROM `customer_address_entity_datetime`;
DELETE FROM `customer_address_entity_decimal`;
DELETE FROM `customer_address_entity_int`;
DELETE FROM `customer_address_entity_text`;
DELETE FROM `customer_address_entity_varchar`;
DELETE FROM `customer_entity`;
DELETE FROM `customer_entity_datetime`;
DELETE FROM `customer_entity_decimal`;
DELETE FROM `customer_entity_int`;
DELETE FROM `customer_entity_text`;
DELETE FROM `customer_entity_varchar`;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE `customer_address_entity`;
TRUNCATE `customer_address_entity_datetime`;
TRUNCATE `customer_address_entity_decimal`;
TRUNCATE `customer_address_entity_int`;
TRUNCATE `customer_address_entity_text`;
TRUNCATE `customer_address_entity_varchar`;
TRUNCATE `customer_entity`;
TRUNCATE `customer_entity_datetime`;
TRUNCATE `customer_entity_decimal`;
TRUNCATE `customer_entity_int`;
TRUNCATE `customer_entity_text`;
TRUNCATE `customer_entity_varchar`;
SET FOREIGN_KEY_CHECKS = 1;

##########################################################
# ORDERS
##########################################################

DELETE FROM `sendfriend_log`;
DELETE FROM `report_compared_product_index`;
DELETE FROM `report_event`;
DELETE FROM `report_viewed_product_aggregated_daily`;
DELETE FROM `report_viewed_product_aggregated_monthly`;
DELETE FROM `report_viewed_product_aggregated_yearly`;
DELETE FROM `report_viewed_product_index`;
DELETE FROM `sales_bestsellers_aggregated_daily`;
DELETE FROM `sales_bestsellers_aggregated_monthly`;
DELETE FROM `sales_bestsellers_aggregated_yearly`;
DELETE FROM `sales_creditmemo`;
DELETE FROM `sales_creditmemo_comment`;
DELETE FROM `sales_creditmemo_grid`;
DELETE FROM `sales_creditmemo_item`;
DELETE FROM `sales_invoice`;
DELETE FROM `sales_invoiced_aggregated`;
DELETE FROM `sales_invoiced_aggregated_order`;
DELETE FROM `sales_invoice_comment`;
DELETE FROM `sales_invoice_grid`;
DELETE FROM `sales_invoice_item`;
DELETE FROM `sales_order`;
DELETE FROM `sales_order_address`;
DELETE FROM `sales_order_aggregated_created`;
DELETE FROM `sales_order_aggregated_updated`;
DELETE FROM `sales_order_grid`;
DELETE FROM `sales_order_item`;
DELETE FROM `sales_order_payment`;
DELETE FROM `sales_order_status_history`;
DELETE FROM `sales_order_tax`;
DELETE FROM `sales_order_tax_item`;
DELETE FROM `sales_payment_transaction`;
DELETE FROM `sales_refunded_aggregated`;
DELETE FROM `sales_refunded_aggregated_order`;
DELETE FROM `sales_shipment`;
DELETE FROM `sales_shipment_comment`;
DELETE FROM `sales_shipment_grid`;
DELETE FROM `sales_shipment_item`;
DELETE FROM `sales_shipment_track`;
DELETE FROM `sales_shipping_aggregated`;
DELETE FROM `sales_shipping_aggregated_order`;
DELETE FROM `quote`;
DELETE FROM `quote_address`;
DELETE FROM `quote_address_item`;
DELETE FROM `quote_id_mask`;
DELETE FROM `quote_item`;
DELETE FROM `quote_item_option`;
DELETE FROM `quote_payment`;
DELETE FROM `quote_shipping_rate`;
DELETE FROM `wishlist`;
DELETE FROM `wishlist_item`;
DELETE FROM `wishlist_item_option`;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `sendfriend_log`;
TRUNCATE TABLE `report_compared_product_index`;
TRUNCATE TABLE `report_event`;
TRUNCATE TABLE `report_viewed_product_aggregated_daily`;
TRUNCATE TABLE `report_viewed_product_aggregated_monthly`;
TRUNCATE TABLE `report_viewed_product_aggregated_yearly`;
TRUNCATE TABLE `report_viewed_product_index`;
TRUNCATE TABLE `sales_bestsellers_aggregated_daily`;
TRUNCATE TABLE `sales_bestsellers_aggregated_monthly`;
TRUNCATE TABLE `sales_bestsellers_aggregated_yearly`;
TRUNCATE TABLE `sales_creditmemo`;
TRUNCATE TABLE `sales_creditmemo_comment`;
TRUNCATE TABLE `sales_creditmemo_grid`;
TRUNCATE TABLE `sales_creditmemo_item`;
TRUNCATE TABLE `sales_invoice`;
TRUNCATE TABLE `sales_invoiced_aggregated`;
TRUNCATE TABLE `sales_invoiced_aggregated_order`;
TRUNCATE TABLE `sales_invoice_comment`;
TRUNCATE TABLE `sales_invoice_grid`;
TRUNCATE TABLE `sales_invoice_item`;
TRUNCATE TABLE `sales_order`;
TRUNCATE TABLE `sales_order_address`;
TRUNCATE TABLE `sales_order_aggregated_created`;
TRUNCATE TABLE `sales_order_aggregated_updated`;
TRUNCATE TABLE `sales_order_grid`;
TRUNCATE TABLE `sales_order_item`;
TRUNCATE TABLE `sales_order_payment`;
TRUNCATE TABLE `sales_order_status_history`;
TRUNCATE TABLE `sales_order_tax`;
TRUNCATE TABLE `sales_order_tax_item`;
TRUNCATE TABLE `sales_payment_transaction`;
TRUNCATE TABLE `sales_refunded_aggregated`;
TRUNCATE TABLE `sales_refunded_aggregated_order`;
TRUNCATE TABLE `sales_shipment`;
TRUNCATE TABLE `sales_shipment_comment`;
TRUNCATE TABLE `sales_shipment_grid`;
TRUNCATE TABLE `sales_shipment_item`;
TRUNCATE TABLE `sales_shipment_track`;
TRUNCATE TABLE `sales_shipping_aggregated`;
TRUNCATE TABLE `sales_shipping_aggregated_order`;
TRUNCATE TABLE `quote`;
TRUNCATE TABLE `quote_address`;
TRUNCATE TABLE `quote_address_item`;
TRUNCATE TABLE `quote_id_mask`;
TRUNCATE TABLE `quote_item`;
TRUNCATE TABLE `quote_item_option`;
TRUNCATE TABLE `quote_payment`;
TRUNCATE TABLE `quote_shipping_rate`;
TRUNCATE TABLE `wishlist`;
TRUNCATE TABLE `wishlist_item`;
TRUNCATE TABLE `wishlist_item_option`;

# Reset indexes (if you want your orders number start back to 1)
TRUNCATE TABLE `sequence_invoice_1`;
TRUNCATE TABLE `sequence_order_1`;
TRUNCATE TABLE `sequence_shipment_1`;
TRUNCATE TABLE `sequence_creditmemo_1`;

SET FOREIGN_KEY_CHECKS = 1;

##########################################################
# SEARCH RESULTS
##########################################################
DELETE FROM `search_query`;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `search_query`;
SET FOREIGN_KEY_CHECKS = 1;

##########################################################
# COUNTERS
##########################################################
TRUNCATE `eav_entity_store`;
@hvanmegen
hvanmegen commented on Feb 21
ah.. the old Magento 2 speed optimizer.. fabulous

@shreyas-dh
shreyas-dh commented on May 7
tested successfully on 2.3.5

@cgartner-redstage
cgartner-redstage commented on Jun 22
@sjovanig

Please add these two tables for the product section:

DELETE FROM catalog_product_entity_media_gallery_value_to_entity;
DELETE FROM catalog_product_entity_media_gallery_value_video;

Thank you by the script 👏