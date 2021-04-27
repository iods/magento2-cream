<?php

namespace Dholi\Payment\Lib\CreditCard\Cards;

use Dholi\Payment\Lib\CreditCard\Contracts\CreditCard;

class AmericanExpress extends Card implements CreditCard {
	/**
	 * Regular expression for card number recognition.
	 *
	 * @var string
	 */
	public static $pattern = '/^3[47][0-9]/';

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
	protected $name = 'amex';

	/**
	 * Brand name.
	 *
	 * @var string
	 */
	protected $brand = 'American Express';

	/**
	 * Card number length's.
	 *
	 * @var array
	 */
	protected $numberLength = [15];

	/**
	 * CVC code length's.
	 *
	 * @var array
	 */
	protected $cvcLength = [3, 4];

	/**
	 * Test cvc code checksum against Luhn algorithm.
	 *
	 * @var bool
	 */
	protected $checksumTest = true;
}
