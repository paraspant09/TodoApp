<?php
if(isset($_POST['task']) && isset($_POST['subtasks']) && isset($_POST['subtaskdescription']) && isset($_POST['targetdate']) && isset($_COOKIE['name'])){

  $task=$_POST['task'];
  $subtasks=$_POST['subtasks'];
  $subtaskdescription=$_POST['subtaskdescription'];
  $targetdate=$_POST['targetdate'];
  $username=$_COOKIE['name'];

  try {
    $con=new PDO('mysql:host=localhost;dbname=todoDB;','root');
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    try{
      $checkTable=$con->query("SELECT 1 FROM TodoCards LIMIT 1");  //check if table exists or not
    }
    catch(Exception $e)
    {
      $q="CREATE TABLE TodoCards(name varchar(50) NOT NULL,task varchar(100) NOT NULL,subtasks varchar(500) NOT NULL,subtaskdescription varchar(1000) NOT NULL,targetdate varchar(20) NOT NULL)";
      $con->exec($q);
    }

    $q="SELECT name,task,subtasks,subtaskdescription,targetdate FROM TodoCards WHERE name='$username' And task='$task' And subtasks='$subtasks' And subtaskdescription='$subtaskdescription' And targetdate='$targetdate'";
    $result=$con->query($q);
    $assoc=$result->fetch();
    if(empty($assoc))
    {
      $q="INSERT INTO TodoCards(name,task,subtasks,subtaskdescription,targetdate) VALUES('$username','$task','$subtasks','$subtaskdescription','$targetdate')";
      $con->exec($q);

    }
    else {
      echo "<script> alert('Same card is already saved.') </script>";
    }

    echo "<script>
    FetchTodos();
     </script>";
  }
  catch (PDOException $e) {
    $message=$e->getMessage();
    echo "<script> alert(\"$message\") </script>";
  }
  finally{
    $con=NULL;
  }

}
else {
  echo "<script> alert('Create Todo Not Possible.') </script>";
  echo "<script>
  FetchTodos();
   </script>";
}

 ?>
