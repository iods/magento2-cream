magento-orders_per_minute.sql
select
    # Change the interval based on UTC to show on specific timezone
    date_format(date_sub(o.created_at, interval 7 hour), "%l:%i %p") `Time in PST`,
    count(*) OPM
from sales_flat_order o
# Time from the DB
where o.created_at > '2018-07-16 16:00:00'
and o.created_at < '2018-07-16 19:00:00'
# Inform store ID below or remove for all stores
and o.store_id='1374'
group by hour(o.created_at),minute(o.created_at)
order by o.created_at ASC;