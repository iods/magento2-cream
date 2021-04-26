Magento, Scrub Customer emails, phone numbers, passwords, and other EAV values
scrub-magento.sql
-- After dumping a production database, needing to scrub customer data to remove emails, phone numbers,
-- reset passwords, and/or specific attributes from the EAV tables. Change IDs and values accordingly
-- DO NOT BLINDLY COPY/PASTE RUN without customizing for your needs first! For Magento 1.x

-- NOTE: if you need to target a specific EAV use something similar and NOTE the attribute_id!
update customer_entity_text set value = concat('test+unknown@gmail.com') where attribute_id = 267 and entity_type_id = 1;

-- Set all customer passwords to password123
update customer_entity_varchar set value = '15d590025cf0bc5c7db18292ca8c73342d3a7706f0deb5589431e3a137b420cf:jK' where attribute_id = 12 and entity_type_id = 1;

-- set all email addresses
update customer_entity set email = concat('test+', entity_id, '@gmail.com');
update sales_flat_order_address set email = concat('test+', customer_id, '@gmail.com') where customer_id is not null;
update sales_flat_order_address set email = concat('test+unknown@gmail.com') where customer_id is null;
update sales_flat_order set customer_email = concat('test+', customer_id, '@gmail.com') where customer_id is not null;
update sales_flat_order set customer_email = concat('test+unknown@gmail.com') where customer_id is null;
update sales_flat_quote set customer_email = concat('test+', customer_id, '@gmail.com') where customer_id is not null;
update sales_flat_quote set customer_email = concat('test+unknown@gmail.com') where customer_id is null;
update sales_flat_quote_address set email = concat('test+', customer_id, '@gmail.com') where customer_id is not null;
update sales_flat_quote_address set email = concat('test+unknown@gmail.com') where customer_id is null;

-- set all phone numbers
update customer_address_entity_varchar set value = '15551231234' where attribute_id = 31 and entity_type_id = 2;
update sales_flat_order_address set telephone = '15551231234' where customer_id is not null;
update sales_flat_order_address set telephone = '15551231234' where customer_id is null;
update sales_flat_quote_address set telephone = '15551231234' where customer_id is not null;
update sales_flat_quote_address set telephone = '15551231234' where customer_id is null;