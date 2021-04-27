<?php

namespace Dholi\Payment\Lib\CreditCard\Cards;

use Dholi\Payment\Lib\CreditCard\Contracts\CreditCard;

class Dankort extends Card implements CreditCard {
	/**
	 * Regular expression for card number recognition.
	 *
	 * @var string
	 */
	public static $pattern = '/^5019/';

	/**
	 * Credit card type.
	 *
	 * @var string
	 */
	protected $type = 'debit';

	/**
	 * Credit card name.
	 *
	 * @var string
	 */
	protected $name = 'dankort';

	/**
	 * Brand name.
	 *
	 * @var string
	 */
	protected $brand = 'Dankort';

	/**
	 * Card number length's.
	 *
	 * @var array
	 */
	protected $numberLength = [16];

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
