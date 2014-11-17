<?php
/**
 * Test with AirBNB for 'http://my-api.us/airbnb.com/server.php?wsdl'
 * @package AirBNB
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2014-09-24
 */
ini_set('memory_limit','512M');
ini_set('display_errors',true);
error_reporting(-1);
/**
 * Load autoload
 */
require_once dirname(__FILE__) . '/AirBNBAutoload.php';
/**
 * Wsdl instanciation infos. By default, nothing has to be set.
 * If you wish to override the SoapClient's options, please refer to the sample below.
 * 
 * This is an associative array as:
 * - the key must be a AirBNBWsdlClass constant beginning with WSDL_
 * - the value must be the corresponding key value
 * Each option matches the {@link http://www.php.net/manual/en/soapclient.soapclient.php} options
 * 
 * Here is below an example of how you can set the array:
 * $wsdl = array();
 * $wsdl[AirBNBWsdlClass::WSDL_URL] = 'http://my-api.us/airbnb.com/server.php?wsdl';
 * $wsdl[AirBNBWsdlClass::WSDL_CACHE_WSDL] = WSDL_CACHE_NONE;
 * $wsdl[AirBNBWsdlClass::WSDL_TRACE] = true;
 * $wsdl[AirBNBWsdlClass::WSDL_LOGIN] = 'myLogin';
 * $wsdl[AirBNBWsdlClass::WSDL_PASSWD] = '**********';
 * etc....
 * Then instantiate the Service class as: 
 * - $wsdlObject = new AirBNBWsdlClass($wsdl);
 */
/**
 * Examples
 */


/*********************************
 * Example for AirBNBServiceSearch
 */
$airBNBServiceSearch = new AirBNBServiceSearch();
// sample call for AirBNBServiceSearch::search()
if($airBNBServiceSearch->search($_apikey,$_city,$_state,$_country))
    print_r($airBNBServiceSearch->getResult());
else
    print_r($airBNBServiceSearch->getLastError());

/***************************************
 * Example for AirBNBServiceGet_calendar
 */
$airBNBServiceGet_calendar = new AirBNBServiceGet_calendar();
// sample call for AirBNBServiceGet_calendar::get_calendar()
if($airBNBServiceGet_calendar->get_calendar($_apikey,$_listing_id,$_start,$_end))
    print_r($airBNBServiceGet_calendar->getResult());
else
    print_r($airBNBServiceGet_calendar->getLastError());
