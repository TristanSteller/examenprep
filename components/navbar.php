<?php
    $logged = isset($_SESSION['user_id']);
    var_dump($_SESSION)
?>

<nav class="navbar bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <span class="text-light">nav</span>
    </a>
    <div class="d-flex">
      <?php if( true === $logged ): ?>
        <a class="btn btn-outline-danger" href="logout.php">logout</a>
      <?php endif; ?>
    </div>
  </div>
</nav>