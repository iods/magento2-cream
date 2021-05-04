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

namespace Iods\Core\Plugin\Block;

namespace TFC\Core\Plugin\Framework\Stdlib\DateTime;
use Magento\Framework\App\ScopeInterface as IScope;
use Magento\Framework\Stdlib\DateTime\Timezone as Sb;
/**
 * 2019-10-07
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * "Transfer the `\Magento\Framework\Stdlib\DateTime\Timezone::isScopeDateInInterval()` method modification
 * to the `tradefurniturecompany/core` module": https://github.com/tradefurniturecompany/core/issues/13
 */
class Timezone extends Sb {
	/** 2019-10-07 */
	function __construct() {}

	/**
	 * 2019-10-07
	 * @see \Magento\Framework\Stdlib\DateTime\Timezone::isScopeDateInInterval()
	 * @see \Magento\Framework\Stdlib\DateTime\TimezoneInterface::isScopeDateInInterval()
	 * @param Sb $sb
	 * @param \Closure $f
	 * @param int|string|IScope $scope
	 * @param string|null $dateFrom [optional]
	 * @param string|null $dateTo [optional]
	 * @return bool
	 */
	function aroundIsScopeDateInInterval(Sb $sb, \Closure $f, $scope, $dateFrom = null, $dateTo = null) {
		if (!$scope instanceof IScope) {
			$scope = $sb->_scopeResolver->getScope($scope);
		}
		$scopeTimeStamp = $sb->scopeTimeStamp($scope);
		$fromTimeStamp = strtotime($dateFrom);
		$toTimeStamp = strtotime($dateTo);
		/**
		 * 2019-10-07
		 * Here is my modification.
		 * I have removed the following code:
		 *		if ($dateTo) {
		 *			$toTimeStamp += 86400;
		 *		}
		 * https://github.com/magento/magento2/blob/2.2.6/lib/internal/Magento/Framework/Stdlib/DateTime/Timezone.php#L275-L278
			 * «I have analysed and fixed the issue.
			 * It was caused by a totally unexpected buggy behaviour of your outdated Magento version (2.2.6).
			 * Magento developers tried to fix issues of various dates formatting in different locales
			 * and did it in a straightforward and incorect way:
			 * they just add an extra day to the special promotion end date ($toTimeStamp += 86400;).
			 * I have fixed it now.»
			 * https://www.upwork.com/messages/rooms/room_8e141f0c39ea3e5091cd334db37aaef0/story_8b1ee9633f632773f154d3cb81416f95
		 */
		$result = false;
		if (!$sb->_dateTime->isEmptyDate($dateFrom) && $scopeTimeStamp < $fromTimeStamp) {}
		elseif (!$sb->_dateTime->isEmptyDate($dateTo) && $scopeTimeStamp > $toTimeStamp) {}
		else {$result = true;}
		return $result;
	}
}
