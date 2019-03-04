<?php
  $page_title = 'Lista de clientes';
  require_once('includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(1);
//pull out all user form database
 $all_costumers = find_all_costumers();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Clientes</span>
       </strong>
         <a href="add_costumers.php" class="btn btn-info pull-right">Agregar cliente</a>
      </div>
     <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Nombre </th>
            <!--<th>Usuario</th>
            <th class="text-center" style="width: 15%;">Rol de usuario</th>
            <th class="text-center" style="width: 10%;">Estado</th>
            <th style="width: 20%;">Último login</th>-->
            <th class="text-center" style="width: 100px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($all_costumers as $a_costumer): ?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_costumer['costumer_name']));?></td>
           
           <td class="text-center">
             <div class="btn-group">
                <a href="edit_costumer.php?id=<?php echo (int)$a_costumer['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                  <i class="glyphicon glyphicon-pencil"></i>
               </a>
                <a href="delete_costumer.php?id=<?php echo (int)$a_costumer['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                  <i class="glyphicon glyphicon-remove"></i>
                </a>
                </div>
           </td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
  <?php include_once('layouts/footer.php'); ?>
