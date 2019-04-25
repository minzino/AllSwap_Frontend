<?php
include("includes/init.php");
$current_page_id="index";

if (isset($_POST["logout"])) {
  log_out();
};
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

</head>
<body>
  
<?php
  if(!$current_user) {
    include("includes/login.php");
  } else {
    include("includes/logout.php");
  }
  print_messages();
  ?>

  <?php include("includes/header.php");?>

  <div id="content-wrap2">
    <form id="search" action="index.php" method="get">
      <select name="category">
        <option value="" selected disabled>Search by</option>
        <option value="textbook_title">Textbook Title</option>
        <option value="textbook_author">Textbook Author</option>
        <option value="textbook_genre">Genre</option>
        <option value="isbn">ISBN</option>
        <option value="price">Price</option>
      </select>

      <input id="search_term" type="text" name="search" placeholder="Search"/>
      <button id="search_icon" type="submit">Search</button>
    </form>
  </div>

  <?php include("includes/footer.php");?>
</body>

</html>