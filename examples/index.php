<?php


include '../vendor/autoload.php';

$request = new \PV\RequestOut();

$request->setTargetUrl('https://graph.facebook.com/343049269118318');//
// will set params as eg: ?access_token=access_token
//will set params as post

$request->setParams(['access_token' => 'access_token']);
$request->addHeader(['Authorization' => 'Bearer access_token']);//add header
$request->addHeaders([
    'header1' => 'value1',
    'header2' => 'value2',
]);//appends multiple headers

$request->get();//for get request
$request->post(); //for post request
$request->postJson(); //to post data as json
