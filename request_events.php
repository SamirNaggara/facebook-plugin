<?php //header('Content-Type: application/json');

$fb_page_id = "esn.paris"; 
        // id = 241547229389679 
$year_range = 1;

// automatically adjust date range
// human readable years
// $since_date = date('Y-m-d', strtotime('-' . $year_range . ' days'));
// $until_date = date('Y-12-31', strtotime('+' . $year_range . ' years'));
  
// unix timestamp years
$since_unix_timestamp = time();
$until_unix_timestamp = time() + 60*60*24*60; // 60 jours
  
// or you can set a fix date range:
// $since_unix_timestamp = strtotime("2012-01-08");
// $until_unix_timestamp = strtotime("2018-06-28");
  
// page access token
$access_token = "EAAHfzZBxG2JMBAGIqd6ZCU1sapEYZBLrkQVqxH5fP5Joe7P93z2D6oTs8rjlZCGgqmJNrxqvSpEm6bSvf46fpQizaqJsiirojS9xfLruZAg2k4rsoKgtTlmtqZA34KuvZA2XtDoY3kW8wtvcjboOZCd8k8rlGfEBJvDuSZC2bRGZBzFZCfE2bNRzt9B";


$fields="id,name,description,place,timezone,start_time,cover,ticket_uri,event_times";
  
$json_link = "https://graph.facebook.com/v11.0/{$fb_page_id}/events/attending/?fields={$fields}&access_token={$access_token}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
  
$json = file_get_contents($json_link);

file_put_contents("json_fb_events.json",$json,FILE_USE_INCLUDE_PATH);