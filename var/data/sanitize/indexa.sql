-- Forcefully fixes most Magento SQL issues...
-- Truncates all old indexes, flat data, & logs
-- DF Supply, Inc.
-- SMOORE 2/17/2016

-- BACK UP DATABASE PRIOR!!!!!

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

TRUNCATE `catalog_compare_item`;
TRUNCATE `wishlist_item_option`;
TRUNCATE `wishlist_item`;
TRUNCATE `wishlist`;
TRUNCATE `adminnotification_inbox`;
TRUNCATE `dataflow_batch_export`;
TRUNCATE `dataflow_batch_import`;
TRUNCATE `report_event`;
TRUNCATE `report_viewed_product_index`;
TRUNCATE `report_compared_product_index`;
TRUNCATE `catalogsearch_fulltext`;
TRUNCATE `catalogsearch_query`;
-- Most of our sites do not have recommendations. if they do, reenable.
-- TRUNCATE `catalogsearch_recommendations`;
TRUNCATE `catalogsearch_result`;


TRUNCATE `catalog_category_flat_store_1`; -- default
TRUNCATE `catalog_category_flat_store_2`; -- mobile
TRUNCATE `catalog_category_flat_store_3`; -- dev
TRUNCATE `catalog_product_flat_1`;-- default
TRUNCATE `catalog_product_flat_2`;-- mobile
TRUNCATE `catalog_product_flat_3`;-- dev

TRUNCATE `log_customer`;
TRUNCATE `log_quote`;
TRUNCATE `log_summary`;
TRUNCATE `log_summary_type`;
TRUNCATE `log_url`;
TRUNCATE `log_url_info`;
TRUNCATE `log_visitor`;
TRUNCATE `log_visitor_info`;
TRUNCATE `log_visitor_online`;
TRUNCATE `core_session`;
TRUNCATE `api_session`;
TRUNCATE `core_cache`;
TRUNCATE `core_cache_option`;
TRUNCATE `core_cache_tag`;
TRUNCATE `index_event`;
TRUNCATE `index_process_event`;
TRUNCATE `captcha_log`;
TRUNCATE `sendfriend_log`;
TRUNCATE `catalog_category_anc_categs_index_tmp`;
TRUNCATE `catalog_category_anc_products_index_tmp`;
TRUNCATE `catalog_category_product_index_enbl_tmp`;
TRUNCATE `catalog_product_index_eav_decimal_tmp`;
TRUNCATE `catalog_product_index_eav_tmp`;
TRUNCATE `catalog_product_index_price_bundle_opt_tmp`;
TRUNCATE `catalog_product_index_price_bundle_sel_tmp`;
TRUNCATE `catalog_product_index_price_bundle_tmp`;
TRUNCATE `catalog_product_index_price_cfg_opt_agr_tmp`;
TRUNCATE `catalog_product_index_price_cfg_opt_tmp`;
TRUNCATE `catalog_product_index_price_downlod_tmp`;
TRUNCATE `catalog_product_index_price_final_tmp`;
TRUNCATE `catalog_product_index_price_opt_agr_tmp`;
TRUNCATE `catalog_product_index_price_opt_tmp`;
TRUNCATE `catalog_product_index_price_tmp`;
TRUNCATE `cataloginventory_stock_status_tmp`;
TRUNCATE `catalog_category_anc_categs_index_idx`;
TRUNCATE `catalog_category_anc_products_index_idx`;
TRUNCATE `catalog_category_product_index_enbl_idx`;
TRUNCATE `catalog_category_product_index_idx`;
TRUNCATE `catalog_product_index_eav_decimal_idx`;
TRUNCATE `catalog_product_index_eav_idx`;
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
TRUNCATE `cataloginventory_stock_status_idx`;

-- remove all overridden attributes for individual store views.
DELETE FROM `catalog_product_entity_text` where store_id != 0;
DELETE FROM `catalog_product_entity_datetime` where store_id != 0;
DELETE FROM `catalog_product_entity_decimal` where store_id != 0;
DELETE FROM `catalog_product_entity_int` where store_id != 0;
DELETE FROM `catalog_product_entity_varchar` where store_id != 0;

-- If still having issues with attribute indexer, uncomment the following..
-- TRUNCATE `catalog_product_index_eav`;

-- turn foreigncheck back on & remove table lock
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
UNLOCK TABLES;