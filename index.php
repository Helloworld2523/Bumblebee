<?php
 {
  "events": [
      {
        "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
        "type": "message",
        "timestamp": 1462629479859,
        "source": {
             "type": "user",
             "userId": "U429a778a323273a66c02f6846bd88e22"
         },
         "message": {
             "id": "325708",
             "type": "text",
             "text": "Hello, world"
          }
      }
  ]
}

require_once('./vendor/autoload.php');
// Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
// Token
$channel_token = 'PEYQ9LDlWMlOhydE6hbCsPKqMzGUZr9y1D+b86E97TTliLv6Hu432yS/T8O9P4MXliHg1hzrd0HnC5ya3cLCOISlJZEG1BjGy0mDJ/XtOgtDK9z5qM6T7Vvhh2/lQo7ijAvJIgr7Im3dCJwLKfaFwQdB04t89/1O/w1cDnyilFU=';
$channel_secret = 'a6828dff8c16162227198d1ef3467c68';
// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);
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
                    $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
        
                    $textMessageBuilder = new TextMessageBuilder($respMessage);
                    $response = $bot->replyMessage($replyToken, $textMessageBuilder);
                    
                    break;
            }
		}
	}
}
echo "OK";
