<?php
/**
 * Output the current time in red letters
 *
 * @param    string          Empty string (no content to process)
 * @param    array           TypoScript configuration
 * @return   string          HTML output, showing the current server time.
 */
function user_printTime($content, $conf) {
	$url = "url('fileadmin//background//DSCN02" . rand(18,28) . ".JPG');";
  return 'style="background-image:' . $url . '"';
}
?>

