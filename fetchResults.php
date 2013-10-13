<?php

require_once("simple_html_dom.php");
if (isset($_GET['topic'])){
  $google = file_get_html("https://www.google.com/search?tbm=nws&q=" . urlencode(str_replace('"', '', $_GET['topic'])));
  foreach($google->find(".g") as $news)
    echo $news;
}
?>  
