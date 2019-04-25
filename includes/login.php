<div id="content-wrap1">
  <form id="loginForm" action=<?php echo $this_page . ".php" ?> method="POST">
    <ul>
      <li>
        <label>Username: </label>
        <input type="text" name="username" required/>
      </li>
      <li>
        <label>Password: </label>
        <input type="password" name="password" required/>
      </li>
      <li>
        <button name="login" type="submit">Log In</button>
      </li>
    </ul>
  </form>
</div>
