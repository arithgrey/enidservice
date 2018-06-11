<?php
define('GET', 'get');
define('POST', 'post');

class Request {

	private $params = NULL;
	private $method = NULL;
	private $target = NULL;

	function Request($method = POST, $target = "_self") {
		$this->params = array();
		$this->method = $method;
		$this->target = $target;
	}
    function addParam($key, $value) {
		if (is_numeric($key)) {
			throw new Exception("El nombre del parametro no puede ser numÃ©rico.");
		}

		$this->params[$key] = $value;
	}
    /**/
	function getParam($key) {
		return $this->params[$key];
	}
    /**/
	function setParams($params) {
		if (is_array($params)) {
			foreach ($params as $key => $value) {
				$this->addParam($key, $value);
			}
		}
	}
	function forward($url, $execute = true) {
		$max = sizeof($this->params);
		$str = "";

		foreach ($this->params as $key => $value) {
			$str .= "<input name=\"{$key}\" type=\"hidden\" value=\"{$value}\">";
		}

		$html =
				"<html>".
				"<head>".
				"<script>".
				"function post_forward() {".
				($execute ? "document.getElementById(\"post_form\").submit();" : "").
				"}".
				"</script>".
				"</head>".
				"<body onload=\"post_forward()\">".
				"<form id=\"post_form\" name=\"post_form\" method=\"{$this->method}\" action=\"$url\" target=\"{$this->target}\">".
				"$str".
				"</form>".
				"</body>".
				"</html>";
		print $html;
	}
}
?>