<?php
require_once('./vendor/autoload.php');

// Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;

use \LINE\LINEBot;

use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token =
'yjBtwbJsQU9xYHkUIDswtYkn4z4hC0eYbWYvTY4pYrABSNAHwwLXOLh61iF64WA5liHg1hzrd0HnC5ya3cLCOISlJZEG1BjGy0mDJ/XtOgtCKeRPzHSY3BTQmyJw5ByxTRQieEwSZoQWXURGQgodGwdB04t89/1O/w1cDnyilFU=';

$channel_secret = 'a6828dff8c16162227198d1ef3467c68';

// Get message from Line API
$content = file_get_contents('php://input');

$events = json_decode($content, true);

if (!is_null($events['events'])) {
    // 	Loop through each event
    foreach ($events['events'] as $event) {
        // 		Line API send a lot of event type, we interested in message only.
        if ($event['type'] == 'message') {
			//Get replyToken
			$replyToken = $event['replyToken'];
            switch ($event['message']['type']) {
                case 'text':               
                	//Reply message
                	$respMessage = 'Hello, your message is '. $event['message']['text'];
				break;
				case 'image':
					$messageID = $event['message']['id']; 
					$respMessage = 'Hello, your image ID is '. $messageID;
				break;
				case 'sticker': 
					$messageID = $event['message']['packageId']; 
					// Reply message 
					$respMessage = 'Hello, your Sticker Package ID is '. $messageID; 
				break;
			}
			$httpClient = new CurlHTTPClient($channel_token);		
			$bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));			
			$textMessageBuilder = new TextMessageBuilder($respMessage);			
			$response = $bot->replyMessage($replyToken, $textMessageBuilder);
        }
    }
}


echo 'OK';
