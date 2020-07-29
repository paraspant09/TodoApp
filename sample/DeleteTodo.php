<?php
      $task=$_GET['task'];
      $subtasks=$_GET['subtasks'];
      $subtaskdescription=$_GET['subtaskdescription'];
      $targetdate=$_GET['targetdate'];
      $username=$_GET['name'];
  try {
        $con=new PDO('mysql:host=localhost;dbname=todoDB;','root');
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        try{
        $checkTable=$con->query("SELECT 1 FROM TodoCards LIMIT 1");
        }
        catch(Exception $e)
        {
          echo "<script>alert('No table is created yet please save records of hotels.')</script>";
          goto end;
        }

        $q="SELECT name,task,subtasks,subtaskdescription,targetdate FROM TodoCards WHERE name='$username' And task='$task' And subtasks='$subtasks' And subtaskdescription='$subtaskdescription' And targetdate='$targetdate'";
        $result=$con->query($q);
        $ct=0;

        while($assoc=$result->fetch(PDO::FETCH_ASSOC)){
          $q = "DELETE FROM TodoCards WHERE name='$username' And task='$task' And subtasks='$subtasks' And subtaskdescription='$subtaskdescription' And targetdate='$targetdate'";
          $stmt=$con->prepare($q);
          $stmt->execute();
          $ct++;
        }

        if(!$ct)
        {
          echo "<script> alert('No records to delete.') </script>";
        }
end:  }
      catch (PDOException $e) {
      $message=$e->getMessage();
      echo "<script> alert(\"$message\") </script>";
      }
      finally{
      $con=NULL;
      }
 ?>
