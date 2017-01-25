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

    protected function hasError($result)
    {
        if (isset($result['error']) or in_array('Internal Server Error', $result) or is_null($result)) {
            if(!file_exists('errors'))
                mkdir('errors');
            $fp = fopen('errors/result-'.date('Y-m-d-H-i', time()).'.json', 'w');
            fwrite($fp, json_encode($result));
            fclose($fp);
            return true;
        }else
            return false;
    }

    public function autoComplete($query)
    {
        $data = '{"autoCompleteRq":{"query":"' . $query . '","domestic":false}}';
        $result = $this->getData('autocomplete', $data);

        if ($this->hasError($result))
            throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');

        return $result['autoCompleteRs'];
    }

    public function search($destinationCode, $isCity, $inDate, $outDate, $rooms, $limit = 100)
    {
        if ($isCity)
            $data = '{"searchRq":{"destinationCode":"' . $destinationCode . '","isCity":' . (($isCity) ? 'true' : 'false') . ',"inDate":"' . $inDate . '","outDate":"' . $outDate . '","rooms":' . $rooms . ',"nationality":"IR","domestic":false,"limit":' . $limit . '}}';
        else
            $data = '{"searchRq":{"destinationCode":"' . $destinationCode . '","isCity":' . (($isCity) ? 'true' : 'false') . ',"inDate":"' . $inDate . '","outDate":"' . $outDate . '","rooms":' . $rooms . ',"nationality":"IR","domestic":false}}';
        $result = $this->getData('search', $data);

        if ($this->hasError($result))
            throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');

        return $result['searchRs'];
    }

    public function loadMore($page)
    {
        $data = '{"searchRq":{"page":"' . $page . '","domestic":false}}';
        $result = $this->getData('search', $data);

        if ($this->hasError($result))
            throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');

        return $result['searchRs'];
    }

    public function details($traviaID, $searchID)
    {
        $data = '{"detailsRq":{"traviaId":"' . $traviaID . '","searchId":"' . $searchID . '"}}';
        $result = $this->getData('details', $data);

        if ($this->hasError($result))
            throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');

        return $result['detailsRs'];
    }

    public function priceDetails($traviaID, $searchID)
    {
        $data = '{"priceDetailsRq":{"traviaId":"' . $traviaID . '","searchId":"' . $searchID . '"}}';
        $result = $this->getData('pricedetails', $data);

        if ($this->hasError($result))
            throw new CHttpException(212, 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!');

        return $result['priceDetailsRs'];
    }

    public function book($traviaID, $searchID, $roomPeople, $contactInfo)
    {
        $roomPeople = CJSON::encode($roomPeople);
        $data =
            '{"bookRq":
                {
                    "traviaId":"' . $traviaID . '",
                    "searchId":"' . $searchID . '",
                    "roomPeople":' . $roomPeople . ',
                    "contactInfo":{
                        "mobile":"' . $contactInfo['mobile'] . '",
                        "email":"' . $contactInfo['email'] . '"
                    }
                }
            }';
        $result = $this->getData('book', $data);

        if(!file_exists('bookings'))
            mkdir('bookings');
        $fp = fopen('bookings/result-'.date('Y-m-d-H-i', time()).'.json', 'w');
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