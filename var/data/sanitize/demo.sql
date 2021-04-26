-- Tapo todas las casillas de email que estén configuradas
UPDATE core_config_data SET value = "user@domain.com" WHERE value like '%@%';

-- Piso todas las casillas de correos de clientes que no sean nuestras
UPDATE customer_entity SET email = CONCAT('user', entity_id, '@domain.com')
    WHERE email NOT LIKE '%semexpert%';

-- Borro las direcciones de todos los cliente
DELETE FROM customer_address_entity;

-- Piso el nombre de los clientes en las grillas del admin
UPDATE sales_flat_creditmemo_grid SET billing_name = 'Demo User';
UPDATE sales_flat_invoice_grid SET billing_name = 'Demo User';
UPDATE sales_flat_order_grid SET shipping_name = 'Demo User', billing_name = 'Demo User';
UPDATE sales_flat_shipment_grid SET shipping_name = 'Demo User';


-- Piso los datos de cliente en los pedidos
UPDATE sales_flat_order SET customer_email = concat('user', customer_id, '@domain.com'),
    customer_firstname = 'Demo', customer_lastname = 'User', customer_taxvat = '123456789-2';

-- Piso los datos de cliente en los carritos
UPDATE sales_flat_quote SET customer_email = CONCAT('user', customer_id, '@domain.com'),
    customer_firstname = 'Demo', customer_lastname = 'User', customer_taxvat = '123456789-2';

-- Piso los datos de cliente en las direcciones de pedidos
UPDATE sales_flat_order_address SET fax = '12345679', firstname = 'Demo',
    lastname = 'User', email = concat('user', customer_id, '@domain.com'),
    telephone = '12345679', street = 'Fake Street 1234';

-- Piso los datos de cliente en las direcciones de carritos
UPDATE sales_flat_quote_address SET email=concat('user', customer_id, '@domain.com'),
    firstname = 'Demo', lastname = 'User', street = 'Fake Street 1234',
    telephone = '123456789', fax = '123456789';

-- Borro todas las referencias a los pagos
UPDATE sales_flat_order_payment SET cc_trans_id = '123456789', additional_information = null;

-- Borro los codigos de trackin
UPDATE sales_flat_shipment_track SET track_number = '123456789';

-- Borro cualquier instrucción sobre como realizar pagos más que nada para evitar despistados que entren al entorno equivocado
UPDATE core_config_data SET value = NULL WHERE path LIKE 'payment/%/instructions';

-- Desactivo los emails de pedidos
UPDATE core_config_data SET value = 0 WHERE path LIKE 'sales_email/%/enabled';

-- Desactivo analytics
UPDATE core_config_data SET value = 0 WHERE path = 'google/analytics/active';
UPDATE core_config_data SET value = NULL WHERE path = 'google/analytics/account';

-- Borro cualquier pass que este guardado
UPDATE core_config_data SET value = null WHERE path LIKE '%pass%'
OR path LIKE '%secret%' OR path like '%key'
AND path NOT LIKE 'customer/password/%' AND path NOT LIKE 'admin/emails/%';

-- Activo el modo demo
INSERT INTO core_config_data (scope, scope_id, path, value) VALUES ('default',
    0, 'design/head/demonotice', 1) ON DUPLICATE KEY UPDATE value = 1;

UPDATE core_config_data SET value = 1 where path = 'design/head/demonotice';

-- Borro los suscriptores al newsletter
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE newsletter_subscriber;
SET FOREIGN_KEY_CHECKS = 1;

-- Tapo todas las casillas de email que estén configuradas
UPDATE core_config_data SET value = "user@domain.com" WHERE value like '%@%';

-- Piso todas las casillas de correos de clientes que no sean nuestras
UPDATE customer_entity SET email = CONCAT('user', entity_id, '@domain.com')
    WHERE email NOT LIKE '%semexpert%';

-- Borro las direcciones de todos los cliente
DELETE FROM customer_address_entity;

-- Piso el nombre de los clientes en las grillas del admin
UPDATE sales_flat_creditmemo_grid SET billing_name = 'Demo User';
UPDATE sales_flat_invoice_grid SET billing_name = 'Demo User';
UPDATE sales_flat_order_grid SET shipping_name = 'Demo User', billing_name = 'Demo User';
UPDATE sales_flat_shipment_grid SET shipping_name = 'Demo User';


-- Piso los datos de cliente en los pedidos
UPDATE sales_flat_order SET customer_email = concat('user', customer_id, '@domain.com'),
    customer_firstname = 'Demo', customer_lastname = 'User', customer_taxvat = '123456789-2';

-- Piso los datos de cliente en los carritos
UPDATE sales_flat_quote SET customer_email = CONCAT('user', customer_id, '@domain.com'),
    customer_firstname = 'Demo', customer_lastname = 'User', customer_taxvat = '123456789-2';

-- Piso los datos de cliente en las direcciones de pedidos
UPDATE sales_flat_order_address SET fax = '12345679', firstname = 'Demo',
    lastname = 'User', email = concat('user', customer_id, '@domain.com'),
    telephone = '12345679', street = 'Fake Street 1234';

-- Piso los datos de cliente en las direcciones de carritos
UPDATE sales_flat_quote_address SET email=concat('user', customer_id, '@domain.com'),
    firstname = 'Demo', lastname = 'User', street = 'Fake Street 1234',
    telephone = '123456789', fax = '123456789';

-- Borro todas las referencias a los pagos
UPDATE sales_flat_order_payment SET cc_trans_id = '123456789', additional_information = null;

-- Borro los codigos de trackin
UPDATE sales_flat_shipment_track SET track_number = '123456789';

-- Borro cualquier instrucción sobre como realizar pagos más que nada para evitar despistados que entren al entorno equivocado
UPDATE core_config_data SET value = NULL WHERE path LIKE 'payment/%/instructions';

-- Desactivo los emails de pedidos
UPDATE core_config_data SET value = 0 WHERE path LIKE 'sales_email/%/enabled';

-- Desactivo analytics
UPDATE core_config_data SET value = 0 WHERE path = 'google/analytics/active';
UPDATE core_config_data SET value = NULL WHERE path = 'google/analytics/account';

-- Borro cualquier pass que este guardado
UPDATE core_config_data SET value = null WHERE path LIKE '%pass%'
OR path LIKE '%secret%' OR path like '%key'
AND path NOT LIKE 'customer/password/%' AND path NOT LIKE 'admin/emails/%';

-- Activo el modo demo
INSERT INTO core_config_data (scope, scope_id, path, value) VALUES ('default',
    0, 'design/head/demonotice', 1) ON DUPLICATE KEY UPDATE value = 1;

UPDATE core_config_data SET value = 1 where path = 'design/head/demonotice';

-- Borro los suscriptores al newsletter
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE newsletter_subscriber;
SET FOREIGN_KEY_CHECKS = 1;