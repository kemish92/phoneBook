<?php
class Articulos extends CI_Controller {
   function index(){
      //cargo el helper de url, con funciones para trabajo con URL del sitio
      $this->load->helper('url');
      $this->load->helper('form');

      //cargo el modelo de artículos
      $this->load->model('Articulo_model');
      
      //pido los ultimos artículos al modelo
      $ultimosArticulos = $this->Articulo_model->articulos();
      
      //creo el array con datos de configuración para la vista
      //$datos_vista = array('rs_articulos' => $ultimosArticulos);
      $data["formData"] = $ultimosArticulos;
      $data['mensajes'] = $this->Articulo_model->mensajes();
      //var_dump($data);
      //cargo la vista pasando los datos de configuacion
      $this->load->view('home', $data);
      json_encode($data);
   }
   public function guardar_post(){
        $contactName = $this->input->post('contactName');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $this->load->model('Articulo_model');
        $this->Articulo_model->guardar($contactName, $address, $phone);
        header("Location: https://localhost/myPageNew/");
        die();
   }
   function editContact(){
      $this->load->helper('url');
      $this->load->model('Articulo_model');
      $this->load->view('editContact');
   }
   //lo otro
   //función encargada de mostrar los formularios por ajax
    //dependiendo el botón que hayamos pulsado
    function mostrar_datos(){
      $this->load->helper('url');
      $this->load->model('Articulo_model');
      $this->load->helper('form');
        //recuperamos la id que hemos envíado por ajax
        $id = $this->input->post('id');
        //solicitamos al modelo los datos de esa id
        $edicion = $this->Articulo_model->obtener($id);
        //recorremos el array con los datos de ese id
        //y creamos el formulario con el helper form
 
            $contactName = array(
                'name' => 'contactName',
                'id' => 'contactName',
                'value' => $edicion->contactName
            );
            $address = array(
                'name' => 'address',
                'id' => 'address',
                'value' => $edicion->address
            );
            $phone = array(
                'name' => 'phone',
                'id' => 'phone',
                'value' => $edicion->phone
            );
            $submit = array(
                'name' => 'editando',
                'id' => 'editando',
                'class'=>'modal-close waves-effect waves-green btn-flat teal accent-4',
                'value' => 'Edit contact'
            );
            $oculto = array(
                'id_mensaje' => $id
               );
 
            //mostramos el formulario con los datos cargados
            ?>
            <?= form_open(base_url() . 'Articulos/actualizar_datos','', $oculto) ?>
            <?= form_label('Nombre') ?>
            <?= form_input($contactName) ?>
            <?= form_label('address') ?>
            <?= form_input($address) ?>
            <?= form_label('phone') ?>
            <?= form_input($phone) ?>
            
 
            <?= form_submit($submit) ?>
            <?php echo form_close() ?>
            <?php     
            }     
 
           //función encargada de actualizar los datos     
           function actualizar_datos(){     
           $this->load->model('Articulo_model');    
              $id = $this->input->post('id_mensaje');
              $contactName = $this->input->post('contactName');
              $address = $this->input->post('address');
              $phone = $this->input->post('phone');
              //var_dump($id,$contactName,$address,$phone);
              $actualizar = $this->Articulo_model->actualizar_mensaje($id,$contactName,$address,$phone);
              //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
              header("Location: https://localhost/myPageNew/");
              die();
               
    }
    function borrar_contacto(){
      $this->load->model('Articulo_model');
 $id = $this->uri->segment(3);
 $delete = $this->Articulo_model->eliminar_contacto($id);
 header("Location: https://localhost/myPageNew/");
              die();
 }
}
?> 