<?php
session_start();
if(empty($_SESSION['name']) || $_SESSION['role']!=1)
{
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');
    
    if(isset($_REQUEST['add-medicine']))
    {
      $category = $_REQUEST['category'];
      $price = $_REQUEST['price'];
      $status = $_REQUEST['status'];
      
      $insert_query = mysqli_query($connection, "insert into tbl_medicine set category='$category', price='$price', status='$status'");

      if($insert_query>0)
      {
          $msg = "Medicine created successfully";
      }
      else
      {
          $msg = "Error!";
      }
    }
?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 ">
                        <h4 class="page-title">Add Medicine</h4>
                         
                    </div>
                    <div class="col-sm-8  text-right m-b-20">
                        <a href="medicine.php" class="btn btn-primary btn-rounded float-right">Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                       <form method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Category <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="category" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input class="form-control" type="text" name="price" required> 
                                    </div>
                                </div>
                            <div class="form-group">
                                <label class="display-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="employee_active" value="1" checked>
                                    <label class="form-check-label" for="employee_active">
                                    Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="employee_inactive" value="0">
                                    <label class="form-check-label" for="employee_inactive">
                                    Inactive
                                    </label>
                                </div>
                            </div>
                            <div class="m-t-50 text-center">
                                <button class="btn btn-primary submit-btn" name="add-medicine">Create Medicine</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
    
<?php
    include('footer.php');
?>
<script type="text/javascript">
     <?php
        if(isset($msg)) {
            echo 'swal("' . $msg . '");';
        }
    ?>
</script>