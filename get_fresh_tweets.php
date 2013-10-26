<?php

// Goes to twitter api and adds new tweets to our database from
// the list of new papers we have

require('services/newspaper_service.php');
require('services/tweet_service.php');

$news_paper_service = new NewsPaperService();
$tweet_service = new TweetService();

$news_papers = $news_paper_service->get_all_news_papers();

foreach($news_papers as $news_paper){
	$tweets_from_twitter = $tweet_service->get_tweets_list_for_newspaper($news_paper->twitter_url);
	$stored_tweets = $tweet_service->store_tweets_for_newspaper($news_paper, $tweets_from_twitter);
	print_r($stored_tweets);
	// $tweet_service->calculate_word_weights();
}

// var_dump($news_papers);