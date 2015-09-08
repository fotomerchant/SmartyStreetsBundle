<?php

namespace blackknight467\SmartyStreetsBundle\Service;

use blackknight467\SmartyStreetsBundle\Exception\SmartyStreetsException;
use blackknight467\SmartyStreetsBundle\Model\AdvancedSmartyStreetsUSAddressInterface;
use blackknight467\SmartyStreetsBundle\Model\SimpleSmartyStreetsUSAddressInterface;
use blackknight467\SmartyStreetsBundle\Model\SimpleSmartyStreetsUSZipCodeInterface;
use blackknight467\SmartyStreetsBundle\Model\SmartyStreetsInputIdInterface;
use blackknight467\SmartyStreetsBundle\Model\SmartyStreetsUSAddress;
use blackknight467\SmartyStreetsBundle\Model\SmartyStreetsUSAddressInterface;
use blackknight467\SmartyStreetsBundle\Model\SmartyStreetsUSZipcodeInterface;

class SmartyStreetsService
{
    const VERIFY_US_URL = "https://api.smartystreets.com/street-address";
    const VERIFY_ZIP_CODE = "https://api.smartystreets.com/zipcode";
    const VERIFY_INTERNATIONAL_URL = "https://international-api.smartystreets.com/verify";
    const AUTO_COMPLETE_US_URL = "https://autocomplete-api.smartystreets.com/suggest";
    const EXTRACT_URL = "https://extract-beta.api.smartystreets.com";

    /** @var string */
    private $authToken;

    /** @var string */
    private $authId;

    /**
     * @param string $authId
     * @param string $authToken
     */
    public function __construct($authId, $authToken)
    {
        $this->authId = $authId;
        $this->authToken = $authToken;
    }

    /**
     * @param string $street
     * @return string
     */
    public function verifyUSStreetAddressText($street)
    {
        $address = new SmartyStreetsUSAddress();
        $address->setStreet($street);

        return $this->verifyUSStreetAddress($address);
    }

    /**
     * @param SimpleSmartyStreetsUSAddressInterface $address
     * @param int $candidates
     * @return string
     */
    public function verifyUSStreetAddress(SimpleSmartyStreetsUSAddressInterface $address, $candidates = 1)
    {
        $url = $this->buildBaseUrl(self::VERIFY_US_URL);

        if (!empty($address->getStreet())) {
            $url .= '&street=' . urlencode($address->getStreet());
        }
        if ($address instanceof SmartyStreetsUSAddressInterface) {
            if (!empty($address->getZipCode())) {
                $url .= '&zipcode=' . urlencode($address->getZipCode());
            }
            if (!empty($address->getCity())) {
                $url .= '&city=' . urlencode($address->getCity());
            }
            if (!empty($address->getState())) {
                $url .= '&state=' . urlencode($address->getState());
            }
            if (!empty($address->getAddressee())) {
                $url .= '&addressee=' . urlencode($address->getAddressee());
            }
        }
        if ($address instanceof AdvancedSmartyStreetsUSAddressInterface) {
            if (!empty($address->getStreet2())) {
                $url .= '&street2=' . urlencode($address->getStreet2());
            }
            if (!empty($address->getSecondary())) {
                $url .= '&secondary=' . urlencode($address->getSecondary());
            }
            if (!empty($address->getLastLine())) {
                $url .= '&lastline=' . urlencode($address->getLastLine());
            }
            if (!empty($address->getUrbanization())) {
                $url .= '&urbanization=' . urlencode($address->getUrbanization());
            }
        }

        $url = $this->addInputIdQueryString($url, $address);

        $url .= '&candidates=' . $candidates;

        return $this->httpGet($url);
    }

    public function verifyMultipleUSStreetAddresses(array $addresses)
    {
        $url = $this->buildBaseUrl(self::VERIFY_US_URL);
    }

    /**
     * @param $zip
     * @return string
     */
    public function verifyTextZipCode($zip)
    {
        $address = new SmartyStreetsUSAddress();
        $address->setZipCode($zip);

        return $this->verifyZipCode($address);
    }

    public function verifyMultipleTextZipCodes(array $zipCodes)
    {
        $addresses = [];

        foreach ($zipCodes as $zip) {
            $address = new SmartyStreetsUSAddress();
            $address->setZipCode($zip);
            $addresses[] = $address;
        }

        return $this->verifyMultipleZipCode($addresses);
    }

    /**
     * @param SimpleSmartyStreetsUSZipCodeInterface $zipCode
     * @return string
     */
    public function verifyZipCode(SimpleSmartyStreetsUSZipCodeInterface $zipCode)
    {
        $url = $this->buildBaseUrl(self::VERIFY_ZIP_CODE);

        if (!empty($zipCode->getZipCode())) {
            $url .= '&zipcode=' . $zipCode->getZipCode();
        }
        if ($zipCode instanceof SmartyStreetsUSZipcodeInterface) {
            if (!empty($zipCode->getCity())) {
                $url .= '&city=' . urlencode($zipCode->getCity());
            }
            if (!empty($zipCode->getState())) {
                $url .= '&state=' . $zipCode->getState();
            }
        }
        $url = $this->addInputIdQueryString($url, $zipCode);

        return $this->httpGet($url);
    }

    /**
     * @param SimpleSmartyStreetsUSZipCodeInterface[] $zipCodes
     * @return string
     */
    public function verifyMultipleZipCode(array $zipCodes)
    {
        $url = $this->buildBaseUrl(self::VERIFY_ZIP_CODE);

        $objs = [];
        foreach ($zipCodes as $zipCode) {
            $jsonObj = [];
            if (!empty($zipCode->getZipCode())) {
                $jsonObj['zipcode'] = $zipCode->getZipCode();
            }
            if ($zipCode instanceof SmartyStreetsUSZipcodeInterface) {
                if (!empty($zipCode->getCity())) {
                    $jsonObj['city'] = $zipCode->getCity();
                }
                if (!empty($zipCode->getState())) {
                    $jsonObj['state'] = $zipCode->getState();
                }
            }
            $objs[] = $this->addInputIdJson($jsonObj, $zipCode);
        }

    }

    public function verifyInternationalAddress()
    {
        $url = $this->buildBaseUrl(self::VERIFY_INTERNATIONAL_URL);
    }

    public function autoCompleteUS()
    {
        $url = $this->buildBaseUrl(self::AUTO_COMPLETE_US_URL);
    }

    public function extractUS()
    {
        $url = $this->buildBaseUrl(self::EXTRACT_URL);
    }

    /**
     * @param string $base
     * @return string
     */
    private function buildBaseUrl($base)
    {
        return $base . '?auth-id=' . $this->authId . '&auth-token=' . $this->authToken;
    }

    /**
     * @param string $url
     * @return string
     * @throws SmartyStreetsException
     */
    private function httpGet($url)
    {
        // Initialize cURL
        $ch = curl_init();
        // Configure the cURL command
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        $jsonOutput = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->checkStatus($httpStatus);

        return $jsonOutput;
    }

    /**
     * @param string $url
     * @param string $jsonData
     * @return string
     * @throws SmartyStreetsException
     */
    private function httpPost($url, $jsonData)
    {
        // Initialize cURL
        $ch = curl_init();
        // Configure the cURL command
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        $jsonOutput = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->checkStatus($httpStatus);

        return $jsonOutput;
    }

    /**
     * @param $httpStatus
     * @throws SmartyStreetsException
     */
    private function checkStatus($httpStatus)
    {
        switch ($httpStatus)
        {
            case 200:
                continue;
                break;
            case 400:
                throw new SmartyStreetsException("SmartyStreets Bad input. Required fields missing from input or are malformed.");
                break;
            case 401:
                throw new SmartyStreetsException("SmartyStreets Unauthorized. Authentication failure; invalid credentials.");
                break;
            case 402:
                throw new SmartyStreetsException("SmartyStreets Payment required. No active subscription found.");
                break;
            case 500:
                throw new SmartyStreetsException("SmartyStreets Internal server error. General service failure; retry request.");
                break;
        }
    }

    /**
     * @param string $url
     * @param $obj
     * @return string
     */
    private function addInputIdQueryString($url, $obj) {
        if ($obj instanceof SmartyStreetsInputIdInterface) {
            if (!empty($obj->getInputId())) {
                $url .= '&input_id=' . $obj->getInputId();
            }
        }

        return $url;
    }

    /**
     * @param array $json
     * @param $obj
     * @return array
     */
    private function addInputIdJson(array $json, $obj) {
        if ($obj instanceof SmartyStreetsInputIdInterface) {
            if (!empty($obj->getInputId())) {
                $json['input_id'] = $obj->getInputId();
            }
        }

        return $json;
    }
}