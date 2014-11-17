<?php
/**
* Template Name: Main
*/
?>
<pre>
<?php
require_once dirname(__FILE__) . '/api/AirBNB/AirBNBAutoload.php';

$airBNBServiceGet_calendar = new AirBNBServiceGet_calendar();
$_apikey = 'lcnyc!2014';
$_listing_id = '4332276';
$_start = '2014-12-01';
$_end = '2014-12-31';
if($airBNBServiceGet_calendar->get_calendar($_apikey,$_listing_id,$_start,$_end))
    print_r(json_decode($airBNBServiceGet_calendar->getResult()));
else
    print_r($airBNBServiceGet_calendar->getLastError());

?>
</pre>