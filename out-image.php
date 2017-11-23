<?php

require_once('./vendor/autoload.php');

// Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\ImageMessageBuilder;

// Token
$channel_token = '2MCOyCeaBipmw3ZzJG8BrsiO4KzCoaoPddMgbZtEu5HHVeIaWU+PDKcCZRJEY76zqxv56d15kZeMoU/vQ0zuzPFlbhFM7AhRMZwLrSkLdciLCuKUgV6aFrvAAuuG1mMWe7DCzfEW9FfHQhJR4F/m0AdB04t89/1O/w1cDnyilFU=';
$channel_secret = 'd4afd7da941ac195c155fe67dcb5a338';

// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

	// Loop through each event
	foreach ($events['events'] as $event) {
    
        // Get replyToken
        $replyToken = $event['replyToken'];

        // Image
        $originalContentUrl = 'https://cdn.shopify.com/s/files/1/1217/6360/products/Shinkansen_Tokaido_ShinFuji_001_1e44e709-ea47-41ac-91e4-89b2b5eb193a_grande.jpg?v=1489641827';
        $previewImageUrl = 'https://cdn.shopify.com/s/files/1/1217/6360/products/Shinkansen_Tokaido_ShinFuji_001_1e44e709-ea47-41ac-91e4-89b2b5eb193a_grande.jpg?v=1489641827';

        $httpClient = new CurlHTTPClient($channel_token);
        $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));

        $textMessageBuilder = new ImageMessageBuilder($originalContentUrl, $previewImageUrl);
        $response = $bot->replyMessage($replyToken, $textMessageBuilder);
        
	}
}

echo "OK";
