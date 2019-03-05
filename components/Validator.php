<?php

namespace App\Components;

class Validator {
	private $rules = [
		'required' => "[a-zA-Zа-яА-Я0-9]+",
		'number' => "[0-9]+",
	];
	private $messages = [];
	private $errors = [];

	public function __construct() {

	}

	private function setMessages(array $messages)
	{
		foreach ($messages as $field => $msg) {
			$sgm = explode(".", $field);
			$this->messages[$sgm[0]][$sgm[1]] = $msg;
		}
	}

	public static function validate(array $data, array $rules, $messages = [])
	{
		$instance = new static;
		$instance->setMessages($messages);
		foreach ($data as $field => $value) {
			if (isset($rules[$field])) {
				foreach ($rules[$field] as $rule) {
					$instance->checkRule($rule, $field, $value);
				}
			}
		}
		return $instance;
	}

	protected function checkRule(string $rule, $field, $value) {
		if (isset($this->rules[$rule])) {
			$pattern = "~" . $this->rules[$rule] . "~";
			if (!preg_match($pattern, $value)) {
				if (isset($this->messages[$field][$rule])) {
					$this->errors[$field][] = $this->messages[$field][$rule];
				}
			}
		} else {
			throw new \Exception("Erorr: Unknown validation rule: " . $rule);
		}
	}

	public function getErrorsCount() {
		return count($this->errors);
	}

	public function getErrors()
	{
		return $this->errors;
	}
}