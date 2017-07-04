<?php

class FlightPostman
{
    protected function getData($method, $data)
    {
        $url = 'http://api.travia.info/v1/flight/' . $method;
        $key = 'WPtYSK9PJGOI23';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "gzip",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "authorization: Basic OldQdFlTSzlQSkdPSTIz",
                "cache-control: no-cache",
                //"postman-token: e91f2dc1-4721-61cd-f587-61598d450ad5"
            ],
        ]);
        $response = curl_exec($curl);
        $result = CJSON::decode($response);
        curl_close($curl);
        return $result;
    }

    protected function hasError($result)
    {
        if (isset($result['error']) or in_array('Internal Server Error', $result) or is_null($result)) {
            if(!file_exists('errors'))
                mkdir('errors');
            $fp = fopen('errors/flight-result-'.date('Y-m-d-H-i', time()).'.json', 'w');
            fwrite($fp, json_encode($result));
            fclose($fp);
            return true;
        }else
            return false;
    }

    public function autoComplete($query)
    {
        $data = '{"autoCompleteRq":{"query":"' . $query . '"}}';
        $result = $this->getData('autocomplete', $data);

        if ($this->hasError($result))
            throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');

        return $result['autoCompleteRs'];
    }

    public function search($domestic, $origin, $destination, $date, $rDate = null, $adult, $child, $infant, $class, $fromIsCity, $toIsCity)
    {
        $data = '{"searchRq":{ "domestic":' . $domestic . ', "origin":"' . $origin . '", "destination":"' . $destination . '", "date":"' . $date . '", "rDate":"' . ($rDate?$rDate:'') . '", "adult":"' . $adult . '", "child":"' . $child. '", "infant":"' . $infant. '", "class":"' . $class. '", "fromIsCity":"' . $fromIsCity. '", "toIsCity":"' . $toIsCity. '" }}';
        $result = $this->getData('search', $data);

        if ($this->hasError($result)) {
            if($result['error']['name'] == 'No Data')
                return array();
            else
                throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');
        }

        return $result['searchRs'];
    }

    public function priceDetails($oneWayTraviaID, $returnTraviaID=null, $searchID)
    {
        $data = '{"priceDetailsRq":{
            "flights":{
                "oneWay":{
                    "traviaId": "' . $oneWayTraviaID . '"
                }';
        if ($returnTraviaID)
            $data .= ',
                "return":{
                    "traviaId": "' . $returnTraviaID . '"
                }
            ';
        $data .= '},
            "searchId": "' . $searchID . '"
        }}';
        $result = $this->getData('pricedetail', $data);

        if ($this->hasError($result))
            throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');

        return $result['priceDetailsRs'];
    }

    public function book($searchID, $oneWayTraviaID, $returnTraviaID, $passengers, $contactInfo)
    {
        $passengers = CJSON::encode($passengers);
        $data ='{"bookRq":{
            "searchId":"' . $searchID . '",
            "flights":{
                "oneWay": {
                    "traviaId": "'.$oneWayTraviaID.'"
                },
                "return": {
                    "traviaId": "'.$returnTraviaID.'"
                }
            },
            "passengers":' . $passengers . ',
            "contactInfo":{
                "mobile":"' . $contactInfo['mobile'] . '",
                "email":"' . $contactInfo['email'] . '"
            },
            "test":true
        }}';
        $result = $this->getData('book', $data);

        if(!file_exists('bookings'))
            mkdir('bookings');
        $fp = fopen('bookings/flight-result-'.date('Y-m-d-H-i', time()).'.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);

        return $result;
    }

    public function cancel($orderID, $traviaID)
    {
        $data = '{"cancelRq":{"orderId":"' . $orderID . '", "traviaId":"' . $traviaID . '"}}';
        $result = $this->getData('cancel', $data);

        if ($this->hasError($result))
            throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');

        return $result['cancelRs'];
    }
}