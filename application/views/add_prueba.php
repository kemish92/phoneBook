<?php

//modelo informe_model.php
public function guardar($titulo, $descripcion, $prioridad, $id=null){
      $data = array(
         'titulo' => $titulo,
         'descripcion' => $descripcion,
         'prioridad' => $prioridad
      );
      if($id){
         $this->db->where('id', $id);
         $this->db->update('informes', $data);
      }else{
         $this->db->insert('informes', $data);
      } 
   }
//vista
   <p> <a href="<?php echo base_url() ?>informes/guardar"> Crear nuevo informe </a> </p>
 //guardar.php
   <h1> Guardar informe </h1>
<form method="post" action="<?php echo base_url() ?>informes/guardar_post/<?php echo $id ?>">
    <div class="row">
       <label> Título </label>
       <input type="text" name="titulo" required="required" value="<?php echo $titulo ?>" />
    </div>
    <div class="row">
       <label> Descripción </label>
       <textarea name="descripcion" cols="100" rows="10" required="required" style="width: 100%;"><?php echo $descripcion; ?></textarea>
    </div>
    <div class="row">
       <label> Prioridad </label>
       <input type="number" min="1" max="5" name="prioridad" required="required" value="<?php echo $prioridad; ?>" />
    </div>
    <div class="row">
       <input type="submit" class="btn btn-success" value="Guardar" />
       <a class="btn btn-danger" href="<?php echo base_url() ?>informes"> Cancelar </a>
    </div>
</form>
//  informes.php
  public function guardar_post($id=null){
      if($this->input->post()){
         $titulo = $this->input->post('titulo');
         $descripcion = $this->input->post('descripcion');
         $prioridad = $this->input->post('prioridad');
         $this->load->model('informe_model');
         $this->informe_model->guardar($titulo, $descripcion, $prioridad, $id);
         redirect('informes');
      }else{
         $this->guardar();
      } 
   }
  public function guardar($id=null){
      $data = array(); 
      $this->load->model('informe_model');
      if($id){
         $informe = $this->informe_model->obtener_por_id($id); 
         $data['id'] = $informe->id;
         $data['titulo'] = $informe->titulo;
         $data['descripcion'] = $informe->descripcion;
         $data['prioridad'] = $informe->prioridad;
      }else{
         $data['id'] = null;
         $data['titulo'] = null;
         $data['descripcion'] = null;
         $data['prioridad'] = null;
      }
      $this->load->view('informes/header');
      $this->load->view('informes/guardar', $data);
      $this->load->view('informes/footer');
   }










   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--necesario para utilizar ajax-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <title><?= $titulo ?></title>
        <style type="text/css">
            /*los estilos*/
            th{
                background-color: #222;
                color: #fff;
            }
            td{
                padding: 5px 40px 5px 40px;
                background-color: #D0D0D0;
            }
            label{
                display: block;
            }
            #editar{
                margin: 30px 0px 0px 300px;
                background-color: #D0D0D0;
                border: 3px solid #999;
                width: 500px;
                padding: 20px;
                display: none;
            }
            input[type=text],input[type=email]{
                padding: 5px;
                width: 250px;
            }
            input[type=submit]{
                padding: 4px 15px 4px 15px;
                background-color: #123;
                border-radius: 4px;
                color: #ddd;
            }
            #actualizadoCorrectamente{
                padding: 5px;
                background-color: #005702;
                color: #fff;
                font-weight: bold;
                text-align: center;
            }
        </style>
        <script type="text/javascript">
            //función encargada de procesar la solicitud al pulsar el botón pasar_edicion
            function saltar(id){
                $("#editar").load("http://localhost/updateCI/datos/mostrar_datos", { id: id }); 
                $("#editar").fadeIn('2000');
            }
        </script>
    </head>

    <body>
        <table>
            <tr>
                <th>Autor</th>
                <th>Email</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Editar</th>
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
                    'onclick' => "saltar($id)"
                );
                ?>
                <tr>
                    <td><?= $fila->nombre ?></td>
                    <td><?= $fila->email ?></td>
                    <td><?= $fila->asunto ?></td>
                    <td><?= $fila->mensaje ?></td>
                    <td><?= form_button($boton, 'Editar') ?></td>
                </tr>
                <?php
            endforeach;
            ?>
            <?php
            //si se hace la actualización mostramos el mensaje que contiene
            //la sesión flashdata actualizado que hemos creado en el controlado
            $actualizar = $this->session->flashdata('actualizado');
            if ($actualizar) {
                ?>
                <tr>
                    <td colspan="5" id="actualizadoCorrectamente"><?= $actualizar ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <div id="editar">            
        </div>
    </body>
</html>

<?php 
class Datos extends CI_Controller 
{     
    function __construct() 
    {         
         parent::__construct();         
         $this->load->model('datos_model');
    }

    function index() 
    {
        $data['titulo'] = 'Update con codeIgniter';
        $data['mensajes'] = $this->datos_model->mensajes();
        $this->load->view('datos_view', $data);
    }

    //función encargada de mostrar los formularios por ajax
    //dependiendo el botón que hayamos pulsado
    function mostrar_datos() 
    {
        //recuperamos la id que hemos envíado por ajax
        $id = $this->input->post('id');
        //solicitamos al modelo los datos de esa id
        $edicion = $this->datos_model->obtener($id);
        //recorremos el array con los datos de ese id
        //y creamos el formulario con el helper form

            $nombre = array(
                'name' => 'nombre',
                'id' => 'nombre',
                'value' => $edicion->nombre
            );
            $email = array(
                'name' => 'email',
                'id' => 'email',
                'value' => $edicion->email
            );
            $asunto = array(
                'name' => 'asunto',
                'id' => 'asunto',
                'value' => $edicion->asunto
            );
            $mensaje = array(
                'name' => 'mensaje',
                'id' => 'mensaje',
                'cols' => '50',
                'rows' => '6',
                'value' => $edicion->mensaje
            );
            $submit = array(
                'name' => 'editando',
                'id' => 'editando',
                'value' => 'Editar mensaje'
            );
            $oculto = array(
                'id_mensaje' => $id
               );

            //mostramos el formulario con los datos cargados
            ?>
            <?= form_open(base_url() . 'datos/actualizar_datos','', $oculto) ?>
            <?= form_label('Nombre') ?>
            <?= form_input($nombre) ?>
            <?= form_label('Email') ?>
            <?= form_input($email) ?>
            <?= form_label('Asunto') ?>
            <?= form_input($asunto) ?>
            <?= form_label('Mensaje') ?>
            <?= form_textarea($mensaje) ?>

            <?= form_submit($submit) ?>
            <?php echo form_close() ?>
            <?php     
            }     
 
           //función encargada de actualizar los datos     
           function actualizar_datos()     
           {         
               $id = $this->input->post('id_mensaje');
               $nombre = $this->input->post('nombre');
               $email = $this->input->post('email');
               $asunto = $this->input->post('asunto');
               $mensaje = $this->input->post('mensaje');

               $actualizar = $this->datos_model->actualizar_mensaje($id,$nombre,$email,$asunto,$mensaje);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
               if($actualizar)
               {
                $this->session->set_flashdata('actualizado', 'El mensaje se actualizó correctamente');
                redirect('../datos', 'refresh');
               }
    }
}
/*application/controllers/datos.php
 * el controlador datos.php
 */


 <?php class Datos_model extends CI_Model {     

function __construct() 
{        
    parent::__construct();    
}     

//obtenemos todos los mensajes a mostrar en la tabla     
function mensajes() 
{         
    $query = $this->db->get('mensajes');
        foreach ($query->result() as $fila) 
        {
            $data[] = $fila;
        }
    return $data;
}

    //obtenemos la fila completa del mensaje a editar
    //vemos que como solo queremos una fila utilizamos
    //la función row que sólo nos devuelve una fila,
    //así la consulta será más rápida
    function obtener($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('mensajes');
        $fila = $query->row();
        return $fila;
    }

    //actualizamos los datos en la base de datos con el patrón
    //active record de codeIginiter, recordar que no hace falta
    //escapar las consultas ya que lo hace él automaticámente
    function actualizar_mensaje($id, $nombre, $email, $asunto, $mensaje) {
        $data = array(
            'nombre' => $nombre,
            'email' => $email,
            'asunto' => $asunto,
            'mensaje' => $mensaje
        );
        $this->db->where('id', $id);
        return $this->db->update('mensajes', $data);
    }
}
/*application/models/datos_model.php
 * el modelo datos_model.php
 */