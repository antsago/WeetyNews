<?php

// Does the backend processing to renew the topics in the database


require('services/newspaper_service.php');
require('services/tweet_service.php');
require('services/alchemy_service.php');
require('services/topics_service.php');

//Services
$news_paper_service = new NewsPaperService();
$tweet_service = new TweetService();
$alchemy_service = new AlchemyService();
$topics_service = new TopicService();

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


//Extract entities from newspaper chunks
foreach ($agregatedTweets as $agregatedTweet) {
	$extracted_entities[] = $alchemy_service->extract_entities($agregatedTweet);
}

//Find the more relevant entities
$final_entities = $topics_service->sum_entities($extracted_entities);

//Store the topics!!!!!!!
$topics_service->store_topics($final_entities);
print_r($final_entities);

?>
