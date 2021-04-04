<?php  
   //$do = "" ; 
   if(isset($_GET['do'])){
       $do = $_GET['do'];
   }else{
      $do = "manage" ;
   }


  if($do == "manage"){
       echo "hello From " . $do . "page"; 
       echo "<a href='?do=add'>add member</a>";
  }elseif($do == "add"){
    echo "hello From " . $do . "page"; 
  }elseif($do == "insert"){
    echo "hello From " . $do . "page"; 
  }elseif($do == "edit"){
    echo "hello From " . $do . "page"; 
  }elseif($do == "update"){
    echo "hello From " . $do . "page"; 
  }elseif($do == "delete"){
    echo "hello From " . $do . "page"; 
  }elseif($do == "show"){
    echo "hello From " . $do . "page"; 
  }





?>