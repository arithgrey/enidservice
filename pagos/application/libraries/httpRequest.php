<?php 
function httpRequest($host, $port, $method, $path, $prms){
	// prms mapea desde el nombre al valor
	$prmstr = "";
	foreach ($prms as $name, $val){
		$prmstr .= $name . "=";
		$prmstr .= urlencode($val);
		$prmstr .= "&";
	}
	// Asigna valores predeterminados a $method y $port
	if (empty($method)) {
		$method = 'GET';
	}
	$method = strtoupper($method);
	if (empty($port)) {
		$port = 80; // Puerto HTTP por defecto
	}
	// Crea la conexión
	$sock = fsockopen($host, $port);
	if ($method == "GET") {
		$path .= "?" . $prmstr;
	}
	fputs($sock, "$method $path HTTP/1.1\r\n");
	fputs($sock, "Host: $host\r\n");
	fputs($sock, "Content-type: " .
	"application/x-www-form-urlencoded\r\n");
	if ($method == "POST") {
		fputs($sock, "Content-length: " .
		strlen($prmstr) . "\r\n");
	}
	fputs($sock, "Connection: close\r\n\r\n");
	if ($method == "POST") {
		fputs($sock, $prmstr);
	}
	// Buffer de resultado
	$result = "";
	while (!feof($sock)) {
		$result .= fgets($sock,1024);
	}
	fclose($sock);
	return $result;
}
?>