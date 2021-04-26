mysqldump Magento catalog_category_entity catalog_category_entity_datetime catalog_category_entity_decimal catalog_category_entity_int catalog_category_entity_text catalog_category_entity_url_key catalog_category_entity_varchar catalog_category_product catalog_category_product_index catalog_eav_attribute catalog_product_enabled_index catalog_product_entity catalog_product_entity_datetime catalog_product_entity_decimal catalog_product_entity_gallery catalog_product_entity_group_price catalog_product_entity_int catalog_product_entity_media_gallery catalog_product_entity_media_gallery_value catalog_product_entity_text catalog_product_entity_tier_price catalog_product_entity_url_key catalog_product_entity_varchar catalog_product_index_eav catalog_product_index_eav_decimal catalog_product_index_group_price catalog_product_index_price catalog_product_index_tier_price catalog_product_index_website catalog_product_link catalog_product_link_attribute catalog_product_link_attribute_decimal catalog_product_link_attribute_int catalog_product_link_attribute_varchar catalog_product_link_type catalog_product_option catalog_product_option_price catalog_product_option_title catalog_product_option_type_price catalog_product_option_type_title catalog_product_option_type_value catalog_product_relation catalog_product_website catalogindex_price core_url_rewrite eav_attribute eav_attribute_group eav_attribute_label eav_attribute_option eav_attribute_option_value eav_attribute_set eav_entity eav_entity_attribute eav_entity_datetime eav_entity_decimal eav_entity_int eav_entity_store eav_entity_text eav_entity_type eav_entity_varchar enterprise_catalog_category_rewrite enterprise_catalog_product_rewrite enterprise_url_rewrite enterprise_url_rewrite_redirect enterprise_url_rewrite_redirect_rewrite t_categories t_products | gzip > dump-catalog.sql.gz

Export Magento catalog tables from database

-- Admin emails
UPDATE admin_user AS tb SET tb.email = CONCAT('customer', tb.user_id, '@mailinator.com');

-- Customers
UPDATE customer_entity AS tb SET tb.email = CONCAT('customer', tb.entity_id, '@mailinator.com');

-- Customers Grid
UPDATE customer_grid_flat AS tb SET tb.email = CONCAT('customer', tb.entity_id, '@mailinator.com');

-- Newsletter Subscribers
UPDATE newsletter_subscriber AS tb SET tb.subscriber_email = REPLACE (tb.subscriber_email,(SUBSTRING_INDEX(SUBSTR(tb.subscriber_email, INSTR(tb.subscriber_email, '@') + 1),'.',5)), 'mailinator.com');

-- Sales Flat Orders
UPDATE sales_order AS tb SET tb.customer_email = REPLACE (tb.customer_email,(SUBSTRING_INDEX(SUBSTR(tb.customer_email, INSTR(tb.customer_email, '@') + 1),'.',5)), 'mailinator.com');

-- Sales Flat Orders Address
UPDATE sales_order_address AS tb SET tb.email = REPLACE (tb.email,(SUBSTRING_INDEX(SUBSTR(tb.email, INSTR(tb.email, '@') + 1),'.',5)), 'mailinator.com');

# Sales Flat Quotes
UPDATE quote AS tb SET tb.customer_email = REPLACE (tb.customer_email,(SUBSTRING_INDEX(SUBSTR(tb.customer_email, INSTR(tb.customer_email, '@') + 1),'.',5)), 'mailinator.com');

-- Remove track, static and log data
TRUNCATE `customer_visitor`;
TRUNCATE `customer_log`;

-- https://stackoverflow.com/a/46143816
-- replace "magento" with your database name
SELECT
  TABLE_NAME AS `Table`,
  ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024),2) AS `Size (MB)`
FROM
  information_schema.TABLES
WHERE
  TABLE_SCHEMA = "magento"
ORDER BY
  (DATA_LENGTH + INDEX_LENGTH)
DESC;


-- remove useless data for local environment
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE `quote`;
TRUNCATE `quote_address`;
TRUNCATE `quote_address_item`;
TRUNCATE `quote_id_mask`;
TRUNCATE `quote_item`;
TRUNCATE `quote_item_option`;
TRUNCATE `quote_payment`;
TRUNCATE `quote_preview`;
TRUNCATE `quote_shipping_rate`;
SET FOREIGN_KEY_CHECKS = 1;
