<header>
  <nav id="nav">
    <ul>
      <?php
      foreach($pages as $page_id => $page_name) {
        // utilize the current location to style it differently
        if ($page_id == $current_page_id) {
          $css_id = "id='current_page'";
        } else {
          $css_id = "";
        }
        echo "<li><a " . $css_id . " href='" . $page_id. ".php'>$page_name</a></li>";
      }
      ?>
    </ul>
  </nav>

  <!--  The image used in header was created by Sung Woo Min.  -->
  <img alt="Header" src="images/logo.PNG"/>
</header>
