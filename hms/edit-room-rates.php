<?php 
session_start();
if(empty($_SESSION['name']))
{
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "select * from tbl_roomrates where id='$id'");
$row = mysqli_fetch_array($fetch_query);

if(isset($_REQUEST['save-emp']))
{
      $category = $_REQUEST['category'];
      $price = $_REQUEST['price'];
      $status = $_REQUEST['status'];


      $update_query = mysqli_query($connection, "update tbl_roomrates set category='$category', price='$price', status='$status' where id='$id'");
      if($update_query>0)
      {
          $msg = "Room rates updated successfully";
          $fetch_query = mysqli_query($connection, "select * from tbl_roomrates where id='$id'");
          $row = mysqli_fetch_array($fetch_query);   
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
                        <h4 class="page-title">Edit Room Rates</h4>
                    </div>
                    <div class="col-sm-8  text-right m-b-20">
                        <a href="room-rates.php" class="btn btn-primary btn-rounded float-right">Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Category <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="category" value="<?php  echo $row['category'];  ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input class="form-control" type="text" name="price" value="<?php echo $row['price']; ?>">
                                    </div>
                                </div>
							
                            <div class="form-group">
                                <label class="display-block">Status</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="status" id="roomrates_active" value="1" <?php if($row['status']==1) { echo 'checked' ; } ?>>
									<label class="form-check-label" for="roomrates_active">
									Active
									</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="status" id="roomrates_inactive" value="0" <?php if($row['status']==0) { echo 'checked' ; } ?>>
									<label class="form-check-label" for="roomrates_inactive">
									Inactive
									</label>
								</div>
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" name="save-emp">Save</button>
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