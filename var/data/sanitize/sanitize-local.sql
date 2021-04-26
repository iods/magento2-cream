

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



-- Compare
TRUNCATE `catalog_compare_item`;

-- Wishlist
TRUNCATE `wishlist_item_option`;
TRUNCATE `wishlist_item`;
TRUNCATE `wishlist`;

-- Admin notification
TRUNCATE `adminnotification_inbox`;

-- Dataflow
TRUNCATE `dataflow_batch_export`;
TRUNCATE `dataflow_batch_import`;

-- Report
TRUNCATE `report_event`;
TRUNCATE `report_viewed_product_index`;
TRUNCATE `report_compared_product_index`;

-- Search
TRUNCATE `catalogsearch_fulltext`;
TRUNCATE `catalogsearch_query`;
TRUNCATE `catalogsearch_recommendations`;
TRUNCATE `catalogsearch_result`;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
UNLOCK TABLES;
clean-magento_ce-db.sql
--
-- Magento CE database clean-up
--
-- This will clean tables of junk and unnecessary stuff.
-- A full reindex is needed in Magento after cleaning up.
--
-- @author      Constantin Bejenaru <boby@frozenminds.com>
-- @copyright   Copyright (c) Constantin Bejenaru (http://frozenminds.com/)
-- @license     http://www.opensource.org/licenses/mit-license.html  MIT License
--

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



-- FLAT CATALOG (EDIT TABLE NAMES)
TRUNCATE `catalog_category_flat_store_1`;
TRUNCATE `catalog_category_flat_store_2`;

TRUNCATE `catalog_product_flat_1`;
TRUNCATE `catalog_product_flat_2`;


-- DO NOT EDIT BELOW, UNLESS YOU KNOW WHAT YOU ARE DOING

-- Logs
TRUNCATE `log_customer`;
TRUNCATE `log_quote`;
TRUNCATE `log_summary`;
TRUNCATE `log_summary_type`;
TRUNCATE `log_url`;
TRUNCATE `log_url_info`;
TRUNCATE `log_visitor`;
TRUNCATE `log_visitor_info`;
TRUNCATE `log_visitor_online`;

-- Session
TRUNCATE `core_session`;
TRUNCATE `api_session`;

-- Cache
TRUNCATE `core_cache`;
TRUNCATE `core_cache_option`;
TRUNCATE `core_cache_tag`;

-- Index
TRUNCATE `index_event`;
TRUNCATE `index_process_event`;

-- Captcha
TRUNCATE `captcha_log`;

-- Sent to friend
TRUNCATE `sendfriend_log`;

-- Temp and index tables
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



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
UNLOCK TABLES;
clean-magento_ee-db.sql
--
-- Magento EE database clean-up
--
-- @author      Constantin Bejenaru <boby@frozenminds.com>
-- @copyright   Copyright (c) Constantin Bejenaru (http://frozenminds.com/)
-- @license     http://www.opensource.org/licenses/mit-license.html  MIT License
--

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
/*!40014 SET @OLD_SQL_SAFE_UPDATES=@@SQL_SAFE_UPDATES, SQL_SAFE_UPDATES=0 */;



-- Logging
TRUNCATE `enterprise_logging_event`;
TRUNCATE `enterprise_logging_event_changes`;

-- Changelog
TRUNCATE `enterprise_url_rewrite_redirect_cl`;
TRUNCATE `cataloginventory_stock_status_cl`;
TRUNCATE `catalogsearch_fulltext_cl`;
TRUNCATE `enterprise_url_rewrite_category_cl`;
TRUNCATE `enterprise_url_rewrite_product_cl`;
TRUNCATE `catalog_category_product_index_cl`;
TRUNCATE `catalog_category_product_cat_cl`;
TRUNCATE `catalog_product_index_price_cl`;
TRUNCATE `catalog_category_flat_cl`;
TRUNCATE `catalog_product_flat_cl`;

-- Metadata (reset changelog version and set status as invalid)
UPDATE `enterprise_mview_metadata` SET `version_id` = 0, `status` = 2;



/*!40111 SET SQL_SAFE_UPDATES=@OLD_SQL_SAFE_UPDATES */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
UNLOCK TABLES;
@projumper
projumper commented on Mar 27, 2017
as i used this, i added this line:

set foreign_key_checks=0;

to the snippet ;)

THX
