Disable CSS/JS Merge/Minify/Static Signing on M2 via SQL
disable-css-js-merge-minify-m2.sql
-- review
select * from core_config_data where path like 'dev/%';

-- update all
update core_config_data set value = '0' where path = 'dev/css/merge_css_files';
update core_config_data set value = '0' where path = 'dev/css/minify_files';
update core_config_data set value = '0' where path = 'dev/js/merge_files';
update core_config_data set value = '0' where path = 'dev/js/enable_js_bundling';
update core_config_data set value = '0' where path = 'dev/js/minify_files';
UPDATE core_config_data SET value = '0' WHERE path = 'dev/static/sign';

-- confirm
select * from core_config_data where path like 'dev/%';