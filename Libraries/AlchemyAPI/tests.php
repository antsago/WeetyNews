<?php
	require_once('alchemyapi.php');
	$alchemyapi = new AlchemyAPI();


	$test_text = 'Bob broke my heart, and then made up this silly sentence to test the PHP SDK';  
	$test_html = '<html><head><title>The best SDK Test | AlchemyAPI</title></head><body><h1>Hello World!</h1><p>My favorite language is PHP</p></body></html>';
	$test_url = 'http://www.nytimes.com/2013/07/13/us/politics/a-day-of-friction-notable-even-for-a-fractious-congress.html?_r=0';


	//Entities
	echo 'Checking entities . . . ', PHP_EOL;
	$response = $alchemyapi->entities('text',$test_text,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->entities('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->entities('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Entity tests complete!', PHP_EOL, PHP_EOL;


	//Keywords
	echo 'Checking keywords . . . ', PHP_EOL;
	$response = $alchemyapi->keywords('text',$test_text,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->keywords('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->keywords('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Keyword tests complete!', PHP_EOL, PHP_EOL;


	//Concepts
	echo 'Checking concepts . . . ', PHP_EOL;
	$response = $alchemyapi->concepts('text',$test_text,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->concepts('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->concepts('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Concept tests complete!', PHP_EOL, PHP_EOL;


	//Sentiment
	echo 'Checking sentiment . . . ', PHP_EOL;
	$response = $alchemyapi->sentiment('text',$test_text,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->sentiment('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->sentiment('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Sentiment tests complete!', PHP_EOL, PHP_EOL;


	//Sentiment Targeted
	echo 'Checking targeted sentiment . . . ', PHP_EOL;
	$response = $alchemyapi->sentiment_targeted('text',$test_text,'heart',null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->sentiment_targeted('html',$test_html,'language',null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->sentiment_targeted('url',$test_url,'investor',null);
	assert($response['status'] == 'OK');
	echo 'Targeted sentiment tests complete!', PHP_EOL, PHP_EOL;


	//Text
	echo 'Checking clean text . . . ', PHP_EOL;
	$response = $alchemyapi->text('text',$test_text,null);
	assert($response['status'] == 'ERROR'); //text only works on html and url content
	$response = $alchemyapi->text('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->text('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Clean text tests complete!', PHP_EOL, PHP_EOL;


	//Text Raw
	echo 'Checking raw text . . . ', PHP_EOL;
	$response = $alchemyapi->text_raw('text',$test_text,null);
	assert($response['status'] == 'ERROR'); //text_raw only works on html and url content
	$response = $alchemyapi->text_raw('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->text_raw('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Raw text tests complete!', PHP_EOL, PHP_EOL;


	//Author
	echo 'Checking author . . . ', PHP_EOL;
	$response = $alchemyapi->author('text',$test_text,null);
	assert($response['status'] == 'ERROR'); //author only works on html and url content
	$response = $alchemyapi->author('html',$test_html,null);
	assert($response['status'] == 'ERROR'); //there is no author listed in the test HTML content
	$response = $alchemyapi->author('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Author tests complete!', PHP_EOL, PHP_EOL;


	//Language
	echo 'Checking language . . . ', PHP_EOL;
	$response = $alchemyapi->language('text',$test_text,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->language('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->language('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Language tests complete!', PHP_EOL, PHP_EOL;

	
	//Title
	echo 'Checking title . . . ', PHP_EOL;
	$response = $alchemyapi->title('text',$test_text,null);
	assert($response['status'] == 'ERROR'); //title only works on html and url content
	$response = $alchemyapi->title('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->title('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Title tests complete!', PHP_EOL, PHP_EOL;

	
	//Relations
	echo 'Checking relations . . . ', PHP_EOL;
	$response = $alchemyapi->relations('text',$test_text,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->relations('html',$test_html,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->relations('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Relations tests complete!', PHP_EOL, PHP_EOL;

	
	//Category
	echo 'Checking category . . . ', PHP_EOL;
	$response = $alchemyapi->category('text',$test_text,null);
	assert($response['status'] == 'OK');
	$response = $alchemyapi->category('html',$test_html,array('url'=>'test'));
	assert($response['status'] == 'OK');	
	$response = $alchemyapi->category('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Category tests complete!', PHP_EOL, PHP_EOL;

	
	//Feeds
	echo 'Checking feeds . . . ', PHP_EOL;
	$response = $alchemyapi->feeds('text',$test_text,null);
	assert($response['status'] == 'ERROR'); //feeds only works on html and url content
	$response = $alchemyapi->feeds('html',$test_html,array('url'=>'test'));
	assert($response['status'] == 'OK');
	$response = $alchemyapi->feeds('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Feed tests complete!', PHP_EOL, PHP_EOL;

	
	//Microformats
	echo 'Checking microformats . . . ', PHP_EOL;
	$response = $alchemyapi->microformats('text',$test_text,null);
	assert($response['status'] == 'ERROR'); //microformats only works on html and url content
	$response = $alchemyapi->microformats('html',$test_html,array('url'=>'test'));
	assert($response['status'] == 'OK');
	$response = $alchemyapi->microformats('url',$test_url,null);
	assert($response['status'] == 'OK');
	echo 'Microformat tests complete!', PHP_EOL, PHP_EOL;

	echo '**** All tests are complete! ****', PHP_EOL;
?>
