<?php

class Postman
{
    protected function getData($method, $data)
    {
        $key = 'WPtYSK9PJGOI23';
        $url = 'http://api.travia.info/v1/hotel/' . $method;
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic ' . base64_encode(":" . $key)
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        return CJSON::decode($response);
    }

    protected function checkResult($result)
    {
        if (isset($result['error'])) {
            if ($result['error']['name'] == 'Request Expired')
                return -1;
            return 0;
        } else
            return 1;
    }

    public function autoComplete($query)
    {
        $data = '{"autoCompleteRq":{"query":"' . $query . '","domestic":false}}';
        $result = $this->getData('autocomplete', $data);

        if ($this->checkResult($result) == -1)
            return -1;

        return $result['autoCompleteRs'];
    }

    public function search($destinationCode, $isCity, $inDate, $outDate, $rooms)
    {
        $data = '{"searchRq":{"destinationCode":"' . $destinationCode . '","isCity":' . (($isCity) ? 'true' : 'false') . ',"inDate":"' . $inDate . '","outDate":"' . $outDate . '","rooms":' . $rooms . ',"nationality":"IR","domestic":false}}';
        $result = $this->getData('search', $data);

        if ($this->checkResult($result) == -1)
            return -1;

        return $result['searchRs'];
    }

    public function details($traviaID, $searchID)
    {
        $data = '{"detailsRq":{"traviaId":"' . $traviaID . '","searchId":"' . $searchID . '"}}';
        $result = $this->getData('details', $data);

        if ($this->checkResult($result) == -1)
            return -1;

        return $result['detailsRs'];
    }

    public function priceDetails($traviaID, $searchID)
    {
        $data = '{"priceDetailsRq":{"traviaId":"' . $traviaID . '","searchId":"' . $searchID . '"}}';
        $result = $this->getData('pricedetails', $data);

        if ($this->checkResult($result) == -1)
            return -1;

        return $result['priceDetailsRs'];
    }

    public function checkAvailability($traviaID)
    {
        $data = '{"availabilityRq":{"traviaId":"' . $traviaID . '"}}';
        //$result = $this->getData('availability', $data);
        //return $result['availabilityRs'];
        return array('price' => true);
    }

    public function book($traviaID, $searchID, $roomPeople, $contactInfo)
    {
        $roomPeople = CJSON::encode($roomPeople);
        $data =
            '{"bookRq":
                {
                    "traviaId":"' . $traviaID . '",
                    "searchId":"' . $searchID . '",
                    "roomPeople":[' . $roomPeople . '],
                    "contactInfo":{
                        "mobile":"'.$contactInfo['mobile'].'",
                        "email":"'.$contactInfo['email'].'"
                    }
                }
            }';
        $result = $this->getData('book', $data);

        if ($this->checkResult($result) == -1)
            return -1;

        return $result;
    }
}