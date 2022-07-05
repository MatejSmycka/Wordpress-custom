function getFeed() {
  $url = 'https://REDACTED.cz/download/xml/feed.xml';
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_COOKIE, "REDACTED");
$fp = fopen(get_template_directory() ."/feed.xml", "w+");
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_exec ($ch);
curl_close ($ch);
fclose($fp);
move(get_template_directory() ."/feed.xml", "/", true );

}
getFeed();