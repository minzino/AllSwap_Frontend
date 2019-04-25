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

  
  <form id="search" action="index.php" method="get">
    <select name="category">
      <option value="" selected disabled>Search by</option>
      <option value="game_title">Textbook Title</option>
      <option value="game_company">Textbook Author</option>
      <option value="game_genre">Genre</option>
      <option value="age_limit">ISBN</option>
      <option value="price">Price</option>
    </select>

    <input id="search_term" type="text" name="search" placeholder="Search"/>
    <button id="search_icon" type="submit">Search</button>
  </form>



  <h2>Add Your Textbook</h2>

<div id="container">
  <form id="add_form" action="index.php" method="post">
    <fieldset>
      <ul>
        <li class="form">Game Title:
          <input type="text" name="game_title"
          placeholder="Title of the game" required/>
        </li>

        <li class="form">Game Company:
          <input type="text" name="game_company"
          placeholder="Name of the company" required/>
        </li>

        <li class="form">Genre:
          <input type="text" name="game_genre"
          placeholder="Genre tag of the game" required/>
        </li>

        <li class="form">Age Limit:
          <input type="number" name="age_limit"
          placeholder="Age limit of the game" min="0" max="100" required/>
        </li>

        <li class="form">Price ($):
          <input type="number" name="price"
          placeholder="Price in dollars" min="0" max="99999" required/>
        </li>

        <li class="form">
          <input id="submit" name="submit" type="submit" value="Submit"/>
        </li>
      </ul>
    </fieldset>
  </form>
</div>
</section>

  <?php include("includes/footer.php");?>
</body>

</html>