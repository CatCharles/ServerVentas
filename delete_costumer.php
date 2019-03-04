<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $delete_id = delete_by_id('costumers',(int)$_GET['id']);
  if($delete_id){
      $session->msg("s","Cliente eliminado");
      redirect('costumers.php');
  } else {
      $session->msg("d","Se ha producido un error en la eliminación del cliente");
      redirect('costumers.php');
  }
?>
