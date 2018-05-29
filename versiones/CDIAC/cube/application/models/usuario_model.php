<?php
Class Usuario_model extends CI_Model
{
 function login($username, $password)
 {
   $this -> db -> select('username, passwd');
   $this -> db -> from('usuario');
   $this -> db -> where('username', $username);
   $this -> db -> where('passwd', MD5($password));
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
}
?>
