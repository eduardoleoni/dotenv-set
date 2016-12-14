<?php

namespace dotenvset;

class DotenvSet
{
	public static $path = __DIR__ . DIRECTORY_SEPARATOR . "../../../../../.env";

	public static function getPath()
	{
		return self::$path;
	}

	public static function setPath($path)
	{
		self::$path = $path;
	}

	public static function set($variable, $value, $path=null)
	{
		if ($path) {
			self::$path = $path;
		}

		$string = "$variable=$value";
		$get = self::getDotEnv();

		if (strpos($get, $variable) != true) {
			file_put_contents(self::$path, file_get_contents(self::$path) . "\n" . $string);
		} else {

			$all = explode("\n", $get);
			$env = "";

			foreach ($all as $each) {
				$current = explode("=", $each);
				if ($current[0] == $variable) {
					$each = $current[0] . "=$value";
				}

				$env .= $each . "\n";
			}

			file_put_contents(self::$path, $env);

		}
	}

	public static function getDotEnv()
	{
		self::createIfDoesntExist();
		$env = file_get_contents(self::$path);

		return $env;
	}

	public static function createIfDoesntExist()
	{
		if (!file_exists(self::$path)) {
			file_put_contents(self::$path, "");
		}
	}
}