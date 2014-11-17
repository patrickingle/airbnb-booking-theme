<?php
/**
 * File for class AirBNBServiceGet_calendar
 * @package AirBNB
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2014-09-24
 */
/**
 * This class stands for AirBNBServiceGet_calendar originally named Get_calendar
 * @package AirBNB
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2014-09-24
 */
class AirBNBServiceGet_calendar extends AirBNBWsdlClass
{
    /**
     * Method to call the operation originally named get_calendar
     * Documentation : Get Calendar availability for any AirBNB listing
     * @uses AirBNBWsdlClass::getSoapClient()
     * @uses AirBNBWsdlClass::setResult()
     * @uses AirBNBWsdlClass::saveLastError()
     * @param string $_apikey
     * @param string $_listing_id
     * @param string $_start
     * @param string $_end
     * @return string
     */
    public function get_calendar($_apikey,$_listing_id,$_start,$_end)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->get_calendar($_apikey,$_listing_id,$_start,$_end));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see AirBNBWsdlClass::getResult()
     * @return string
     */
    public function getResult()
    {
        return parent::getResult();
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
