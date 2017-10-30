<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Nette\Mail\Message;

class Vue extends CI_Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $curl = new Curl\Curl();
        $curl->setUserAgent('Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1');
        $curl->setReferrer('http://cnodejs.org');
        //curl_setopt($curl->curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl->curl, CURLOPT_SSL_VERIFYHOST, false);

        $curl->get(
            'http://cnodejs.org/api/v1/topics'
        );
        $curl->close();
        if ($curl->error) {
            echo $curl->error_code . '|';
            exit;
        } else {
            //log_message('debug', $curl->response);
            $dir = '/www/wwwroot/www.hijs.cc/api/v1/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            file_put_contents($dir . 'topics.json', $curl->response);
        }
    }

}
