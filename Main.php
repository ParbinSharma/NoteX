<?php
require('Db_connect.php');
session_start();

$Username= $_SESSION['username'];
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: Login.php");
    exit;
}
function logout(){
  session_destroy();
        echo "      <div class='center'>
              <div class='alert2 center' style='background-color:yellow;' id='alert2'>
        You have been logged out.
<a href='Login.php' class='divert'>Login</a>
      </div>
      </div>";
      
  
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoteX</title>
      <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="Style.css">
<link rel="icon"  href="favicon.png">
  </head>
  <body>
    <!-- Modal -->
<div class="modal fade " id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog mol">
    <div class="modal-content mol">
      <div class="modal-header">
        <h5 class="i modal-title" id="exampleModalLabel">Update Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="Main.php" method="post" accept-charset="utf-8">
      <div class="modal-body">
          
                     <input type="hidden" id="snoEdit" name="snoEdit">

            <div class="mb-3">
    <label for="title" class="form-label">Note title</label>
    <input type="text" class="b form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">

  </div>
  <div class="mb-3">
<div class="form-floating">
  <textarea class="b form-control" placeholder="" name="descriptionEdit" id="descriptionEdit" style="height: 100px"></textarea>

    <label for="description">Description</label>
</div>
  </div>

  

      </div>
      <div class="modal-footer">
        <button type="button" class="cc" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="sc">Save changes</button>
                </form>
      </div>
    </div>
  </div>
</div>


<?php
$update=false;
$warning=false;
$deleted=false;
$inserted=false;
if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `$Username` WHERE `Serial no.` = $sno";
  $result = mysqli_query($conn, $sql);
if($result){
  $deleted=true;
}
else{
  $warning=true;
}
  }
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
 
 if (isset( $_POST['snoEdit'])){
  // Update the record

    $snop = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];
$tit= htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
  $dec= htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
  // Sql query to be executed
  $sql = "UPDATE `$Username` SET `Title` = '$tit', `Description` = '$dec' WHERE `Serial no.` = $snop;";
  $result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
    
}
else{
    $warning=true;
}
}
if(isset( $_POST['Insert'])){
  $title= $_POST["title"];
  $description= $_POST["textarea"];
  $tit= htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
  $dec= htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $sql = "INSERT INTO `$Username` (`Serial no.`, `Title`, `Description`) VALUES (NULL, '$tit', '$dec')";
  $result = mysqli_query($conn, $sql);
  if($result){ 
      $inserted = true;
  }
  else{
      $warning=true;
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
  } 
}
}
if(array_key_exists('Logout', $_POST)){
  logout();
  
} 

?>

    <nav>
      <div class="label">
        <img alt="logo" src="logo.png" class="logo"/>
      </div>
      <div class="menu">
      
          <li class="option"><a href="index.html">Home</a></li>
          <li class="option"><?php echo "@".$Username;?></li>
          <li class="option">
<form method="post"> 
<input type="submit" name="Logout" class="logout" value="Logout" /> 
</form>
</li>
       
      </div>
      </nav>

<?php
      if($update==true){
      echo "      <div class='center'>
              <div class='alert' style='background-color:green;' id='alert'>
        <strong>Success!</strong>&nbsp; Note updated.

      </div>
      </div>";
      }
      if($warning==true){
      echo "      <div class='center'>
              <div class='alert' style='background-color:red;' id='alert'>
        <strong>Warning!</strong>&nbsp; Something went wrong.

      </div>
      </div>";
      }
      if($inserted==true){
      echo "      <div class='center'>
              <div class='alert' style='background-color:green;' id='alert'>
        <strong>Success!</strong>&nbsp; Note has been inserted.

      </div>
      </div>";
      }
      if($deleted==true){
      echo "      <div class='center'>
              <div class='alert' style='background-color:yellow;' id='alert'>
        <strong>Success!</strong>&nbsp; Note has been deleted.

      </div>
      </div>";
      }

?>

    <form class="container form" action="Main.php" method="post">
  <div class="mb-3">
    <label for="title" class="form-label  tit">Title</label>
    <input type="text" class=" form-control b" id="title" name="title" aria-describedby="emailHelp">
  </div>
                       <input type="hidden" id="Insert" name="Insert">
  <div class="mb-3">

<div class="form-floating">
  <textarea class="form-control b " placeholder="Leave a comment here" name="textarea" id="textarea" style="height: 100px"></textarea>
  <label for="textarea " class="dec ">Description</label>
</div>
  </div>

        <button type="submit" class="sub">Insert</button>
</form>
  <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col"> No.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql= "SELECT * FROM `$Username`";
$sno=0;
$result = mysqli_query($conn, $sql);

$num =mysqli_num_rows($result);
if($num >0){
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            
                        echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['Title'] . "</td>
            <td>". $row['Description'] . "</td>
            <td> <button class='edit btn-sm btn-primary' id=".$row['Serial no.'].">Edit</button> <button class='delete btn-sm btn-primary' id=d".$row['Serial no.'].">Delete</button>  </td>
          </tr>";
        } 
        } 
else{
  echo mysqli_error($conn);
}
?>
  </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
     
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
        edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title,description)
        titleEdit.value=title;
        descriptionEdit.value=description;
       snoEdit.value=e.target.id;
       
        $('#editModal').modal('toggle');
      })
    })
    
    
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `Main.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
    
    
    setTimeout(() => {
  const box = document.getElementById('alert');

  // 👇️ removes element from DOM
  box.style.display = 'none';

  // 👇️ hides element (still takes up space on page)
  // box.style.visibility = 'hidden';
}, 2000); // 👈️ time in milliseconds
  </script>
  </body>
</html>