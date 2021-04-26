Magento 2 - Find CRON jobs that ran more than once at a given second
1_find_crons_that_ran_more_than_once.sql
SET SESSION group_concat_max_len = 1000000;
SELECT job_code, count(job_code) AS how_many_times_did_job_run_more_than_once, SUM(count) AS total_number_of_times_job_ran, GROUP_CONCAT(executed_at_group) AS executed_at FROM (
    SELECT cron_schedule.*, GROUP_CONCAT(cron_schedule.executed_at) AS executed_at_group, count(job_code) AS count FROM cron_schedule WHERE executed_at IS NOT NULL GROUP BY job_code, executed_at HAVING count(job_code) > 1 ORDER BY executed_at DESC
) AS duplicate_crons
GROUP BY job_code
ORDER BY count(job_code) DESC;