<?php 
	require_once('services/translation_service.php');

	$translation_service = new TranslationService();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="WeetyNews.css" />
        <title>Weety News</title>
    </head>
    <body>
    	<header>
        	<h1>Today's news</h1>   
        	<div class="language-selector">
        		<select>
        			<?php $languages_list = $translation_service->get_languages_list_from_db(); ?>
        			<?php foreach($languages_list as $language): ?>
        			<option value="<?php echo $language->code; ?>"><?php echo $language->name; ?></option>
        			<?php endforeach; ?>
        		</select>
        	</div> 		
    	</header>

	<!-- insert topics from database-->
        <div id="news">
	  <?php
	      $config['db'] = array(
		    'host'	  => 'localhost',
		    'username'	  => 'root',
		    'password'	  => '',
		    'dbname'	  => 'WeetyNews' 
		    );
	      $db = new PDO('mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'], $config['db']['username'], $config['db']['password']);

	      $query = $db->query("SELECT Text FROM `Topics` ORDER BY `Topics`.`Rank` ASC");

	      $topics = $query->fetchAll(PDO::FETCH_ASSOC);

	      //Translate topics if requested:
	      if(isset($_GET['lg']))
	      {
		require 'post_request.php';
		
		foreach($topics as &$topic)
		  $topic['Text'] = Translator::translateThisString("en", $_GET['lg'], $topic['Text']);

	      }

	      foreach($topics as $topic)
	      {
		echo '<a href="#">' . $topic['Text'] . '</a>';
	      }

	      // require 'post_request.php';
	      // $langCodes = Translator::getAvailableLanguages();

	      // echo $langCodes;
	  //     foreach($langCodes as $langCode)
	  //     {
			// echo $langCode . Translator::getLanguageName($langCode, $langCode) . "<br>";
	  //     }
	      ?>
        </div>
	<div class="results-window" id="results"></div>

        <script src="Libraries/Jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
	    	$(document).ready(function(){
			    $(".results-window").hide();
			    $("#news a").on("click", function(){
			        $(this).expandAndMove('asdf');
					$(this).searchTopic($(this).text());
					$(this).addClass("active").siblings("a").removeClass("active");
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
		    $("#results").html(news).find(".r a").attr("target", "_blank");
		  });
		  $(this).changeLang("es");
		}

		$.fn.changeLang = function (language){
		  var from = "en", to = "es", text = "hello world";
		  var s = document.createElement("script");
		  s.src = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate" +
		      "?appId=Bearer " + encodeURIComponent(window.accessToken) +
		      "&from=en" +
		      "&to=" + language +
		      "&text=" + encodeURIComponent("hello") +
		      "&oncomplete=mycallback";
	        }

        function mycallback(response)
        {
            alert(response);
        }

    </script>


        </script>
    </body>
</html>
