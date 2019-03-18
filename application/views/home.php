<html>
<head>
<title>Phone book</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--necesario para utilizar ajax-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<style type="text/css">
  .button {
    display: block;
    width: 115px;
    height: 25px;
    background: #4E9CAF;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
}
</style>
</head>
<body>
<!--Header-->
 <nav class="nav-extended">
    
    <div class="nav-content teal accent-4">
      <span class="nav-title">Phone book</span>
      <a class="btn-floating btn-large halfway-fab waves-effect waves-light teal">
        <i class="material-icons btn modal-trigger" data-target="modal1">+</i>
      </a>
    </div>
  </nav>
<!--End of header-->

</form>
<div style="height: 10px; width: 100%; background-color: lightblue;"></div>
<!--Lo otro-->
<table>
            <tr>
                <th>name</th>
                <th>address</th>
                <th>phone</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
            <?php
            foreach ($mensajes as $fila):
                $id = $fila->id;
                //creamos el botón que debe colocar los datos dentro de los campos
                //del formulario que se creará con la función saltar($id) que le pasamos
                //la id del mensaje
                $boton = array(
                    'name' => 'pasar_edicion',
                    'id' => 'pasar_edicion',
                    'class'=>'btn waves-effect waves-light orange accent-4 btn modal-trigger',
                    'data-target'=>'modal2',
                    'onclick' => "saltar($id)"
                );
                ?>
                <tr>
                    <td><?= $fila->contactName ?></td>
                    <td><?= $fila->address ?></td>
                    <td><?= $fila->phone ?></td>
                    <td><?= form_button($boton, 'Editar') ?></td>
                    <td><a class="waves-effect waves-light btn red accent-4" onclick="if(confirma() == false) return false" href="<?=base_url()?>Articulos/borrar_contacto/<?=$fila->id?>">Eliminar</a></td>
                </tr>
                <?php
            endforeach;
            ?>
   
        </table>
        
        <!--Start of modal add contact-->
  <!-- Modal Structure -->
  <div id="modal1" class="modal">
  <div class="modal-content">
  <h1>Agregar usuario</h1>
  <form method="post" action="<?php echo base_url() ?>Articulos/guardar_post/">
  <div class="row">
    <label> Nombre </label>
    <input type="text" name="contactName"  />
  </div>
  <div class="row">
    <label> Direccion </label>
    <input type="text" name="address" >
  </div>
  <div class="row">
    <label> numero </label>
    <input type="text" name="phone" >
  </div>
  <div class="row">
    <input type="submit" class="btn btn-success" value="Guardar" id="enviar" />
    
  </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
  </div>          
  <!--End of modal add contact-->

    <!-- Modal Structure -->
  <div id="modal2" class="modal">
  <div class="modal-content">
      <div id="editar"></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
  </div>          
  <!--End of modal add contact-->
   <!-- Modal Structure -->
  <div id="modal3" class="modal">
  <div class="modal-content">
      <h3>Seguro que quieres eliminar contacto?</h3>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
  </div>          
  <!--End of modal add contact-->

        <!--Start of footer-->
        <footer class="page-footer teal accent-4">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Phone book</h5>
                <p class="grey-text text-lighten-4">With codeigniter and materialize</p>
              </div>
              
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © By Kemish Flores
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
        </footer>
        <!--End of footer-->
</body>
</html>
<script type="text/javascript">
            //función encargada de procesar la solicitud al pulsar el botón pasar_edicion
            function saltar(id){
                $("#editar").load("https://localhost/myPageNew/index.php/Articulos/mostrar_datos", { id: id }); 
                $("#editar").fadeIn('2000');
            }
            function confirma(){
             if (confirm("¿Realmente desea eliminarlo?")){ 
                alert("El registro ha sido eliminado.") }
              else { 
             return false
             }
            }
            document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, options);
  });

  // Or with jQuery

  $(document).ready(function(){
    $('.modal').modal();
  });
        </script>
