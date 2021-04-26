--
-- Anonymise Magento database
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

UPDATE `admin_user` SET
  `firstname` = CONCAT('Firstname-', `user_id`),
  `lastname` = CONCAT('Lastname-', `user_id`),
  `email` = CONCAT('admin-', `user_id`, '@test.com'),
  `username` = CONCAT('username-', `user_id`);

UPDATE `customer_entity` SET
  `email` = CONCAT('email-', `entity_id`, '@test.com');

UPDATE `sales_flat_order` SET
  `customer_firstname` = CONCAT('Firstname-', `customer_id`),
  `customer_middlename` = CONCAT('Middlename-', `customer_id`),
  `customer_lastname` = CONCAT('Lastname-', `customer_id`),
  `customer_email` = CONCAT('email-', `customer_id`, '@test.com');

UPDATE `sales_flat_order_address` SET
  `firstname` = CONCAT('Firstname-', `customer_id`),
  `middlename` = CONCAT('Middlename-', `customer_id`),
  `lastname` = CONCAT('Lastname-', `customer_id`),
  `email` = CONCAT('admin-', `customer_id`, '@lci1dev.com');

UPDATE `sales_flat_quote` SET
  `customer_firstname` = CONCAT('Firstname-', `customer_id`),
  `customer_middlename` = CONCAT('Middlename-', `customer_id`),
  `customer_lastname` = CONCAT('Lastname-', `customer_id`),
  `customer_email` = CONCAT('email-', `customer_id`, '@test.com');

UPDATE `sales_flat_quote_address` SET
  `firstname` = CONCAT('Firstname-', `customer_id`),
  `middlename` = CONCAT('Middlename-', `customer_id`),
  `lastname` = CONCAT('Lastname-', `customer_id`),
  `email` = CONCAT('admin-', `customer_id`, '@test.com');

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
UNLOCK TABLES;
