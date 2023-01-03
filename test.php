<?php //header('Content-Type: application/json');

$fb_page_id = "esn.paris"; 
        // id = 241547229389679 
$year_range = 1;

// automatically adjust date range
// human readable years
$since_date = date('Y-m-d');
$until_date = date('Y-12-31', strtotime('+' . $year_range . ' years'));
  
// unix timestamp years
$since_unix_timestamp = time();
$until_unix_timestamp = time() + 90*60*24*120;
  
// or you can set a fix date range:
// $since_unix_timestamp = strtotime("2012-01-08");
// $until_unix_timestamp = strtotime("2018-06-28");

echo $until_unix_timestamp;
// page access token
$access_token = "EAAHfzZBxG2JMBAGIqd6ZCU1sapEYZBLrkQVqxH5fP5Joe7P93z2D6oTs8rjlZCGgqmJNrxqvSpEm6bSvf46fpQizaqJsiirojS9xfLruZAg2k4rsoKgtTlmtqZA34KuvZA2XtDoY3kW8wtvcjboOZCd8k8rlGfEBJvDuSZC2bRGZBzFZCfE2bNRzt9B";


$fields="id,name,description,place,timezone,start_time,cover,ticket_uri,event_times";
  
$json_link = "https://graph.facebook.com/v11.0/{$fb_page_id}/events/attending/?fields={$fields}&access_token={$access_token}&since=$since_unix_timestamp&until=$until_unix_timestamp";
  
$json = file_get_contents($json_link);


$obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
echo "<pre>";
//print_r($obj);
echo "</pre>";
//file_put_contents("json_fb_events.json",$json,FILE_USE_INCLUDE_PATH);


//ce qui est supposé etre dans index
$event_count = count($obj['data']);
echo $event_count;
for ($x=0;$x<$event_count;$x++){
        echo $obj['data'][$x]['name'] . " - " . $obj['data'][$x]['start_time'] . "<br>" ;
}