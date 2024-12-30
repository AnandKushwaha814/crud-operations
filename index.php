<?php
$update = false;
$delete = false;
$insert = false;
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notes";
// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
//Check connection
if (!$conn) {
    die("Sorry failed to connceting" . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `notes` WHERE `sno`='$sno'";
    if (mysqli_query($conn, $sql)) {
        $delete = true;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // if update the data
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $desc = $_POST['descEdit'];
        // Query Inert
        $sql = "UPDATE `notes` SET `title` = '$title', `desc` = '$desc' WHERE `notes`.`sno` = $sno";
        if (mysqli_query($conn, $sql)) {
            $update = true;
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Waring!</strong> Your Entery was not submitted successfully.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    } else {
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        // Query Inert
        $sql = "INSERT INTO `notes` (`title`,`desc`) values ('$title','$desc')";
        if (mysqli_query($conn, $sql)) {
            // echo "The Record is inserted successfully";
            $insert = true;
        } else {
            echo "The record was not inserted successfully becasue of thi error ------>" . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <title>Todo List</title>
  </head>
  <body>

<!-- Creating Modal -->
<!-- Edit  modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
EditModal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit records</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/php/crud/index.php" method="post">
      <div class="modal-body">
        <input type="hidden" name="snoEdit"id="snoEdit">
          <div class="mb-3">
            <label for="title" class="form-label">Item Title</label>
            <input
              type="text"
              class="form-control"
              id="titleEdit"
              name="titleEdit"
              aria-describedby="emailHelp"
            />
          </div>
          <div class="form-group">
            <label for="desc">Item Description</label>
            <textarea
              class="form-control"
              id="descEdit"
              name="descEdit"
              rows="3"
            ></textarea>
          </div>
          <!-- <button type="submit" class="btn btn-primary my-3">Update item</button> -->
        </div>
        <div class="modal-footer d-block mr-auto">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!---------------------------------------------NAVBAR------------------------------------------------------>
    <nav class="navbar navbar-expand-lg bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Todo</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact Us</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>
      </div>
    </nav>
<!-- -----------------------------------------Successfully Inserted-------------------- -->
 <?php
if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> You item has been inserted successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>
 <?php
if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong>Your notes has been updated Successfully😍.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>
 <?php
if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong>Your notes has been deleted Successfully😍.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>

    <!-----------------------------------Form------------------------->
    <div class="container my-4">
      <h2>Add a List</h2>
      <form action="/php/crud/index.php" method="post">
        <div class="mb-3">
          <label for="title" class="form-label">Item Title</label>
          <input
            type="text"
            class="form-control"
            id="title"
            name="title"
            aria-describedby="emailHelp"
          />
        </div>
        <div class="form-group">
          <label for="desc">Item Description</label>
          <textarea
            class="form-control"
            id="desc"
            name="desc"
            rows="3"
          ></textarea>
        </div>
        <button type="submit" class="btn btn-primary my-3">Add Item</button>
      </form>
    </div>
    <!------------------------------------------------Form Data Desplaying---------------------->
    <div class="container my-4">
      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">S.No</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
$sql = "SELECT * FROM `notes`";
$result = mysqli_query($conn, $sql);
$sno = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $sno = $sno + 1;
    echo "<tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row['title'] . "</td>
            <td>" . $row['desc'] . "</td>
            <td><button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['sno'] . ">Delete</button></td>
          </tr>";

}?>
        </tbody>
      </table>
    </div>

    <!-- JQuery script -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script>
      $(document).ready( function () {
    $('#myTable').DataTable();
} );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
        console.log("Edit");
        tr=e.target.parentNode.parentNode;
          title=tr.getElementsByTagName("td")[0].innerText;
          desc =tr.getElementsByTagName("td")[1].innerText;
          console.log(title,desc);
          titleEdit.value=title;
          descEdit.value=desc;
          snoEdit.value=e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle')
        })
      })
      delets = document.getElementsByClassName('delete');
      Array.from(delets).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          sno=e.target.id.substr(1,);
          if(confirm("Are you sure you want to delete?")){
              console.log("yes");
              window.location=`/php/crud/index.php?delete=${sno}`;
          }else{
            console.log("no");

          }
        })
      })
    </script>
  </body>
</html>
