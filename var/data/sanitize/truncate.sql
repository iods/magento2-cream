Magento 2 - anonymize db
magento-2-anonymize-db.sql
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
show-table-sizes.sql
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
truncate-data.sql
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