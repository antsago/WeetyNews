<?php

// Goes to twitter api and adds new tweets to our database from
// the list of new papers we have

require('services/newspaper_service.php');
require('services/tweet_service.php');
require('services/alchemy_service.php');

$news_paper_service = new NewsPaperService();
$tweet_service = new TweetService();
$alchemy_service = new AlchemyService();

//Get all the chunks of text from twitter newspapers
$agregatedTweets = array();

$news_papers = $news_paper_service->get_all_news_papers();

foreach($news_papers as $news_paper)
{
    $tweets_from_twitter = $tweet_service->get_tweets_list_for_newspaper($news_paper->twitter_url);
	$stored_tweets = $tweet_service->store_tweets_for_newspaper($news_paper, $tweets_from_twitter);
	$translated_tweets = $tweet_service->tranlate_tweets($stored_tweets);
	$agregatedTweets[] = $tweet_service->agregate($translated_tweets);
}

foreach ($agregatedTweets as $agregatedTweet) {
	$extracted_keywords[] = $alchemy_service->extract_entities($agregatedTweet);
	echo "---------------////////////////////////////////---------------------";
}
print_r($extracted_keywords);




?>
