<?php

namespace Dholi\Payment\Lib\CreditCard\Cards;

use Dholi\Payment\Lib\CreditCard\Contracts\CreditCard;

class Hipercard extends Card implements CreditCard {
	/**
	 * Regular expression for card number recognition.
	 *
	 * @var string
	 */
	public static $pattern = '/^(606282\d{10}(\d{3})?)|(3841\d{15})/';

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
	protected $name = 'hipercard';

	/**
	 * Brand name.
	 *
	 * @var string
	 */
	protected $brand = 'Hipercard';

	/**
	 * Card number length's.
	 *
	 * @var array
	 */
	protected $numberLength = [13, 16, 19];

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
