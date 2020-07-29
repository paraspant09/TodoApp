<?php

      if(isset($_COOKIE['task']) && isset($_COOKIE['subtasks']) && isset($_COOKIE['subtaskdescription']) && isset($_COOKIE['targetdate']) && isset($_COOKIE['name'])
          && isset($_POST['task']) && isset($_POST['subtasks']) && isset($_POST['subtaskdescription']) && isset($_POST['targetdate']) ){
        $prevtask=$_COOKIE['task'];
        $prevsubtasks=$_COOKIE['subtasks'];
        $prevsubtaskdescription=$_COOKIE['subtaskdescription'];
        $prevtargetdate=$_COOKIE['targetdate'];
        $prevusername=$_COOKIE['name'];

        $task=$_POST['task'];
        $subtasks=$_POST['subtasks'];
        $subtaskdescription=$_POST['subtaskdescription'];
        $targetdate=$_POST['targetdate'];



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

          $q="SELECT name,task,subtasks,subtaskdescription,targetdate FROM TodoCards WHERE name='$prevusername' And task='$prevtask' And subtasks='$prevsubtasks' And subtaskdescription='$prevsubtaskdescription' And targetdate='$prevtargetdate'";
          $result=$con->query($q);
          $assoc=$result->fetch();

          if(!empty($assoc))
          {
            // echo $task." ".$subtasks." ".$subtaskdescription." ".$targetdate." ";
            $q="UPDATE TodoCards SET task='$task',subtasks='$subtasks',subtaskdescription='$subtaskdescription',targetdate='$targetdate' WHERE name='$prevusername' And task='$prevtask' And subtasks='$prevsubtasks' And subtaskdescription='$prevsubtaskdescription' And targetdate='$prevtargetdate'";
            $con->exec($q);

          }
          else {
            echo "<script> alert('Edit Not Possible.') </script>";
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
        echo "<script> alert('Edit Not Possible.') </script>";
        echo "<script>
        FetchTodos();
         </script>";
      }

 ?>
