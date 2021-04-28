<?php

namespace Dholi\Payment\Lib\CreditCard;

use Exception;

class CardCvc {

	const MSG_CARD_CVC_INVALID = 'Please enter a valid credit card verification number';

	protected $message;

	/**
	 * Credit card number.
	 *
	 * @var string
	 */
	protected $cardNumber;

	public function __construct($cardNumber) {
		$this->message = static::MSG_CARD_CVC_INVALID;
		$this->cardNumber = $cardNumber;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function passes($value) {
		try {
			return Factory::makeFromNumber($this->cardNumber)->isValidCvc($value);
		} catch (Exception $ex) {
			return false;
		}
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return __($this->message);
	}
}