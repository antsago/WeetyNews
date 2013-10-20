<?php
header('Content-Type: text/html; charset=utf-8');

require_once("simple_html_dom.php");
if (isset($_GET['topic'])){
  $google = file_get_html("https://www.google.com/search?tbm=nws&q=" . urlencode(str_replace('"', '', $_GET['topic'])));
  foreach($google->find(".g") as $news)
  {
    //Get relevant content and convert to UTF-8:
    $title = iconv("ISO-8859-1", "UTF-8", str_replace("/url", "http://www.google.com/url", $news->find("h3.r", 0)));
    $fromWhen = iconv("ISO-8859-1", "UTF-8", $news->find(".f", 0));
    $summary = iconv("ISO-8859-1", "UTF-8", $news->find(".st", 0));

    echo $title . $fromWhen . $summary . "<br><br>";
  }

}
?>  
