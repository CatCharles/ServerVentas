<?php
  $page_title = 'Lista de ventas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
//$sales = find_all_sale();
$sales = find_by_ticket((int)$_GET['id']);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Ticket #<?php echo (int)$_GET['id']; ?></span>
          </strong>
          <div class="pull-right">
            <a href="sales.php" class="btn btn-primary">Administrar ventas</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Producto </th>
                <th class="text-center" style="width: 15%;"> Cantidad </th>
                <th class="text-center" style="width: 15%;"> Precio </th>
                <!--<th class="text-center" style="width: 15%;"> Fecha </th>-->
                <th class="text-center" style="width: 100px;"> Acciones </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo $sale['name']; ?></td>
               
               <td class="text-center"><?php echo $sale['qty']; ?></td>
               <td class="text-center"><?php echo $sale['price']; ?></td>
            
               <td class="text-center">
                  <div class="btn-group">
                     <a href="edit_sale.php?id=<?php echo (int)$sale['id'];?>&ticket=<?php echo (int)$_GET['id'];?>" class="btn btn-warning btn-xs"  title="Editar" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a href="delete_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
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
