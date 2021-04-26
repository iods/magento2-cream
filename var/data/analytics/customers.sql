
-- Create test customers across the database

/*
Run the following query to get a set of queries that will purge all tables of email addresses. The queries that are output from
this should be manually reviewed to remove queries for any unnecessary tables and can then be run manually or via a Magerun "db:query"
to include it as a part of a scripted cloning process.
IMPORTANT: Make sure to update the @db_name variable
What the resulting query will do:
-- Replace the emails in Magento with dummy emails (unless email is one of the whitelisted domains) in order to prevent emails erroneously being sent to  customers.
-- Make all emails with @example.com and use and MD5 of the original domain of the email as the tag for the email. This is important in case we have two emails with the
-- same "local part" but different "domain part". For example, bob.smith@yahoo.com would become bob.smith+c9d12f@example.com
Credit to ericthehacker for the bulk of this script.
*/

SET @db_name = 'example_dev';
SET @whitelist_domain_1 = 'krakencommerce.com';
-- If you don't want to replace email addresses for the merchant, enter their domain here
SET @whitelist_domain_2 = 'merchantdomain.com';

USE information_schema;
SET SESSION group_concat_max_len=10000000;
SELECT
	group_concat(
		concat('UPDATE `',`table_name`,'` SET `',`column_name`,'` = REPLACE(`',`column_name`,'`, SUBSTRING(`',`column_name`,'`, LOCATE("@", `',`column_name`,'`)), CONCAT("+", SUBSTRING(MD5(SUBSTRING(`',`column_name`,'`, LOCATE("@", `',`column_name`,'`))) FROM 1 FOR 6), "@example.com")) WHERE `',`column_name`,'` NOT LIKE "%@', @whitelist_domain_1, '" ', 'AND `', `column_name`, '` NOT LIKE "%@', @whitelist_domain_2, '";', "\n") SEPARATOR '') AS q
FROM `columns` AS c
WHERE table_schema = @db_name
AND `column_name`
LIKE
    '%email%'
    AND `data_type` IN ('varchar', 'text');

/* Update the entity table */
UPDATE table
   SET asdf
   asdasd
WHERE

-- Update Order increment id to start at 123456789
UPDATE `eav_entity_store` SET `increment_last_id` = '123456789' WHERE `entity_type_id` = '5';`
-- Update Invoice increment id to start at 123456789
UPDATE `eav_entity_store` SET `increment_last_id` = '123456789' WHERE `entity_type_id` = '6';
-- Update Credit Memo increment id to start at 123456789
UPDATE `eav_entity_store` SET `increment_last_id` = '123456789' WHERE `entity_type_id` = '7';
-- Update Shipment increment id to start at 123456789
UPDATE `eav_entity_store` SET `increment_last_id` = '123456789' WHERE `entity_type_id` = '8';
update_order_numbers_2.sql
-- Update Order increment id to start at 012345678
UPDATE `eav_entity_store` SET `increment_last_id` = '012345678', `increment_prefix` = '0' WHERE `entity_type_id` = '5';

-- Update Invoice increment id to start at 012345678
UPDATE `eav_entity_store` SET `increment_last_id` = '012345678', `increment_prefix` = '0' WHERE `entity_type_id` = '6';

-- Update Credit Memo increment id to start at 012345678
UPDATE `eav_entity_store` SET `increment_last_id` = '012345678', `increment_prefix` = '0' WHERE `entity_type_id` = '7';

-- Update Shipment increment id to start at 012345678
UPDATE `eav_entity_store` SET `increment_last_id` = '012345678', `increment_prefix` = '0' WHERE `entity_type_id` = '8';


-- Thanks to
-- https://magento.stackexchange.com/questions/137555/magento-2-how-to-reset-customer-password-from-database#answer-167821

UPDATE `customer_entity`
SET `password_hash` = CONCAT(SHA2('xxxxxxxxYOURPASSWORD', 256), ':xxxxxxxx:1')
WHERE `entity_id` = 1;

-- mladen@stuntcoders.com -> mladen@example.com
UPDATE `customer_entity` SET `email` = REPLACE(`email`, SUBSTRING(`email`, INSTR(`email`, '@') + 1), 'example.com');
UPDATE `sales_flat_quote_address` SET `email` = REPLACE(`email`, SUBSTRING(`email`, INSTR(`email`, '@') + 1), 'example.com');
UPDATE `sales_flat_order_address` SET `email` = REPLACE(`email`, SUBSTRING(`email`, INSTR(`email`, '@') + 1), 'example.com');