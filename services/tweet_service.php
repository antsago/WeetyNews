<?php

require_once(__DIR__."/../models/Model.php");
require_once(__DIR__.'/../Libraries/TwitterAPIExchange.php');
require_once(__DIR__."/translation_service.php");

/**
* 
*/
class TweetService
{

	public $translationService;
	public function __construct(){
  	        $this->translationService = new TranslationService();
	}

	public function get_tweets_list_for_newspaper($newspaper_twitter_url){
		/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
		$settings = array(
		    'oauth_access_token' => "1941543840-wE4H2wiNYCkhntlz1S3VCpUp7LgarDO5pVTvUvY",
		    'oauth_access_token_secret' => "cOaUejPWG4CD4Fmpsxna8HupZsaKrOVJI6fWFojhsDw",
		    'consumer_key' => "406VHA1QGnDS2Q6kXEXYdQ",
		    'consumer_secret' => "ohgDRczU3BxEbqQkpGV3USB9NexmrcZwrhTxvPkznkk"
		);

		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

		$exploded = explode('https://twitter.com/', $newspaper_twitter_url);
		$getfield = '?screen_name='.end($exploded);

		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange($settings);
		$json_results_of_tweets = $twitter->setGetfield($getfield)
		             ->buildOauth($url, $requestMethod)
		             ->performRequest();

		$tweets_array = json_decode($json_results_of_tweets);

		return $tweets_array;
	}


	public function store_tweets_for_newspaper($newspaper, $tweets_from_twitter){

		$stored_newspaper_tweets = array();

		foreach($tweets_from_twitter as $single_tweet){

			$tweeted_at = $single_tweet->created_at;
			$news_paper_id = $newspaper->id;
			
			$new_tweet = Tweet::create(array(
						'tweeted_at' => date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $tweeted_at))),
						'newspaper_id' => $news_paper_id
					));
			

			$tweet_text = $this->extract_tweet_text_from_tweet_object($single_tweet);

			$stored_newspaper_tweets[] = TweetText::create(array(
						'text' => $tweet_text,
						'tweet_id' => $new_tweet->id,
						'language_id' => $newspaper->language_id
				        ));
		}

		return $stored_newspaper_tweets;
	}

	// TODO: I guess we can dich all the comments below???
		// $tweets_array = $this->get_tweets_for_newspaper($news_paper->twitter_url);
		// $time = time();
		// $list_of_files = array();

		// // Contains a concatenated texts for all tweets 
		// // for a single newspaper
		// $tweet_texts_combined = "";

		// foreach($tweets_array as $tweet){

		// 	$tweet_text = $tweet->text;
		// 	$urls_array = $tweet->entities->urls;
		// 	$mentions_array = $tweet->entities->user_mentions;

		// 	// print_r($urls_array);
		// 	if(is_array($urls_array)){
		// 		foreach ($urls_array as $url) {
		// 			$tweet_text = str_replace(trim($url->url), '', $tweet_text);
		// 		}

		// 		// print_r($url->url);
		// 	}

		// 	foreach ($mentions_array as $mention) {
		// 		$tweet_text = str_replace('@'.$mention->screen_name, '', $tweet_text);
		// 	}

		// 	$tweet_text = str_replace('#', '', $tweet_text);

		// 	$tweet_texts_combined .= $tweet_text;

		// 	echo $tweet_text.'<br><br>';
		// }

		// $filename = 'tweetfile'.$time;
		// $this->make_tweet_file($filename, $tweet_text);
		// $list_of_files[] = $filename;

		// implode(' ', $list_of_files);

		// print_r($tweets_array);

	private function extract_tweet_text_from_tweet_object($tweet){
		$tweet_text = $tweet->text;
		$urls_array = $tweet->entities->urls;
		$mentions_array = $tweet->entities->user_mentions;

		//TODO: are we sure we want to do all this?
		
		//Remove URLs
		if(is_array($urls_array)){
			foreach ($urls_array as $url) {
				$tweet_text = str_replace(trim($url->url), '', $tweet_text);
			}

		}

		//Remove mentions
		foreach ($mentions_array as $mention) {
			$tweet_text = str_replace('@'.$mention->screen_name, '', $tweet_text);
		}

		//Remove topics
		$tweet_text = str_replace('#', '', $tweet_text);

		return $tweet_text;
	}

	private function make_tweet_file($filename, $file_contents){

		file_put_contents ('tweet_files/'.$filename , $file_contents);
	}

	public function calculate_word_weights(){
		$filename = 'tweet_files/listtweets.weights';

		$lines_array = file($filename);
		$ranks = array();

		// print_r($lines_array);

		foreach ($lines_array as $line) {
			$split_items = explode(':  ', $line);
			$word = $split_items[0];

			$ranks[$word] = 0;

			$values = $split_items[1];
			$values = explode(' ', $values);

			foreach ($values as $value) {
				$value = explode(':', $value);
				$value = $value[1];

				$ranks[$word] += $value;
			}
		}

		arsort($ranks);

		print_r($ranks);
	}
	

	public function tranlate_tweets($original_tweets)
	{
	  $translated_tweets = array();

	  
	  foreach ($original_tweets as $original_tweet)
	  {
	    $original_text = $original_tweet->text;
	    $original_language_id = $original_tweet->language_id;
	    $original_lang = Language::find_by_id($original_language_id)->code;
	    $target_lang = "en";
	    $target_lang_id = 1;

	    //Check if tweet is already in english:
	    if($original_lang == $target_lang)
	    {
	      //So that we don't lose things
	      $translated_tweets[] = $original_tweet;
	    }
	    else
	    {
	      //Translate
	      $translatedText = $this->translationService->translate($original_text, $original_lang, $target_lang);

	      //Save in database
	      $translated_tweets[] = TweetText::create(array(
						  'text' => $translatedText,
						  'tweet_id' => $original_tweet->tweet_id,
						  'language_id' => $target_lang_id
				     ));
	    }
	  }

	  return $translated_tweets;
	}


	public function agregate($tweets)
	{
	  $agregatedTweet = "";
	  foreach($tweets as $tweet)
	  {
	    $agregatedTweet .= $tweet->text . "\n";
	  }
	  return $agregatedTweet;
	}
}
