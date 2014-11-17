<?php
/**
 * File for class AirBNBServiceSearch
 * @package AirBNB
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2014-09-24
 */
/**
 * This class stands for AirBNBServiceSearch originally named Search
 * @package AirBNB
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2014-09-24
 */
class AirBNBServiceSearch extends AirBNBWsdlClass
{
    /**
     * Method to call the operation originally named search
     * Documentation : Search AirBNB for listings
     * @uses AirBNBWsdlClass::getSoapClient()
     * @uses AirBNBWsdlClass::setResult()
     * @uses AirBNBWsdlClass::saveLastError()
     * @param string $_apikey
     * @param string $_city
     * @param string $_state
     * @param string $_country
     * @return string
     */
    public function search($_apikey,$_city,$_state,$_country)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->search($_apikey,$_city,$_state,$_country));
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
