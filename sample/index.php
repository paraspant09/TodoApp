<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>TODO App</title>
  </head>
  <body>
        <div id="tableDiv">
        </div>

        <div id="bg-modal">
          <div class="card" id="modal-CardEntry">
            <label class="Cancel" onclick="RemoveCard()">+</label>
            <h2  class="Title"> TODO CARD </h2>

            <form class="Form card-body" action="index.php" method="post">
              <!-- <label for="Name" id="HideIt">Name</label>
              <input type="text" id="username" class="NormalTextBox form-control" placeholder="Steve" name="username"> -->

              <label for="task">Task</label>
              <input type="text" id="task" class="NormalTextBox form-control" placeholder="Job" name="task">

              <label for="subtasks">Sub Tasks</label>
              <input type="text" id="subtasks" class="NormalTextBox form-control" placeholder="Study,Internship,Projects" name="subtasks">

              <label for="subtaskdescription">Sub Task Description</label>
              <input type="text" id="subtaskdescription" class="NormalTextBox form-control" placeholder="Computer Science,XYZ ltd.,Car race game" name="subtaskdescription">

              <label for="targetdate">Target Date</label>
              <input type="date" id="targetdate" class="NormalTextBox form-control" name="targetdate">

              <input type="submit" class="submit btn btn-info" id="CardEntry" name="Create" onclick="return CardCheckCreditionals()" value="Create Card">

              <input type="submit" class="submit btn btn-info" id="CardUpdate" name="Update" onclick="return CardCheckCreditionals()" value="Update Card">

            </form>
          </div>
      </div>

      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/gh/TaxHeal-in/js-bootstrap-tables@0.3.4/src/html.js">
      </script>
      <script src="https://cdn.jsdelivr.net/gh/TaxHeal-in/js-bootstrap-tables@0.3.4/src/autocomplete.js">
      </script>
      <script src="https://cdn.jsdelivr.net/gh/TaxHeal-in/js-bootstrap-tables@0.3.4/src/table.js">
      </script>

      <script type="text/javascript">
      function PromptName() {
        let person = prompt('Please enter your name:');
        if (person == null || person == '') {
          alert('No name is entered.');
          CreateTable();
        }
        else {
          document.cookie='name='+person;
          FetchTodos();
        }
      }
      </script>
      <script src="main.js">
      </script>
      <script src="script.js">
      </script>

      <?php
        if(isset($_POST['Create'])){
          include 'CreateTodo.php';
        }
        else if (isset($_POST['Update'])) {
          include 'EditTodo.php';
        }
        else {
          echo "<script>
          PromptName();
          </script>";
        }
       ?>

       <button type="button" id="FilterSearch" class="submit btn btn-info" onclick="FetchTodos(true)" name="button">FIND</button>
       <button type="button" id="FindAll" class="submit btn btn-info" onclick="FetchAllTodos()" name="button">FIND ALL</button>

  </body>
</html>
