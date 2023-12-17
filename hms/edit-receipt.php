<?php 
session_start();
if(empty($_SESSION['name']))
{
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "select * from tbl_receipt where id='$id'");
$row = mysqli_fetch_array($fetch_query);

if(isset($_REQUEST['save-receipt']))
{
    $patient_no = $_REQUEST['patient_no'];
    $patient_name = $_REQUEST['patient_name'];
    $room = $_REQUEST['room'];    
    $doctor = $_REQUEST['doctor'];
    $address = $_REQUEST['address'];
    $admitted = $_REQUEST['admitted'];
    $status = $_REQUEST['status'];


      $update_query = mysqli_query($connection, "update tbl_receipt set patient_no='$patient_no', patient_name='$patient_name', room='$room', doctor='$doctor', address='$address', admitted='$admitted', status='$status' where id='$id'");
      if($update_query>0)
      {
          $msg = "Receipt updated successfully";
          $fetch_query = mysqli_query($connection, "select * from tbl_receipt where id='$id'");
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
                        <h4 class="page-title">Edit Receipt</h4>
                    </div>
                    <div class="col-sm-8  text-right m-b-20">
                        <a href="receipt.php" class="btn btn-primary btn-rounded float-right">Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="post" >
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">    
                                        <label>Patient No. <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="patient_no" value="<?php  echo $row['patient_no'];  ?>"> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Name</label>
                                        <select class="select" name="patient_name" >
                                            <option value="">Select</option>
                                        <?php
                                        $fetch_query = mysqli_query($connection, "select * from tbl_receipt where id='$id'");
                                        $row = mysqli_fetch_array($fetch_query);   
                                        $pat_name = explode(",", $row['patient_name']);
                                        $pat_name = $pat_name[0];

                                        $fetch_query = mysqli_query($connection, "select concat(first_name,' ',last_name) as name  from tbl_patient");
                                        while($rows = mysqli_fetch_array($fetch_query)){
                                        ?>
                                            
                                    <option <?php if($rows['name'] == $pat_name) { ?> selected="selected"; <?php } ?>><?php echo $rows['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Room</label>
                                        <select class="select" name="room" >
                                            <option value="">Select</option>
                                            <?php
                                        $fetch_query = mysqli_query($connection, "select category from tbl_roomrates");
                                        while($dept = mysqli_fetch_array($fetch_query)){
                                        ?>
                                            <option <?php if($dept['category']==$row['room'] ) { ?> selected="selected"; <?php } ?>><?php echo $dept['category']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <select class="select" name="doctor" >
                                            <option value="">Select</option>
                                            <?php
                                        $fetch_query = mysqli_query($connection, "select concat(first_name,' ',last_name) as name from tbl_employee where role=2 and status=1");
                                        while($doc = mysqli_fetch_array($fetch_query)){
                                        ?>
                                            <option <?php if($doc['name']==$row['doctor'] ) { ?> selected="selected"; <?php } ?>><?php echo $doc['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <div class="">
                                            <input type="text" class="form-control" name="address" value="<?php  echo $row['address'];  ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Admitted</label>
                                        <div class="">
                                            <input type="text" class="form-control" id="admitted" name="admitted" value="<?php  echo $row['admitted'];  ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="display-block">Appointment Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="1" <?php if($row['status']==1) { echo 'checked' ; } ?>>
                                    <label class="form-check-label" for="product_active">
                                    Active  
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="0" <?php if($row['status']==0) { echo 'checked' ; } ?>>
                                    <label class="form-check-label" for="product_inactive">
                                    Inactive
                                    </label>
                                </div>
                            </div>
                             
                            <div class="m-t-20 text-center">
                                <button name="save-receipt" class="btn btn-primary submit-btn">Save</button>
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