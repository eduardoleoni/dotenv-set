<?php

namespace dotenvset;

class DotenvSet
{
	public $path = "../../../.env";

	public static function getPath()
	{
		return $this->path;
	}

	public static function setPath($path)
	{
		$this->path = $path;
	}

	public function set($variable, $value, $path=null)
	{
		if ($path) {
			$this->path = $path;
		}

		$string = "$variable=$value";
		$get = $this->getDotEnv();

		if (strpos($get, $variable) != true) {
			file_put_contents($this->path, file_get_contents($this->path) . "\n" . $string);
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

			file_put_contents($this->path, $env);

		}
	}

	public static function getDotEnv()
	{
		$this->createIfDoesntExist();
		$env = file_get_contents($this->path);

		return $env;
	}

	public static function createIfDoesntExist()
	{
		if (!file_exists($this->path)) {
			file_put_contents($this->path, "");
		}
	}
}