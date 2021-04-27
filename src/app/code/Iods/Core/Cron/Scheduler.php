<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Helper;

use \Magento\Cron\Model\Schedule;

/**
 * Schedule a Job
 */
class Scheduler
{
    const BINGO_SYNC_DATA_JOB_CODE = 'bingo_data_sync';
    const SECONDS_IN_MINUTE = 60;
    /**
     * @var \Magento\Cron\Model\ResourceModel\Schedule\Collection
     */
    protected $_pendingSchedules;

    /**
     * @var ScheduleFactory
     */
    protected $_scheduleFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * @param ScheduleFactory $scheduleFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        \Magento\Cron\Model\ScheduleFactory $scheduleFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
        $this->_scheduleFactory = $scheduleFactory;
        $this->timezone = $timezone;
    }

    /**
     * Return job collection from data base with status 'pending'
     *
     * @return \Magento\Cron\Model\ResourceModel\Schedule\Collection
     */
    protected function _getPendingSchedules()
    {
        if (!$this->_pendingSchedules) {
            $this->_pendingSchedules = $this->_scheduleFactory->create()->getCollection()->addFieldToFilter(
                'status',
                Schedule::STATUS_PENDING
            )->load();
        }
        return $this->_pendingSchedules;
    }

    public function scheduleJob($jobCode, $cronExpression = '* * * * *', $timeInterval = 1)
    {
        $schedules = $this->_getPendingSchedules();
        $exists = [];
        /** @var Schedule $schedule */
        foreach ($schedules as $schedule) {
            $exists[$schedule->getJobCode() . '/' . $schedule->getScheduledAt()] = 1;
        }

        /**
         * Schedule a Job
         */
        $this->saveSchedule($jobCode, $cronExpression, $timeInterval * self::SECONDS_IN_MINUTE, $exists);
    }

    /**
     * @param string $jobCode
     * @param string $cronExpression
     * @param int $timeInterval
     * @param array $exists
     * @return void
     */
    protected function saveSchedule($jobCode, $cronExpression, $timeInterval, $exists)
    {
        $currentTime = $this->timezone->scopeTimeStamp();
        $timeAhead = $currentTime + $timeInterval;
        for ($time = $currentTime; $time < $timeAhead; $time += self::SECONDS_IN_MINUTE) {
            $ts = strftime('%Y-%m-%d %H:%M:00', $time);
            if (!empty($exists[$jobCode . '/' . $ts])) {
                // already scheduled
                continue;
            }
            $schedule = $this->generateSchedule($jobCode, $cronExpression, $time);
            if ($schedule->trySchedule()) {
                // time matches cron expression
                $schedule->save();
                return;
            }
        }
    }

    /**
     * @param string $jobCode
     * @param string $cronExpression
     * @param int $time
     * @return Schedule
     */
    protected function generateSchedule($jobCode, $cronExpression, $time)
    {
        $schedule = $this->_scheduleFactory->create()
            ->setCronExpr($cronExpression)
            ->setJobCode($jobCode)
            ->setStatus(Schedule::STATUS_PENDING)
            ->setCreatedAt(strftime('%Y-%m-%d %H:%M:%S', $this->timezone->scopeTimeStamp()))
            ->setScheduledAt(strftime('%Y-%m-%d %H:%M', $time));

        return $schedule;
    }
}
