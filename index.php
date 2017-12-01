<?php
  session_start();
  require_once("./php/configuration.php");
  try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ?>
<html>
  <head>
    <title>Client Portal | SDCMDigital</title>
    <link type="text/css" rel="stylesheet" href="assets/css/main.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/animate.css"/>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,700,700i" rel="stylesheet"/>
  </head>
  <body>
    <nav class="animated">
      <ul id="branding">
        <li>Client Portal</li>
      </ul>
      <ul id="navLinks">
        <li><a href="../">HOME</a></li>
        <li><a href="./">BILLING</a></li>
        <li><a href="./downloads">CONTENT</a></li>
        <li><a href="./invoices">ORDERS</a></li>
      </ul>
      <ul class="loginLink">
        <?php if (!isset($_SESSION['name'])) { ?>
          <li><a href="./auth/?request=login">Login</a></li>
        <?php } else { ?>
          <li><a href="./auth/?request=logout">Logout</a></li>
        <?php } ?>
      </ul>
    </nav>
    <div class="mainHeader">
      <br/>
      <h1>Welcome to the client portal.</h1>
      <p>Here you can access your order history, billing, and content you've ordered.</p>
    </div>
    <div class="information">
      <h1>Information</h1>
      <hr/>
      <?php
        if ($r = $conn->query("SELECT COUNT(*) FROM news ORDER BY `id` DESC")) {
          if ($r->fetchColumn() > 0) {
            foreach($conn->query("SELECT * FROM news ORDER BY `id` DESC") as $res) {
      ?>
      <div class="infoItem">
        <div>
          <h1><? $row['subject']; ?></h1>
          <h2><? date("d/m/Y", $row['subject']); ?></h2>
        </div>
        <p><? $row['content']; ?></p>
      </div>
      <?php
            }
          }
        }
      ?>
    </div>
    <div class="footer">
      <p id="copyright">Copyright &copy; 2017 SDCMDigital</p>
      <a id="email" href="mailto:admin@sdcmdigital.com">Email Us</a>
    </div>
  </body>
</html>
<?php
} catch (PDOException $e) {
$e->getMessage();
}
?>
