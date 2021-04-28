<?php

namespace Dholi\Payment\Lib\CreditCard\Cards;

use Dholi\Payment\Lib\CreditCard\Contracts\CreditCard;

class DinersClub extends Card implements CreditCard {
	/**
	 * Regular expression for card number recognition.
	 *
	 * @var string
	 */
	public static $pattern = '/^3(0[0-5]|[68][0-9])[0-9]/';

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
	protected $name = 'dinersclub';

	/**
	 * Brand name.
	 *
	 * @var string
	 */
	protected $brand = 'Diners Club International';

	/**
	 * Card number length's.
	 *
	 * @var array
	 */
	protected $numberLength = [14];

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
	protected $checksumTest = true;
}
