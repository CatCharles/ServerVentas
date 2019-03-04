<?php
  $page_title = 'Agregar venta';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page   
   page_require_level(3);
   $all_customers = find_all('costumers');
?>
<?php

  if(isset($_POST['add_sale'])){ // add_sale -> ajax.php
    //$req_fields = array('s_id','quantity','price','total', 'date' );    
    validate_fields($req_fields);
        if(empty($errors)){
          $cantidad_prod_lista = $db->escape((int)$_POST['cantidad_prod_lista']);
          for($i=0;$i<$cantidad_prod_lista;$i++){
            $p_id      = $db->escape((int)$_POST['s_id' . $i]);
            $s_qty     = $db->escape((int)$_POST['quantity'  . $i]);
            $s_subtotal   = $db->escape($_POST['subtotal'  . $i]);
            $date      = $db->escape($_POST['date']);
            $total = $db->escape($_POST['total']);
            $ticket_id = count_by_id('ventas');
            $ticket_id['total'] = (int)$ticket_id['total'];                    
            
            
            
            $sql  = "INSERT INTO sales (";
            $sql .= " product_id, qty, price, date, id_ticket";
            $sql .= ") VALUES (";
            $sql .= "'{$p_id}','{$s_qty}','{$s_subtotal}','{$date}', '{$ticket_id['total']}'";
            $sql .= ")";
            $db->query($sql);
            
            
            
            //if($db->query($sql)){
             // update_product_qty($s_qty,$p_id);

            //} else {
              //$session->msg('d','Lo siento, registro falló.');
              //redirect('add_sale.php', false);
            //}                     
          }
         
          if(isset($_POST['costumer-choose'])){
             $cliente_c   = remove_junk($db->escape($_POST['costumer-choose'])); // Toma el id del cliente.
            echo "<script>console.log( 'Debug Objects: " . $cliente_c . "' );</script>";  
          } else {
             echo "<script>console.log( 'Debug Objects: " . 'No hay valor elegido.' . "' );</script>";  
          }
          
          $sql='';
          $sql  = "INSERT INTO ventas (";
          $sql .= "total, fecha, cliente, id_ticket";
          $sql .= ") VALUES (";
          $sql .= "'{$total}', '{$date}', '{$cliente_c}', '{$ticket_id['total']}'";
          $sql .= ")";
          $db->query($sql);
          $session->msg('s',"Venta agregada ");
          //redirect('add_sale.php', false);
        } else {
           $session->msg("d", $errors);
           redirect('add_sale.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">    
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Añadir</button>
            </span>
            
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Buscar por el nombre del producto" style="width: 300px">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Agregar venta</span>
       </strong>
        <strong style="text-align:right; font-size:14px; padding-left:650px;"> Tipo de moneda : <img src="libs/js/iconflag.jpg"></strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
         <table class="table table-bordered">
           <thead>
            <th> Producto </th>
            <th> Precio</th>
            <th> Cantidad </th>
            <th> Importe</th>
            <!--<th> Fecha</th>-->
            <!--<th> Acciones</th>-->
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
           <select class="form-control" name="costumer-choose">
              <option value="">Seleccione una cliente.</option>
            <?php  foreach ($all_customers as $cat): ?>
              <option value="<?php echo (int)$cat['id'] ?>">
                <?php echo $cat['costumer_name'] ?></option>
            <?php endforeach; ?>
            </select>
          <h1>
            
          </h1>
         <button type="submit" name="add_sale" class="btn btn-primary">Continuar</button>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>


<?php include 'select2.php' ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#select2_customer').select2();    
  });
</script>

