<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
    integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
    crossorigin="anonymous"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
    integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
    integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
    crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

  <title>To Do List!</title>
</head>

<body>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button onclick="closeModal()" type="button" class="close" data-dismiss="editModal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <!-- modal form  -->
            <form action="/ToDOList/index.php" method="post">
              <input type="hidden" id="serialNo" name="serialNo">
              <div class="mb-3 mt-5">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="titleEdit" aria-describedby="emailHelp" name="title"
                  required>
              </div>
              <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" name="description"
                  id="descriptionEdit" style="height: 100px" required></textarea>
                <label for="description">Note Description</label>
              </div>
              <br>
              <button type="submit" class="btn btn-primary">Update Note</button>
            </form>
            <!-- modal form end  -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Modal end-->

  <!-- NavBar Starts -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/ToDOList/index.php">To Do List</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <!-- NavBar ends -->
  <!-- Connection establishing  -->
  <?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "toDoDB";
    $conn = mysqli_connect($servername,$username,$password,$database);
    if(!$conn)
    {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">              
      <strong>Error!! </strong> Something Went Wrong !!
      </div>';
    }     
    else{
      if(isset($_GET['delete']))
      {
        $sno = $_GET['delete'];
        $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn,$sql);
            if(!$result)
            {
              echo '<div style="width: 100%;" class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong></strong>Something Went Wrong !
              <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="onButtonPress()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            ';
            }
            else{
              echo '<div style="width: 100%;" class="alert alert-success alert-dismissible fade show" role="alert">
              Your note is deleted successfully!!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="onButtonPress()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            ';
            
            }
      }
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['serialNo']))
        {
       //Update record
       $sno = $_POST['serialNo'];
       $title = $_POST['title'];
       $description = $_POST['description'];
       $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno";
       $result = mysqli_query($conn,$sql);
        }
        else{
          $title = $_POST['title'];
          $description = $_POST['description'];
          
          $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
          $result = mysqli_query($conn,$sql);
            if(!$result)
            {
              echo '<div style="width: 100%;" class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong></strong>Something Went Wrong !
              <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="onButtonPress()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            ';
            }
            else{
              echo '<div style="width: 100%;" class="alert alert-success alert-dismissible fade show" role="alert">
              Your note is stored successfully!!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="onButtonPress()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            ';
            
            }
        }
        
        }
    }

?>
  <!-- Connection establishing  end -->


  <!-- Form to fill -->
  <div class="container">
    <form action="/ToDOList/index.php" method="post">
      <div class="mb-3 mt-5">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title" required>
      </div>
      <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description"
          style="height: 100px" required></textarea>
        <label for="description">Note Description</label>
      </div>
      <br>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <!-- Form to fill end -->

  <!-- Table of notes -->
  <div class="container">
    <table class="table myTable mt-5" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Fetching data from database -->
        <?php 
              $sn = 0;
              $sql = "SELECT * FROM `notes`";
              $result = mysqli_query($conn,$sql);
              while($row = mysqli_fetch_assoc($result))
              {
                $sn = $sn+1;
                echo ' <tr>
                <th scope="row">'.$sn.'</th>
                <td>'.$row['title'].'</td>
                <td>'.$row['description'].'</td>
                <td><button type="button" class="btn btn-info edit" '.$row['sno'].'">Edit</button>  <button type="button" class="btn btn-danger deletes"  id="d'.$row['sno'].'">Delete</button></td>
                </tr>';
                echo "<br/>";
              }        
              ?>
        <!-- Fetching data from database end -->
        <hr>
      </tbody>
    </table>
    <hr>
  </div>
  <!-- Table of notes end-->

  <!-- Bootstrap scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <!-- Bootstrap scripts end-->


  <script>
    function onButtonPress() {
      $('.alert').alert('close')
    }
    function closeModal() {
      $('#editModal').modal('toggle');
    }

  </script>

  <!-- Form control for preventing reload -->
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  <!-- Form control for preventing reload end -->



  <!-- Edit, delete javascript -->
  <script>
    edits = document.getElementsByClassName("edit");
    Array.from(edits).forEach((e) => {
      e.addEventListener('click', (ele) => {
        tr = ele.target.parentNode.parentNode;
        title = tr.getElementsByTagName('td')[0].innerText;
        description = tr.getElementsByTagName('td')[1].innerText;
        titleEdit.value = title;
        descriptionEdit.value = description;
        serialNo.value = ele.target.id;
        $('#editModal').modal('toggle');
      })
    })


    deletes = document.getElementsByClassName("deletes");
    const arr = Object.values(deletes);
    Array.from(deletes).forEach((e) => {
      e.addEventListener('click', (ele) => {
        snum = ele.target.id.substr(1,);
        // console.log(snum);
        var confirmation = confirm("Note will be deleted permanently");
        if (confirmation) {
          // console.log("yes");
          window.location = `/ToDOList/index.php?delete=${snum}`;


        }
        else {
          console.log("no");
        }
      })
    })

  </script>
  <!-- Edit, delete javascript end -->
</body>

</html>