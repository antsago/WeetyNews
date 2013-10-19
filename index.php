<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="WeetyNews.css" />
        <title>Weety News</title>
    </head>
    <body>
        <h1>Today's news:</h1>
	<!-- insert topics from database-->
        <div id="news">
	  <?php
	      $config['db'] = array(
		    'host'	  => 'localhost',
		    'username'	  => 'root',
		    'password'	  => '',
		    'dbname'	  => 'Topics' 
		    );
	      $db = new PDO('mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'], $config['db']['username'], $config['db']['password']);

	      $query = $db->query("SELECT Text FROM `Topics` ORDER BY `Topics`.`Rank` ASC");

	      $topics = $query->fetchAll(PDO::FETCH_ASSOC);

	      foreach($topics as $topic)
	      {
		echo '<a href="#">' . $topic['Text'] . '</a>';
	      }

	      ?>
        </div>
	<div class="results-window" id="results"></div>

        <script src="Libraries/Jquery.js"></script>
        <script>
        	$(document).ready(function(){
		    $(".results-window").hide();
		    $("#news a").on("click", function(){
		        $(this).expandAndMove('asdf');
			$(this).searchTopic($(this).text());

		    });
		});

		$.fn.expandAndMove = function(str){
		    $("#news").animate({width: "300px"}, function(){
			$("#news").animate({marginLeft: "0px"}, function(){
			  $(this).showNews();
			});
		    });
		}//expandAndMove

		$.fn.showNews = function(){
		  $(".results-window").animate({width: "800px", height: "200px"});
		  $(".results-window").show();
		}//showNews

		$.fn.searchTopic = function(topic){
		  $.get('fetchResults.php?topic="' + topic + '"', function(news){
		    $("#results").html(news);
		  });
		}

        </script>
    </body>
</html>
