
var lista_productos = [];
var lista_id = [];
var cantidad = 1.0;
const IVA = 0.17;
var contador = 0;
var total_sin_iva = 0;
var total_con_iva = 0;
function suggetion() {

     $('#sug_input').keyup(function(e) { // KEY UP.

         var formData = {
             'product_name' : $('input[name=title]').val()
         };

         if(formData['product_name'].length >= 1){

           // process the form
           $.ajax({
               type        : 'POST',
               url         : 'ajax.php',
               data        : formData,
               dataType    : 'json',
               encode      : true
           })
               .done(function(data) {
                   //console.log(data);
                   $('#result').html(data).fadeIn();
                   $('#result li').click(function() {

                     $('#sug_input').val($(this).text());
                     $('#result').fadeOut(500);

                   });

                   $("#sug_input").blur(function(){
                     $("#result").fadeOut(500);
                   });

               });

         } else {

           $("#result").hide();

         };

         e.preventDefault();
     });

 }
  $('#sug-form').submit(function(e) {
      var formData = {
          'p_name' : $('input[name=title]').val()
      };
        // process the form
        $.ajax({
            type        : 'POST',
            url         : 'ajax.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {

                console.log('VALOR: ' + $('input[name=title]').val());
                //lista_productos += data;
                //lista_productos.push(data);
                //ombre_producto.push();
                //console.log(nombre_producto[nombre_producto.length-1]);
                //console.log(lista_productos.length );

                // TODO: Si ya existe aumentar sólo cantidad.

                
          
                //console.log(data);
                /*var found = "";
                data.forEach(function(e_Product){
                 found = lista_productos.find(function(e_Lista) {
                   console.log(e_Lista['id']);
                   return e_Lista['id'] == e_Product['id'];
                 });
                 //console.log(found);
                });*/

                      
          
                var html = ""; 
                data.forEach(function(e){

                  //lista_productos.push([1,2,3,4]);
                  //lista_productos.push([2,2,3,4]);
                  //console.log(lista_productos[0][0]);
                  var indice = lista_id.indexOf(e['id']);
                  if(indice!=-1) {
                     console.log('Producto previamente añadido.');
                     //cantidad = lista_productos[indice][3] + 1;
                     lista_productos[indice][3] += 1;
                  } else {
                     lista_productos.push([e['id'],e['name'],e['sale_price'],cantidad]);
                     lista_id.push(e['id']);  
                  }                                    
                  
                  
                  lista_productos.forEach(function(l_p){
                    html += "<tr>";                      
                    //l_p.forEach(function(l){
                    //console.log(l_p[0]);
                    //console.log(l_p[1]);
                    //console.log(l_p[2]);
                    //console.log(l_p[3]);
                    
                    // Nombre.
                    html += "<td id=\"s_name\">" + l_p[1] + "</td>";
                    
                    html += "<input type=\"hidden\" name=\"s_id"+contador+"\" value=\""+l_p[0]+"\">";
                    //console.log(html);
                    
                    //Precio.
                    
                    html += "<td><input type=\"text\" class=\"form-control\" name=\"price"+contador+"\" value=\""+l_p[2]+"\"></td>";
                    
                    html += "<td id=\"s_qty\">";
                    html += "<input type=\"text\" class=\"form-control\" name=\"quantity"+contador+"\" value=\""+l_p[3]+"\"></td>";
                    
                    html += "<td><input type=\"text\" class=\"form-control\" name=\"subtotal"+contador+"\" value=\""+l_p[2]*l_p[3]+"\"></td>";                                        
                    
                    //});
                    html += "</tr>";
                    
                    total_sin_iva += l_p[2] * l_p[3]; // Se calcula el total a pagar cada vez que se añade un producto.
                   
                    
                    // filla 3.
                    //html += "<tr>";                    
                    //html += "<td colspan=\"1\"></td>"
                    //html += "<td colspan=\"2\" align=\"center\">IVA</td>"
                    //html += "<td colspan=\"1\" align=\"right\">"+IVA+"</td>"                 
                    //html += "</tr>";
                    
                    //console.log('contador: '+contador);
                    contador++;
                    
                  });
                   //Cantidad de productos.
                  html += "<input type=\"hidden\" name=\"cantidad_prod_lista\" value=\""+contador+"\">";
                  
                  contador = 0;                  
                  //console.log('Valor a búscar: '+e['sale_price']);
                  //console.log('Retorno: '+lista_productos.indexOf(e['sale_price']));
          //console.log(lista_productos);
                  //console.log(element['id']);
                  //console.log(                                                                element['sale_price']);
                });
          
                //fila 2. si se ve sin iva
                html += "<tr>";                    
                html += "<td colspan=\"2\"></td>"
                html += "<td colspan=\"1\" align=\"center\"><b>Subtotal </b></td>"
                html += "<td colspan=\"1\" align=\"right\">"+total_sin_iva+"</td>"                 
                html += "</tr>";
          
                // fila 3. IVA.  
                var iva_calculado = (IVA*total_sin_iva).toFixed(2);
                html += "<tr>";                    
                html += "<td colspan=\"2\"></td>"
                html += "<td colspan=\"1\" align=\"center\"><b>IVA ($16.00)</b></td>"
                html += "<td colspan=\"1\" align=\"right\">"+iva_calculado+"</td>"                 
                html += "</tr>";
          
                // fila 4. Total con iva.                
                total_con_iva = parseFloat(total_sin_iva)  + parseFloat(iva_calculado) ; // Se calcula el total con iva.
                html += "<input type=\"hidden\" name=\"total\" value=\""+total_con_iva+"\">";
                html += "<tr>";                    
                html += "<td colspan=\"2\"></td>"
                html += "<td colspan=\"1\" align=\"center\"><b>Adeudo total </b></td>"
                html += "<td colspan=\"1\" align=\"right\">"+total_con_iva+"</td>"                 
                html += "</tr>";
                    
          
          
                total_sin_iva = 0;
                total_con_iva = 0; // Se borra el total para evitar que se acumule una 
                                     // vez que se realiza este proceso una vez más.
          
                // fila 4. Fecha de compra.
                //html += "<td colspan=\"2\" align=\"center\">Fecha de compra: </td>"
                html += "<td colspan=\"2\"><input type=\"hidden\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\"></td>";                                       
                
               
            
                //console.log('Cadena: '+html);
                
                         
                $('#product_info').html(html).show();
                //total();
                $('.datePicker').datepicker('update', new Date());

            }).fail(function() {
                $('#product_info').html(html).show();
            });
      e.preventDefault();
  });
  function total(){ // NO SE USA MÁS.
    console.log('Array longitud: '+lista_productos.length);
    for (var index = 0; index < lista_productos.length; index++) { 
      $('#product_info input').change(function(e)  {
              console.log('Price: '+(+$('input[name=price'+index+']').val() || 0));
              var price = +$('input[name=price'+index+']').val() || 0;
              var qty   = +$('input[name=quantity'+index+']').val() || 0;
              var total = qty * price; 
                  $('input[name=total'+index+']').val(total.toFixed(2));
              console.log('total '+total);
      }); 
    }
  }

  $(document).ready(function() {

    //tooltip
    $('[data-toggle="tooltip"]').tooltip();

    $('.submenu-toggle').click(function () {
       $(this).parent().children('ul.submenu').toggle(200);
    });
    //suggetion for finding product names
    suggetion();
    // Callculate total ammont
    total();

    $('.datepicker')
        .datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true
        });
  });
