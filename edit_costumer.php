<?php
  $page_title = 'Editar cliente';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $e_costumer = find_by_id('costumers',(int)$_GET['id']);
  //$groups  = find_all('user_groups');
  if(!$e_costumer){
    $session->msg("d","falta cliente id.");
    redirect('costumers.php');
  }
?>

<?php
//Update User basic info
  if(isset($_POST['update'])) {
    $req_fields = array('costumer_name');
    validate_fields($req_fields);
    if(empty($errors)){
             $id = (int)$e_costumer['id'];
           $costumer_name = remove_junk($db->escape($_POST['costumer_name']));
      //$mensaje = remove_junk($db->escape($_POST['costumer_name']);
      echo "<script>console.log( 'Debug Objects: " . $costumer_name . "' );</script>";
     //  $username = remove_junk($db->escape($_POST['username']));
      //    $level = (int)$db->escape($_POST['level']);
       //$status   = remove_junk($db->escape($_POST['status']));
            $sql = "UPDATE costumers SET costumer_name ='{$costumer_name}' WHERE id='{$db->escape($id)}'";
         $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Cliente actualizado ");
            redirect('edit_costumer.php?id='.(int)$e_costumer['id'], false);
          } else {
            $session->msg('d',' Lo siento no se actualizó los datos.');
            redirect('edit_costumer.php?id='.(int)$e_costumer['id'], false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_costumer.php?id='.(int)$e_costumer['id'],false);
    }
  }
?>

<?php include_once('layouts/header.php'); ?>
 <div class="row">
   <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
  <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Actualizar cliente <?php echo remove_junk(ucwords($e_costumer['costumer_name'])); ?>
        </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="edit_costumer.php?id=<?php echo (int)$e_costumer['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="costumer_name" class="control-label">Nombres</label>
                  <input type="costumer_name" class="form-control" name="costumer_name" value="<?php echo remove_junk(ucwords($e_costumer['costumer_name'])); ?>">
            </div>
            
            <div class="form-group clearfix">
                    <button type="submit" name="update" class="btn btn-info">Actualizar</button>
            </div>
        </form>
       </div>
     </div>
  </div>


 </div>
<?php include_once('layouts/footer.php'); ?>
