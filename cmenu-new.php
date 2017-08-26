  <?php 
  require_once('bootstra.php');
require_once('includes/parts/head.php');
$coffers = $base->getUserBanks();
  include('includes/parts/nav-menu.new.php');
  include('includes/parts/coffers.new.php');
   ?>