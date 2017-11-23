<?php
/*
 {
  "events": [
      {
        "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
        "type": "message",
        "timestamp": 1462629479859,
        "source": {
             "type": "user",
             "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
         },
         "message": {
             "id": "325708",
             "type": "text",
             "text": "Hello, world"
          }
      }
  ]
}
 */

include ('vendor/autoload.php');

// Namespace
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

// Token
$channel_token = 'bjjrcUYB02T4Qfh42Qqg+D91JiLYAit7F5OSiXMAynf5X4qi3m/ebpCKkgoOg2ZuliHg1hzrd0HnC5ya3cLCOISlJZEG1BjGy0mDJ/XtOguEW4LFQjDw17mqJH0VgDhukKEoJiXpRqh2XW1Aka2SLwdB04t89/1O/w1cDnyilFU=';
$channel_secret = 'a6828dff8c16162227198d1ef3467c68';

// Get message from Line API
$content = file_get_contents('php://input');
error_log( $content );
$events = json_decode($content, true);
error_log($events['events']);
if (!is_null($events['events'])) {

	// Loop through each event
	foreach ($events['events'] as $event) {
    
        // Line API send a lot of event type, we interested in message only.
		if ($event['type'] == 'message') {

            switch($event['message']['type']) {
                
                case 'text':
                    // Get replyToken
                    $replyToken = $event['replyToken'];
        
                    // Reply message
                    $respMessage = 'Hello, your message is '. $event['message']['text'];
            
                    $httpClient = new CurlHTTPClient($channel_token);
                    error_log( $httpClient );
                    $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
        
                    $textMessageBuilder = new TextMessageBuilder($respMessage);
                    $response = $bot->replyMessage($replyToken, $textMessageBuilder);
                    
                    break;
            }
		}
	}
}

echo "OK";
