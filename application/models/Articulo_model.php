<?php
class Articulo_model extends CI_Model {
var $pdo;
   function __construct(){
parent::__construct();
}
   
   /*function dame_ultimos_articulos(){
      $stmt = $pdo->query("SELECT * FROM articulo ORDER BY id DESC LIMIT 5");
      return query($stmt);
   }*/
function articulos(){

   $result = $this->db->query("SELECT * FROM articulo");
   return $result->result();

}
    public function add($name,$address,$number){
        $result=$this->db->query("INSERT INTO articulo VALUES(NULL, '$name','$address','$number')");
        return $result->result();
    }
    public function guardar($contactName, $address, $phone){
      $data = array(
         'contactName' => $contactName,
         'address' => $address,
         'phone' => $phone
      );
         $this->db->insert('articulo', $data);
   }

//lo otro
   function mensajes() 
{         
    $query = $this->db->get('articulo');
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
        $query = $this->db->get('articulo');
        $fila = $query->row();
        return $fila;
    }
 
    //actualizamos los datos en la base de datos con el patrón
    //active record de codeIginiter, recordar que no hace falta
    //escapar las consultas ya que lo hace él automaticámente
    function actualizar_mensaje($id, $contactName, $address, $phone) {
        $data = array(
            'contactName' => $contactName,
            'address' => $address,
            'phone' => $phone
        );
        $this->db->where('id', $id);
        return $this->db->update('articulo', $data);
    }
     function eliminar_contacto($id)
 {
 $this->db->where('id',$id);
 return $this->db->delete('articulo');
 }


}
?> 