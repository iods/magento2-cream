########################################################################################################################

CREATE FUNCTION SANITIZE_EMAIL (email VARCHAR(255))
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN CONCAT(MD5(SUBSTRING(email, 1, LOCATE('@', email) - 1)), LEFT(UUID(), 4), '@example.com');

CREATE FUNCTION GET_RANDOM_FIRSTNAME ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN ELT(FLOOR(1 + RAND() * 25), 'John', 'Sheldon', 'Lindy', 'Joanna', 'Eric', 'Noah', 'Emma', 'Liam', 'Olivia', 'William', 'Ava', 'Mason', 'Sophia', 'James', 'Isabella', 'Benjamin', 'Mia', 'Jacob', 'Charlotte', 'Michael', 'Abigail', 'Elijah', 'Emily', 'Ethan', 'Harper');

CREATE FUNCTION GET_RANDOM_LASTNAME ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN ELT(FLOOR(1 + RAND() * 25), 'Smith', 'Doe', 'Kartman', 'Stark', 'Cooper', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilson', 'Martinez', 'Anderson', 'Taylor', 'Thomas', 'Thomas', 'Moore', 'Martin', 'Jackson', 'Thompson', 'White', 'Lopez');

CREATE FUNCTION GET_RANDOM_STREET ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN ELT(FLOOR(1 + RAND() * 5), '12345 Some Fake Street', '2222 Pretty Ave', '515 Random St. Apt 13', '777 Lucky Rd #8', 'PO BOX 12345');

CREATE FUNCTION GET_CITY ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN 'Calabasas';

CREATE FUNCTION GET_REGION ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN 'California';

CREATE FUNCTION GET_RANDOM_ZIP ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN ELT(FLOOR(1 + RAND() * 4), '90290', '91301', '91302', '91372');

CREATE FUNCTION GET_RANDOM_PHONE_NUMBER ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN ELT(FLOOR(1 + RAND() * 4), '4544544544', '1234567890', '0987654321', '8181110000');

CREATE FUNCTION GET_RANDOM_COMPANY ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN ELT(FLOOR(1 + RAND() * 4), 'Fake Company', 'Dummy Inc.', 'Test LLC', 'Web Corp');

CREATE FUNCTION GET_RANDOM_CC_LAST_4 ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN FLOOR(1000 + RAND() * 8888);

CREATE FUNCTION GET_RANDOM_CC_EXPIRATION_YEAR ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN FLOOR(2017 + RAND() * 20);

CREATE FUNCTION GET_RANDOM_TRACKING_NUMBER ()
  RETURNS VARCHAR (255) DETERMINISTIC
  RETURN CONCAT(FLOOR(100000 + RAND() * 888888), FLOOR(100000 + RAND() * 888888), FLOOR(100000 + RAND() * 888888), FLOOR(1000 + RAND() * 8888));

########################################################################################################################

UPDATE `sales_flat_order` SET
  `customer_email` = SANITIZE_EMAIL(`customer_email`),
  `customer_firstname` = GET_RANDOM_FIRSTNAME(),
  `customer_lastname` = GET_RANDOM_LASTNAME();

UPDATE `sales_flat_order_address` SET
  `email`     = SANITIZE_EMAIL(`email`),
  `firstname` = GET_RANDOM_FIRSTNAME(),
  `lastname`  = GET_RANDOM_LASTNAME(),
  `street`    = GET_RANDOM_STREET(),
  `city`      = GET_CITY(),
  `region`    = GET_REGION(),
  `postcode`  = GET_RANDOM_ZIP(),
  `telephone` = GET_RANDOM_PHONE_NUMBER();

UPDATE `sales_flat_order_payment` SET
  `cc_last4`    = GET_RANDOM_CC_LAST_4(),
  `cc_owner`    = CONCAT(GET_RANDOM_FIRSTNAME(), " ", GET_RANDOM_LASTNAME()),
  `cc_exp_year` = GET_RANDOM_CC_EXPIRATION_YEAR();

UPDATE `sales_flat_quote_payment` SET
  `cc_last4`    = GET_RANDOM_CC_LAST_4(),
  `cc_owner`    = CONCAT(GET_RANDOM_FIRSTNAME(), " ", GET_RANDOM_LASTNAME()),
  `cc_exp_year` = GET_RANDOM_CC_EXPIRATION_YEAR();

UPDATE `sales_flat_shipment_track` SET `track_number` = GET_RANDOM_TRACKING_NUMBER();

UPDATE `sales_flat_order_grid` SET `shipping_name` = CONCAT(GET_RANDOM_FIRSTNAME(), " ", GET_RANDOM_LASTNAME()), `billing_name` = `shipping_name`;
UPDATE `sales_flat_shipment_grid` SET shipping_name = CONCAT(GET_RANDOM_FIRSTNAME(), " ", GET_RANDOM_LASTNAME());

UPDATE `enterprise_sales_order_grid_archive` SET `shipping_name` = CONCAT(GET_RANDOM_FIRSTNAME(), " ", GET_RANDOM_LASTNAME()), `billing_name` = `shipping_name`;
UPDATE `enterprise_sales_shipment_grid_archive` SET shipping_name = CONCAT(GET_RANDOM_FIRSTNAME(), " ", GET_RANDOM_LASTNAME());

########################################################################################################################

UPDATE `admin_user` SET
  `firstname` = GET_RANDOM_FIRSTNAME(),
  `lastname`  = GET_RANDOM_LASTNAME(),
  `email`     = SANITIZE_EMAIL(`email`);

UPDATE `api_user` SET
  `firstname` = GET_RANDOM_FIRSTNAME(),
  `lastname`  = GET_RANDOM_LASTNAME(),
  `email`     = SANITIZE_EMAIL(`email`);

########################################################################################################################

SELECT `entity_type_id` FROM `eav_entity_type` WHERE `entity_type_code` = 'customer' INTO @customer_entity_type_id;
SELECT `entity_type_id` FROM `eav_entity_type` WHERE `entity_type_code` = 'customer_address' INTO @customer_address_entity_type_id;

UPDATE `customer_entity` SET `email` = SANITIZE_EMAIL(`email`);

UPDATE `customer_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_RANDOM_FIRSTNAME() WHERE `ea`.`attribute_code` = 'firstname' AND `t1`.`entity_type_id` = @customer_entity_type_id;

UPDATE `customer_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_RANDOM_LASTNAME() WHERE `ea`.`attribute_code` = 'lastname' AND `t1`.`entity_type_id` = @customer_entity_type_id;

UPDATE `customer_address_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_RANDOM_FIRSTNAME() WHERE `ea`.`attribute_code` = 'firstname' AND `t1`.`entity_type_id` = @customer_address_entity_type_id;

UPDATE `customer_address_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_RANDOM_LASTNAME() WHERE `ea`.`attribute_code` = 'lastname' AND `t1`.`entity_type_id` = @customer_address_entity_type_id;

UPDATE `customer_address_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_RANDOM_COMPANY() WHERE `ea`.`attribute_code` = 'company' AND `t1`.`entity_type_id` = @customer_address_entity_type_id;

UPDATE `customer_address_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_RANDOM_STREET() WHERE `ea`.`attribute_code` = 'street' AND `t1`.`entity_type_id` = @customer_address_entity_type_id;

UPDATE `customer_address_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_CITY() WHERE `ea`.`attribute_code` = 'city' AND `t1`.`entity_type_id` = @customer_address_entity_type_id;

UPDATE `customer_address_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_REGION() WHERE `ea`.`attribute_code` = 'region' AND `t1`.`entity_type_id` = @customer_address_entity_type_id;

UPDATE `customer_address_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_RANDOM_ZIP() WHERE `ea`.`attribute_code` = 'postcode' AND `t1`.`entity_type_id` = @customer_address_entity_type_id;

UPDATE `customer_address_entity_varchar` AS `t1`
  LEFT JOIN `eav_attribute` AS `ea` ON `t1`.`attribute_id` = `ea`.`attribute_id`
  SET `t1`.`value` = GET_RANDOM_PHONE_NUMBER() WHERE `ea`.`attribute_code` = 'telephone' AND `t1`.`entity_type_id` = @customer_address_entity_type_id;

########################################################################################################################

DROP FUNCTION SANITIZE_EMAIL;
DROP FUNCTION GET_RANDOM_FIRSTNAME;
DROP FUNCTION GET_RANDOM_LASTNAME;
DROP FUNCTION GET_RANDOM_STREET;
DROP FUNCTION GET_CITY;
DROP FUNCTION GET_REGION;
DROP FUNCTION GET_RANDOM_ZIP;
DROP FUNCTION GET_RANDOM_PHONE_NUMBER;
DROP FUNCTION GET_RANDOM_COMPANY;
DROP FUNCTION GET_RANDOM_CC_LAST_4;
DROP FUNCTION GET_RANDOM_CC_EXPIRATION_YEAR;
DROP FUNCTION GET_RANDOM_TRACKING_NUMBER;

########################################################################################################################