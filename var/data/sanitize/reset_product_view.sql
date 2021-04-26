DELETE FROM `catalog_product_entity_datetime` where store_id in (VIEW_ID);
DELETE FROM `catalog_product_entity_decimal` where store_id in (VIEW_ID);
DELETE FROM `catalog_product_entity_gallery` where store_id in (VIEW_ID);
DELETE FROM `catalog_product_entity_int` where store_id in (VIEW_ID);
DELETE FROM `catalog_product_entity_media_gallery_value` where store_id in (VIEW_ID);
DELETE FROM `catalog_product_entity_text` where store_id in (VIEW_ID);
DELETE FROM `catalog_product_entity_varchar` where store_id in (VIEW_ID);

Magento 2 : Reset all products data and use the default config value #magento2 #sql #mysql
reset_all_products.sql
DELETE FROM `catalog_product_entity_text` where store_id <> 0;
DELETE FROM `catalog_product_entity_datetime` where store_id <> 0;
DELETE FROM `catalog_product_entity_decimal` where store_id <> 0;
DELETE FROM `catalog_product_entity_int` where store_id <> 0;
DELETE FROM `catalog_product_entity_varchar` where store_id <> 0;