<?php
ini_set('display_errors', 1);
require_once('../Libraries/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "1941543840-wE4H2wiNYCkhntlz1S3VCpUp7LgarDO5pVTvUvY",
    'oauth_access_token_secret' => "cOaUejPWG4CD4Fmpsxna8HupZsaKrOVJI6fWFojhsDw",
    'consumer_key' => "406VHA1QGnDS2Q6kXEXYdQ",
    'consumer_secret' => "ohgDRczU3BxEbqQkpGV3USB9NexmrcZwrhTxvPkznkk"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
// $url = 'https://api.twitter.com/1.1/blocks/create.json';
// $requestMethod = 'POST';

/** POST fields required by the URL above. See relevant docs as above **/
// $postfields = array(
//     'screen_name' => 'usernameToBlock', 
//     'skip_status' => '1'
// );

/** Perform a POST request and echo the response **/
// $twitter = new TwitterAPIExchange($settings);
// echo $twitter->buildOauth($url, $requestMethod)
//              ->setPostfields($postfields)
//              ->performRequest();

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=LSWebApps';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$json_results_of_tweets = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

$tweets_array = json_decode($json_results_of_tweets);

echo "<pre>";

print_r($tweets_array);

echo "</pre>";
