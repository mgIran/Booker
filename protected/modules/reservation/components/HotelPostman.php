<?php

class HotelPostman
{
    protected function getData($method, $data)
    {
        $url = 'http://api.travia.info/v1/hotel/' . $method;
        $key = 'WPtYSK9PJGOI23';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic ".base64_encode(":" . $key),
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));
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
            $fp = fopen('errors/hotel-result-'.date('Y-m-d-H-i', time()).'.json', 'w');
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
        $fp = fopen('bookings/hotel-result-'.date('Y-m-d-H-i', time()).'.json', 'w');
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