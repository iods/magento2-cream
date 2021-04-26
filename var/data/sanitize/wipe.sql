Magento 2 Clear DB for Launch
Includes a basic clear.sql file for removing orders and customers and resetting the base invoice, order, shipment and creditmemo id's back to 0

A customweb_sagepay.sql for clearing out test SagePay orders from the customweb module

A invoice_starting.sql for setting the start id's of invoices, orders, shipments and credit memos.

clear.sql
SET FOREIGN_KEY_CHECKS=0;

# Clean order history
TRUNCATE TABLE `sales_bestsellers_aggregated_daily`;
TRUNCATE TABLE `sales_bestsellers_aggregated_monthly`;
TRUNCATE TABLE `sales_bestsellers_aggregated_yearly`;

# Clean order infos
TRUNCATE TABLE `sales_creditmemo`;
TRUNCATE TABLE `sales_creditmemo_comment`;
TRUNCATE TABLE `sales_creditmemo_grid`;
TRUNCATE TABLE `sales_creditmemo_item`;
TRUNCATE TABLE `sales_invoice`;
TRUNCATE TABLE `sales_invoiced_aggregated`;
TRUNCATE TABLE `sales_invoiced_aggregated_order`;
TRUNCATE TABLE `sales_invoice_comment`;
TRUNCATE TABLE `sales_invoice_grid`;
TRUNCATE TABLE `sales_invoice_item`;
TRUNCATE TABLE `sales_order`;
TRUNCATE TABLE `sales_order_address`;
TRUNCATE TABLE `sales_order_aggregated_created`;
TRUNCATE TABLE `sales_order_aggregated_updated`;
TRUNCATE TABLE `sales_order_grid`;
TRUNCATE TABLE `sales_order_item`;
TRUNCATE TABLE `sales_order_payment`;
TRUNCATE TABLE `sales_order_status_history`;
TRUNCATE TABLE `sales_order_tax`;
TRUNCATE TABLE `sales_order_tax_item`;
TRUNCATE TABLE `sales_payment_transaction`;
TRUNCATE TABLE `sales_refunded_aggregated`;
TRUNCATE TABLE `sales_refunded_aggregated_order`;
TRUNCATE TABLE `sales_shipment`;
TRUNCATE TABLE `sales_shipment_comment`;
TRUNCATE TABLE `sales_shipment_grid`;
TRUNCATE TABLE `sales_shipment_item`;
TRUNCATE TABLE `sales_shipment_track`;
TRUNCATE TABLE `sales_shipping_aggregated`;
TRUNCATE TABLE `sales_shipping_aggregated_order`;

# Clean cart infos
TRUNCATE TABLE `quote`;
TRUNCATE TABLE `quote_address`;
TRUNCATE TABLE `quote_address_item`;
TRUNCATE TABLE `quote_id_mask`;
TRUNCATE TABLE `quote_item`;
TRUNCATE TABLE `quote_item_option`;
TRUNCATE TABLE `quote_payment`;
TRUNCATE TABLE `quote_shipping_rate`;

# Clean customer data
TRUNCATE TABLE `customer_address_entity`;
TRUNCATE TABLE `customer_address_entity_datetime`;
TRUNCATE TABLE `customer_address_entity_decimal`;
TRUNCATE TABLE `customer_address_entity_int`;
TRUNCATE TABLE `customer_address_entity_text`;
TRUNCATE TABLE `customer_address_entity_varchar`;
TRUNCATE TABLE `customer_entity`;
TRUNCATE TABLE `customer_entity_datetime`;
TRUNCATE TABLE `customer_entity_decimal`;
TRUNCATE TABLE `customer_entity_int`;
TRUNCATE TABLE `customer_entity_text`;
TRUNCATE TABLE `customer_entity_varchar`;
TRUNCATE TABLE `customer_grid_flat`;
TRUNCATE TABLE `customer_log`;
TRUNCATE TABLE `customer_visitor`;
TRUNCATE TABLE `persistent_session`;
TRUNCATE TABLE `wishlist`;
TRUNCATE TABLE `wishlist_item`;
TRUNCATE TABLE `wishlist_item_option`;

# Reset search terms
TRUNCATE TABLE `catalogsearch_fulltext_scope1`;
TRUNCATE TABLE `search_query`;

# Reset indexes (if you want your orders number start back to 1
TRUNCATE TABLE `sequence_invoice_1`;
TRUNCATE TABLE `sequence_order_1`;
TRUNCATE TABLE `sequence_shipment_1`;
TRUNCATE TABLE `sequence_creditmemo_1`;

SET FOREIGN_KEY_CHECKS=1;
customweb_sagepay.sql
SET FOREIGN_KEY_CHECKS=0;

TRUNCATE TABLE `customweb_sagepaycw_customer_context`;
TRUNCATE TABLE `customweb_sagepaycw_external_checkout_context`;
TRUNCATE TABLE `customweb_sagepaycw_storage`;
TRUNCATE TABLE `customweb_sagepaycw_transaction`;
TRUNCATE TABLE `customweb_sagepaycw_transaction_grid`;
TRUNCATE TABLE `sequence_sagepaycw_transaction_1`;

SET FOREIGN_KEY_CHECKS=1;
invoice_starting.sql
SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE sequence_invoice_1 AUTO_INCREMENT = 1006;
ALTER TABLE sequence_order_1 AUTO_INCREMENT = 1006;
ALTER TABLE sequence_shipment_1 AUTO_INCREMENT = 1006;
ALTER TABLE sequence_creditmemo_1 AUTO_INCREMENT = 1006;

SET FOREIGN_KEY_CHECKS=1;