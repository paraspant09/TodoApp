
function RemoveCard() {
  document.getElementById("bg-modal").style.display="none";

  document.getElementById("task").value="";
  document.getElementById("subtasks").value="";
  document.getElementById("subtaskdescription").value="";
  document.getElementById("targetdate").value="";
}

function CardCheckCreditionals(){
	let task=document.getElementById("task");
  let subtasks=document.getElementById("subtasks");
  let subtaskdescription=document.getElementById("subtaskdescription");
  let targetdate=document.getElementById("targetdate");

	if(task.value=="")
	{
		alert("Enter task!!");
		return false;
	}
  if(subtasks.value=="")
	{
		alert("Enter Sub Tasks!!");
		return false;
	}
  if(subtaskdescription.value=="")
  {
    alert("Enter Sub Task Descriptions!!");
    return false;
  }
  if(targetdate.value=="")
  {
    alert("Enter Target Date!!");
    return false;
  }
}

function FetchTodos(byName=false){
  const xhr=new XMLHttpRequest();
  xhr.onreadystatechange=function(){
    if(this.readyState==4 && this. status==200){
      // console.log(this.responseText);
      let array=this.responseText.split("</script>");
      // console.log(array);
      for (var i = 0; i < array.length; i++) {
        array[i]=array[i].substring(9,array[i].length);
      }
      for (var i = 0; i < array.length-1; i++) {
        eval(array[i]);
      }
      eval(CreateTable());
    }
  };
  if(byName==false)
      xhr.open('get','FetchTodos.php?task='+"",true);
  else{
      xhr.open('get','FetchTodos.php?task='+document.getElementById("input-autocomplete").value,true);
      document.querySelector('#FindAll').style.display="block";
      document.getElementById("FilterSearch").style.display="none";
      document.getElementById("input-autocomplete").remove();
  }
  xhr.send();
}

function FetchAllTodos(){
  document.getElementById("tableDiv").innerHTML="";
  FetchTodos();
}
