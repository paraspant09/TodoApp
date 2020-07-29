<?php
  if (isset($_COOKIE['name'])) {
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

          $name=$_COOKIE['name'];
          $fetchByTask=$_GET['task'];

          if($fetchByTask!=""){
            $q="SELECT name,task,subtasks,subtaskdescription,targetdate FROM TodoCards WHERE name='$name' AND task='$fetchByTask'";
            $result=$con->query($q);
            $ct=0;
          }
          else {
            $q="SELECT name,task,subtasks,subtaskdescription,targetdate FROM TodoCards WHERE name='$name'";
            $result=$con->query($q);
            $ct=0;
          }

          while($assoc=$result->fetch(PDO::FETCH_ASSOC)){
            // $name=$assoc['name'];
            $number=$ct+1;
            $task=$assoc['task'];
            $subtasks=$assoc['subtasks'];
            $subtaskdescription=$assoc['subtaskdescription'];
            $targetdate=$assoc['targetdate'];

            echo "<script>
            task['$ct']='$task';
            subtasks['$ct']='$subtasks';
            subtaskdescription['$ct']='$subtaskdescription';
            targetdate['$ct']='$targetdate';
            number='$number';
            </script>";

            $ct++;
          }

          if(!$ct)
          {
            echo "<script> alert('No records to show.') </script>";
          }
  end:  }
        catch (PDOException $e) {
        $message=$e->getMessage();
        echo "<script> alert(\"$message\") </script>";
        }
        finally{
        $con=NULL;
        }

  }
  else {
    echo "<script>
    alert('No records to show.');
     </script>";
  }

 ?>
