<?php

namespace Dholi\Payment\Lib\CreditCard\Cards;

use Dholi\Payment\Lib\CreditCard\Contracts\CreditCard;

class UnionPay extends Card implements CreditCard {
	/**
	 * Regular expression for card number recognition.
	 *
	 * @var string
	 */
	public static $pattern = '/^62(?!(2126|2925))/'; // 622126 and 622925 are starts for Discovery

	/**
	 * Credit card type.
	 *
	 * @var string
	 */
	protected $type = 'credit';

	/**
	 * Credit card name.
	 *
	 * @var string
	 */
	protected $name = 'unionpay';

	/**
	 * Brand name.
	 *
	 * @var string
	 */
	protected $brand = 'Union Pay';

	/**
	 * Card number length's.
	 *
	 * @var array
	 */
	protected $numberLength = [16, 17, 18, 19];

	/**
	 * CVC code length's.
	 *
	 * @var array
	 */
	protected $cvcLength = [3];

	/**
	 * Test cvc code checksum against Luhn algorithm.
	 *
	 * @var bool
	 */
	protected $checksumTest = false;
}
