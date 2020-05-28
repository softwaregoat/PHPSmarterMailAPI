<?php
/**
 * Created by PhpStorm.
 * User: GuangJun Zhao
 * Date: 5/28/2020
 * Time: 9:05 AM
 */

class SmarterMail
{
    private $token;
    public $doamin;
    public $username;
    public $password;
    public function getToken()
    {
        $curl = curl_init();
         $domain =  $this->doamin;
         $username = $this->username;
         $password = $this->password;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "{$domain}/api/v1/auth/authenticate-user",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{ \"username\": \"{$username}\", \"password\": \"{$password}\" }",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $json =json_decode($response, true);
        return $json['accessToken'];
    }

    public function get_domains(){
        $domains = [];
        try {
            $token = $this->getToken();
            $curl = curl_init();
            $domain = $this->doamin;

            curl_setopt_array($curl, array(
                CURLOPT_URL => "{$domain}api/v1/settings/sysadmin/domain-names",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$token}"
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $json_r = json_decode($response, true);
            if ($json_r['success']) {
                foreach ($json_r['data'] as $data) {
                    $domains[] = $data['name'];
                }
            }
        }
        catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return $domains;
    }
    public function get_users($domain){
        $user_email = [];
        try{
            $token = $this->getToken();
            $domain1 =  $this->doamin;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "{$domain1}api/v1/settings/sysadmin/list-users/{$domain}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$token}"
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $json_r = json_decode($response, true);
            if ( $json_r['message']){
                foreach ($json_r['userData'] as $user)
                {
                    $user_email[] = $user['emailAddress'];
                }
            }
        }
        catch (Exception $ex)
        {
            echo $ex->getMessage();
        }
        return $user_email;
    }
}