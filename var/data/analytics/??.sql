Commands and utilities
Create csv from a mysql query
    mysql --host=<host> --port=<port> -u<user> -p<password> <database>
    -e "<query>" -B |sed "s/'/\'/;s/\t/\",\"/g;s/^/\"/;s/$/\"/;s/\n//g"  > <file-name>.csv
create ssh tunnel for mysql when the server uses a local mysql instance (after the command you can open a new tab and use this command
    ssh  <user>@host -L 3307:127.0.0.1:3306 -N
foward ssh agent to root user when logged in a remote server
    sudo -E -s
Dump without locking database (important if dumping from production)
mysqldump -u -p -h --single-transaction

Insert eav attribute into decimal table by subselect
INSERT INTO `viainox-staging`.catalog_product_entity_decimal
(attribute_id, store_id, value, row_id)
select
733,
0,
format(
( 100-((price.final_price -(IF(billet.value = 0,0,price.final_price * IFNULL(billet.value, 5)/100))) / price.price * 100) )

,3),
prod.row_id
FROM
catalog_product_entity as prod
JOIN
catalog_product_index_price as price
on (price.entity_id = prod.entity_id )
left JOIN
catalog_product_entity_text as billet
on (billet.row_id = prod.row_id and billet.attribute_id = 718)
where price.customer_group_id =0 and price.price != 0
select all products with negative salable qtyi
select rsv.sku, sum(rsv.quantity) as reservationtotal, (sum(rsv.quantity)+ inv.quantity) as 'finalqty'
FROM
inventory_reservation rsv
join
inventory_stock_1 inv
on (inv.sku = rsv.sku)
group by rsv.sku
having finalqty < 0  AND finalqty > reservationtotal
pipe magento-cloud ssh addres to another command
mc ssh --pipe | xargs -I{} rsync -rzv {}:path/to/file path/on/your/pc
Create giftregistry_orders view
CREATE
OR REPLACE
VIEW
`giftregistry_orders_grid` AS
select
        so.entity_id,
        so.increment_id,
        so.customer_firstname,
        gp.email `giftregistry_email`
FROM
        sales_order so
        join sales_order_item si on (so.entity_id = si.order_id)
        join magento_giftregistry_item gi on (si.giftregistry_item_id = gi.item_id)
        join magento_giftregistry_person gp on (gi.entity_id = gp.entity_id)
group by
        1, 2, 3
update customer telephone and he has a order and the value is emptyi
update
        customer_address_entity cae
join sales_order so on
        cae.parent_id = so.customer_id
set
        cae.telephone = '(15) 99999-9999'
where
        cae.telephone = ""
        and so.status = "processing"