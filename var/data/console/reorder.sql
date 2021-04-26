
-- we want to order attribute options by option label
-- the label is stored as value in table eav_attribute_option_value
-- order is stored in table eav_attribute_option
-- we therefore have to use update with multiple table syntax with a subselect as
-- workaround as we can't use ORDER BY in update with multiple tables

-- sort attribute with ID 173 by column default sorting
UPDATE eav_attribute_option AS o INNER JOIN (
  SELECT option_id FROM eav_attribute_option_value WHERE store_id=0 ORDER BY value
) as v on o.option_id=v.option_id,
(SELECT @n := 0) counter -- variable init
SET o.sort_order = @n := @n + 1
WHERE o.attribute_id=173;

-- sort attribute with ID 173 by number value sorting
UPDATE IGNORE eav_attribute_option AS o INNER JOIN (
  SELECT option_id FROM eav_attribute_option_value WHERE store_id=0 ORDER BY CAST(value AS UNSIGNED)
) as v on o.option_id=v.option_id,
(SELECT @n := 0) counter
SET o.sort_order = @n := @n + 1
WHERE o.attribute_id=173;

-- sort attribute with ID 137 by decimal values
-- this is a little different w/o an explicit join
UPDATE eav_attribute_option as o1, (
  SELECT o2.option_id from eav_attribute_option as o2
  inner join eav_attribute_option_value as v on o2.option_id=v.option_id and v.store_id=0
  WHERE o2.attribute_id=137 order by cast(replace(v.value,",",".") as DECIMAL(9,2))
) as sel,
(SELECT @i := 0) as counter
SET sort_order=@i:=(@i+1)
WHERE o1.option_id=sel.option_id;

-- sources
-- http://stackoverflow.com/questions/10544502/update-syntax-with-order-by-limit-and-multiple-tables
-- http://www.xaprb.com/blog/2006/08/10/how-to-use-order-by-and-limit-on-multi-table-updates-in-m
--
-- Reorder attribute options in Magento by custom sort order directly in databaseysql/