Magento: Different SQL Queries to truncate tables, create anonymous, test customers out of your existing and round all prices to get rid of the decimals.
createTestCustomers.sql
UPDATE `customer_entity`
SET `email` = concat('test+', entity_id, '@aGmailDomain.com');

UPDATE `customer_entity_varchar`
SET `value` = CONCAT(MD5(concat('qXpassword', entity_id)), ':qX')
WHERE `attribute_id` = 12;

UPDATE `sales_flat_order`
SET customer_email = concat('test+', IFNULL(customer_id, entity_id), '@aGmailDomain.com');

UPDATE `sales_flat_quote`
SET customer_email = concat('test+', IFNULL(customer_id, entity_id), '@aGmailDomain.com');
roundAllPrices.sql
UPDATE `catalog_product_entity_decimal`
SET `value` = round(`value`)
WHERE
  `value` IS NOT NULL AND
  `attribute_id` IN (SELECT
                       `attribute_id`
                     FROM `eav_attribute`
                     WHERE `entity_type_id` = 4 AND `attribute_code` LIKE '%price%' AND `backend_type` = 'decimal');

SET foreign_key_checks = 0;
TRUNCATE `catalog_product_index_price`;
TRUNCATE `catalog_product_index_price_bundle_idx`;
TRUNCATE `catalog_product_index_price_bundle_opt_idx`;
TRUNCATE `catalog_product_index_price_bundle_sel_idx`;
TRUNCATE `catalog_product_index_price_cfg_opt_agr_idx`;
TRUNCATE `catalog_product_index_price_cfg_opt_idx`;
TRUNCATE `catalog_product_index_price_downlod_idx`;
TRUNCATE `catalog_product_index_price_final_idx`;
TRUNCATE `catalog_product_index_price_idx`;
TRUNCATE `catalog_product_index_price_opt_agr_idx`;
TRUNCATE `catalog_product_index_price_opt_idx`;
TRUNCATE `catalog_product_index_price_tmp`;
TRUNCATE `catalog_product_index_tier_price`;
SET foreign_key_checks = 1;

-- run reindex prices
truncateCustomerSales.sql
SET foreign_key_checks = 0;
TRUNCATE log_quote;
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
TRUNCATE `index_event`;
TRUNCATE `index_process_event`;
TRUNCATE `log_quote`;
TRUNCATE `sales_bestsellers_aggregated_daily`;
TRUNCATE `sales_bestsellers_aggregated_monthly`;
TRUNCATE `sales_bestsellers_aggregated_yearly`;
TRUNCATE `sales_flat_creditmemo`;
TRUNCATE `sales_flat_creditmemo_comment`;
TRUNCATE `sales_flat_creditmemo_grid`;
TRUNCATE `sales_flat_creditmemo_item`;
TRUNCATE `sales_flat_invoice`;
TRUNCATE `sales_flat_invoice_comment`;
TRUNCATE `sales_flat_invoice_grid`;
TRUNCATE `sales_flat_invoice_item`;
TRUNCATE `sales_flat_order`;
TRUNCATE `sales_flat_order_address`;
TRUNCATE `sales_flat_order_grid`;
TRUNCATE `sales_flat_order_item`;
TRUNCATE `sales_flat_order_payment`;
TRUNCATE `sales_flat_order_status_history`;
TRUNCATE `sales_flat_quote`;
TRUNCATE `sales_flat_quote_address`;
TRUNCATE `sales_flat_quote_address_item`;
TRUNCATE `sales_flat_quote_item`;
TRUNCATE `sales_flat_quote_item_option`;
TRUNCATE `sales_flat_quote_payment`;
TRUNCATE `sales_flat_quote_shipping_rate`;
TRUNCATE `sales_flat_shipment`;
TRUNCATE `sales_flat_shipment_comment`;
TRUNCATE `sales_flat_shipment_grid`;
TRUNCATE `sales_flat_shipment_item`;
TRUNCATE `sales_flat_shipment_track`;
TRUNCATE `sales_invoiced_aggregated`;
TRUNCATE `sales_invoiced_aggregated_order`;
TRUNCATE `sales_order_aggregated_created`;
TRUNCATE `sales_order_aggregated_updated`;
TRUNCATE `sales_order_tax`;
TRUNCATE `sales_order_tax_item`;
TRUNCATE `sales_payment_transaction`;
TRUNCATE `sales_refunded_aggregated`;
TRUNCATE `sales_refunded_aggregated_order`;
TRUNCATE `sales_shipping_aggregated`;
TRUNCATE `sales_shipping_aggregated_order`;
SET foreign_key_checks = 1;
truncateLogs.sql
SET foreign_key_checks = 0;
TRUNCATE core_cache;
TRUNCATE core_cache_option;
TRUNCATE core_cache_tag;
TRUNCATE core_session;
TRUNCATE log_customer;
TRUNCATE log_quote;
TRUNCATE log_summary;
TRUNCATE log_summary_type;
TRUNCATE log_url;
TRUNCATE log_url_info;
TRUNCATE log_visitor;
TRUNCATE log_visitor_info;
TRUNCATE log_visitor_online;
TRUNCATE index_process_event;
TRUNCATE report_event;
TRUNCATE report_viewed_product_index;
TRUNCATE dataflow_batch_export;
TRUNCATE dataflow_batch_import;
SET foreign_key_checks = 1;
truncateProducts.sql
SET foreign_key_checks = 0;
TRUNCATE `catalogsearch_query`;
TRUNCATE `catalog_category_entity`;
TRUNCATE `catalog_category_entity_int`;
TRUNCATE `catalog_category_entity_text`;
TRUNCATE `catalog_category_entity_varchar`;
TRUNCATE `catalog_category_product`;
TRUNCATE `catalog_category_product_index`;
TRUNCATE `catalog_product_entity`;
TRUNCATE `catalog_product_entity_datetime`;
TRUNCATE `catalog_product_entity_int`;
TRUNCATE `catalog_product_entity_decimal`;
TRUNCATE `catalog_product_entity_media_gallery`;
TRUNCATE `catalog_product_entity_media_gallery_value`;
TRUNCATE `catalog_product_entity_text`;
TRUNCATE `catalog_product_entity_varchar`;
TRUNCATE `catalog_product_index_eav`;
TRUNCATE `catalog_product_index_eav_idx`;
TRUNCATE `catalog_product_index_price`;
TRUNCATE `catalog_product_index_price_idx`;
TRUNCATE `catalog_product_link`;
TRUNCATE `catalog_product_link_attribute_int`;
TRUNCATE `catalog_product_relation`;
TRUNCATE `catalog_product_super_attribute`;
TRUNCATE `catalog_product_super_attribute_label`;
TRUNCATE `catalog_product_super_link`;
TRUNCATE `catalog_product_website`;
TRUNCATE `core_session`;
TRUNCATE `core_url_rewrite`;
TRUNCATE `newsletter_queue`;
TRUNCATE `newsletter_queue_link`;
TRUNCATE `newsletter_queue_store_link`;
TRUNCATE `newsletter_subscriber`;
TRUNCATE `product_alert_stock`;
TRUNCATE `salesrule`;
TRUNCATE `salesrule_coupon`;
TRUNCATE `salesrule_coupon_usage`;
TRUNCATE `salesrule_customer`;
TRUNCATE `salesrule_customer_group`;
TRUNCATE `salesrule_label`;
TRUNCATE `salesrule_product_attribute`;
TRUNCATE `salesrule_website`;
TRUNCATE `tax_order_aggregated_created`;
TRUNCATE `tax_order_aggregated_updated`;
TRUNCATE `wishlist`;
SET foreign_key_checks = 1;
@iods
