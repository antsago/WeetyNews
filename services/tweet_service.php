<?php

require(__DIR__."/../models/Tweet.php");
require_once(__DIR__.'/../TwitterAPIExchange.php');


/**
* 
*/
class TweetService
{
	public function __construct(){

		/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
		$settings = array(
		    'oauth_access_token' => "1941543840-wE4H2wiNYCkhntlz1S3VCpUp7LgarDO5pVTvUvY",
		    'oauth_access_token_secret' => "cOaUejPWG4CD4Fmpsxna8HupZsaKrOVJI6fWFojhsDw",
		    'consumer_key' => "406VHA1QGnDS2Q6kXEXYdQ",
		    'consumer_secret' => "ohgDRczU3BxEbqQkpGV3USB9NexmrcZwrhTxvPkznkk"
		);

		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield = '?screen_name=LSWebApps';
		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange($settings);
		$json_results_of_tweets = $twitter->setGetfield($getfield)
		             ->buildOauth($url, $requestMethod)
		             ->performRequest();

		$tweets_array = json_decode($json_results_of_tweets);
		$this->tweets_array = $tweets_array;
	}


	public function add_raw_tweet_details($twitter_url){
		print_r($this->tweets_array);
	}
}