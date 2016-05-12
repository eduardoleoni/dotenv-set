<?php
class DotenvSet
{
	public $path;

	public function __construct($path="./.env") {
		$this->path = $path;
	}

	public function getPath() {
		return $this->path;
	}

	public function set($variable, $value) {
		$string = "$variable=$value";
		$get = $this->getDotEnv();
		if (strpos($get, $variable) != true){
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

	public function getDotEnv() {
		$this->createIfDoesntExist();
		$env = file_get_contents($this->path);
		return $env;
	}

	public function createIfDoesntExist() {
		if (!file_exists($this->path)) {
			file_put_contents($this->path, "");
		}
	}
}