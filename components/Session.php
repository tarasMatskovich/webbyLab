<?php 

namespace App\Components;

abstract class Session {
	public static function set($key, $value) {
		if (is_array($value)) {
			$_SESSION[$key] = json_encode($value);
		} else {
			$_SESSION[$key] = $value;
		}
	}

	public static function setFlash($key, $value) {
		$data = [
			'flash' => true,
			'value' => $value,
		];

		$_SESSION[$key] = json_encode($data);
	}

	public static function get($key) {
		if (!isset($_SESSION[$key]))
			return null;
		if (json_decode($_SESSION[$key])) {
			$data = json_decode($_SESSION[$key], true);
			if (isset($data['flash'])) {
				return $data['value'];
			} else {
				return $data;
			}
		} else {
			return $_SESSION[$key];
		}
	}

	public static function isset($key) {
		return isset($_SESSION[$key]);
	}

	public static function delete($key) {
		if (isset($_SESSION[$key]))
			unset($_SESSION[$key]);
	}

	public static function clearFlashMessage()
	{
		foreach ($_SESSION as $key => $value) {
			if (json_decode($value)) {
				$data = json_decode($value);
				if (isset($data->flash)) {
					if ($data->flash == true) {
						$data->flash = false;
						$_SESSION[$key] = json_encode($data);
					} elseif($data->flase == false || $data->flash == null) {
						static::delete($key);
					}
				}
			}
		}
 	}
}