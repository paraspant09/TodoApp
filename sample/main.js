var task=[],subtasks=[],subtaskdescription=[],targetdate=[],number=0;

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function ShowCard(needFor) {
  if (needFor==0) {   //Edit
    document.getElementById("CardEntry").style.display="none";
    document.getElementById("CardUpdate").style.display="block";
  } else if(needFor==1){    //Create
    document.getElementById("CardEntry").style.display="block";
    document.getElementById("CardUpdate").style.display="none";
  }
  document.getElementById("bg-modal").style.display="flex";
}

function EditToShow(position) {
  document.getElementById("task").value=task[position];
  document.getElementById("subtasks").value=subtasks[position];
  document.getElementById("subtaskdescription").value=subtaskdescription[position];
  document.getElementById("targetdate").value=targetdate[position];

  document.cookie=`task=${task[position]}`;
  document.cookie=`subtasks=${subtasks[position]};`;
  document.cookie=`subtaskdescription=${subtaskdescription[position]};`;
  document.cookie=`targetdate=${targetdate[position]}`;

  ShowCard(0);
}

function CreateTable(){
  // console.log(task,subtasks,number);
  let headData = [ {text: "Task"}, {text: "Sub Tasks"}, {text: "Sub Task Descriptions"}, {text: "Target Date"} ,
  {text:"<button class='btn btn-warning' onclick='ShowCard(1)'>CREATE</button>"},
  {text:"<button class='btn btn-warning' onclick='DeleteSelected()'>DELETE SELECTED</button>"}];

  let dataRows = [];
  // let head2Data = [ {text: "Name"}, {text: "School Name"}, {text: "Roll Number"} ];

  let functionArray = [{className:"select-checkBox",eventName:"click",functionName:()=>{
    // console.log(document.getElementById(document.activeElement.id).parentElement.parentElement.id);
    let activeElementID=document.activeElement.id;
    let activeElementRowID=document.getElementById(activeElementID).parentElement.parentElement.id;
    let activeElementRowBorder=document.getElementById(activeElementRowID).style.border;
    if(activeElementRowBorder == "thick solid red")
        document.getElementById(activeElementRowID).style.border ="";
    else
        document.getElementById(activeElementRowID).style.border = "thick solid red";
  }}];

  let checkboxClass="select-checkBox";
  let autocompleteFillData=[];

  for (i = 0; i < number; i++) {
    let arraySubTasks=subtasks[i].split(",");
    let listSubTasks="";

    listSubTasks+=`<ul  class="list-group list-group-flush">`;
    arraySubTasks.forEach((item, i) => {
      listSubTasks+=`<li class="list-group-item">${item}</li>`;
    });
    listSubTasks+=`</ul>`;

    let arraySubTasksDescription=subtaskdescription[i].split(",");
    let listSubTasksDescription="";

    listSubTasksDescription+=`<ul  class="list-group list-group-flush">`;
    arraySubTasksDescription.forEach((item, i) => {
      listSubTasksDescription+=`<li class="list-group-item">${item}</li>`;
    });
    listSubTasksDescription+=`</ul>`;

    let currentRow = [ {text: task[i]}, {text: listSubTasks}, {text: listSubTasksDescription},{text: targetdate[i]},
    {text:"<button class='btn btn-dark' onclick='EditToShow("+i+")'>EDIT</button>"},
    {text:"<button class='btn btn-dark' onclick='DeleteRow("+i+")'>DELETE</button>"} ];

    autocompleteFillData[i]={name:task[i],id:task[i]};
    dataRows.push({
        checkboxId:"checkBox"+(i+1),
        className:"Rows",
        data: currentRow,
        id:"Row"+(i+1),
    });
  }

  let newDynamicTable = new DynamicTable({
      tableId: `tableData`,
      headData,
      dataRows,
      // head2Data,
      functionArray,
      addRowCount: true,
      addHeadDataAtBottom: true,
      addFilter: true,
      addLimit: true,
      addCheckboxes: true,
      checkboxClass
  });

  let newDynamicTableNode = newDynamicTable.createTable();
  let divNode = document.getElementById(`tableDiv`);
  divNode.appendChild(newDynamicTableNode);

  //Autocomplete

  // console.log(document.querySelector('input'));

  document.querySelector('input').setAttribute("id","input-autocomplete");
  let newAutocomplete =new Autocomplete();
  newAutocomplete.autocomplete(document.querySelector('input'),autocompleteFillData,"input-autocomplete");

  // let div=document.createElement("form");
  // divNode.insertBefore(div,document.getElementById('input-autocomplete'));

  document.querySelector('input').addEventListener(`input`, event => {
    if(document.querySelector('.row'))
        document.querySelector('.row').remove();
    if(document.querySelector('.table'))
        document.querySelector('.table').remove();
    document.querySelector('#FilterSearch').style.display="block";
    document.querySelector('#FindAll').style.display="none";
  });

}

function DeleteRow(num,bySelection=false) {
  // num=parseInt(num);
  document.getElementById("tableDiv").innerHTML="";
  const xhr=new XMLHttpRequest();
  xhr.onreadystatechange=function(){
    if(this.readyState==4 && this. status==200){
      // console.log(this.responseText);
      // console.log(task);
      if(!bySelection){
        // console.log(1);
        task=[];
        subtasks=[];
        subtaskdescription=[];
        targetdate=[];
        number=0;
        FetchTodos();
      }
    }
  };
  xhr.open('get',`DeleteTodo.php?name=${getCookie('name')}&task=${task[num]}&subtasks=${subtasks[num]}&subtaskdescription=${subtaskdescription[num]}&targetdate=${targetdate[num]}`,true);
  xhr.send();
}

function DeleteSelected() {
  let selectedArray=[],checkedNum=0;
  for (let i = 1; i <= number; i++) {
    let el=document.getElementById("checkBox"+i);
    if(el){
      if(el.checked){
        selectedArray[i-1]=true;
        checkedNum++;
      }
      else{
        selectedArray[i-1]=false;
      }
      // console.log(selectedArray,checkedNum);
    }
  }

  let currentChecked=0;
  for (let i = 1; i <= number; i++) {
    if(selectedArray[i-1]){
      currentChecked++;
      // console.log(currentChecked,checkedNum);
      if(currentChecked!=checkedNum){
        DeleteRow(i-1,true);
      }
      else {
        // console.log(1);
        DeleteRow(i-1);
         break;
      }
    }
  }
}
