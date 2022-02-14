<?php


class API
{
    const key = "pk.eyJ1IjoibnU5OWV0eiIsImEiOiJja2cwOXdiaHkwc2VhMnFyMDh0dzN6amh2In0.8UMoP_3ozYme9HN4mHsl5g";
    const googleKey = "AIzaSyAaaeudr0aGKQE1PeiWeQ3cmxSTRQwcLHA";

    public static function getKeyMapbox()
    {
        $response = [
            "status" => 200,
            "key" => static::key
        ];
        return json_encode($response);
    }

    public static function getAPIData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    public static function postRAW($data, $url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result, true);
    }

    public static function putRAW($data, $url, $method = "PUT")
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result, true);
    }

    public static function deleteData($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}
