<?php

namespace Dholi\Payment\Lib\CreditCard;

class CardExpirationYear {

	const MSG_CARD_EXPIRATION_YEAR_INVALID = 'Please enter a valid credit card expiration date.';

	protected $message;
	/**
	 * Month field name.
	 *
	 * @var string
	 */
	protected $month;

	/**
	 * CardExpirationYear constructor.
	 *
	 * @param string $month
	 */
	public function __construct($month) {
		$this->message = static::MSG_CARD_EXPIRATION_YEAR_INVALID;
		$this->month = $month;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function passes($value) {
		return (new ExpirationDateValidator($value, $this->month))->isValid();
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
