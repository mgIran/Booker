<?php

class Postman
{
    protected function getData($method, $data)
    {
        $key = 'R204F3J6IMKU82';
        $url = 'http://travia.global/v1/hotel/' . $method;
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

    public function autoComplete($query)
    {
        $data = '{"autoCompleteRq":{"query":"' . $query . '","domestic":false}}';
        $result = $this->getData('getautocomplete', $data);
        return $result['autoCompleteRs'];
    }

    public function search($destinationCode, $isCity, $inDate, $outDate, $rooms)
    {
        $data = '{"searchRq":{"destinationCode":"' . $destinationCode . '","isCity":' . (($isCity) ? 'true' : 'false') . ',"inDate":"' . $inDate . '","outDate":"' . $outDate . '","rooms":' . $rooms . ',"nationality":"IR","domestic":false}}';
        $result = $this->getData('search', $data);
        return $result['searchRs'];
    }

    public function details($traviaID)
    {
        $data = '{"detailsRq":{"traviaId":"' . $traviaID . '"}}';
        $result = $this->getData('details', $data);
        return $result['detailsRs'];
    }
}