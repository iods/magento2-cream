<?php

namespace Dholi\Payment\Lib\CreditCard;

class CardExpirationMonth {
	const MSG_CARD_EXPIRATION_MONTH_INVALID = 'Please enter a valid credit card expiration date.';

	/**
	 * Year field name.
	 *
	 * @var string
	 */
	protected $year;

	protected $message;

	/**
	 * CardExpirationMonth constructor.
	 *
	 * @param string $year
	 */
	public function __construct($year) {
		$this->message = static::MSG_CARD_EXPIRATION_MONTH_INVALID;
		$this->year = $year;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function passes($value) {
		return (new ExpirationDateValidator($this->year, $value))->isValid();
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
