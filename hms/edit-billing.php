<?php 
session_start();
if(empty($_SESSION['name']))
{
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "select * from tbl_billing where id='$id'");
$row = mysqli_fetch_array($fetch_query);

if(isset($_REQUEST['save-billing']))
{

    $patient_name = $_REQUEST['patient_name'];
    $medicine = $_REQUEST['medicine'];    
    $room = $_REQUEST['room'];
    $total = $_REQUEST['total'];
    $status = $_REQUEST['status'];


      $update_query = mysqli_query($connection, "update tbl_billing set patient_name='$patient_name', medicine='$medicine', room='$room', total='$total', status='$status' where id='$id'");
      if($update_query>0)
      {
          $msg = "Billing updated successfully";
          $fetch_query = mysqli_query($connection, "select * from tbl_billing where id='$id'");
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
                        <a href="billing.php" class="btn btn-primary btn-rounded float-right">Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="post" >
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">    
                                    <label>Patient Name</label>
                                        <select class="select" name="patient_name" >
                                            <option value="">Select</option>
                                        <?php
                                        $fetch_query = mysqli_query($connection, "select * from tbl_billing where id='$id'");
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Medicine</label>
                                        <select class="select" name="medicine" >
                                            <option value="">Select</option>
                                        <?php
                                        $fetch_query = mysqli_query($connection, "select * from tbl_billing where id='$id'");
                                        $row = mysqli_fetch_array($fetch_query);   
                                        $pat_name = explode(",", $row['medicine']);
                                        $pat_name = $pat_name[0];

                                        $fetch_query = mysqli_query($connection, "select concat(category,' ',price) as name  from tbl_medicine");
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
                                        $fetch_query = mysqli_query($connection, "select * from tbl_billing where id='$id'");
                                        $row = mysqli_fetch_array($fetch_query);   
                                        $pat_name = explode(",", $row['room']);
                                        $pat_name = $pat_name[0];

                                        $fetch_query = mysqli_query($connection, "select concat(category,' ',price) as name  from tbl_roomrates");
                                        while($rows = mysqli_fetch_array($fetch_query)){
                                        ?>
                                            
                                    <option <?php if($rows['name'] == $pat_name) { ?> selected="selected"; <?php } ?>><?php echo $rows['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <div class="">
                                            <input type="text" class="form-control" id="total" name="total" value="<?php  echo $row['total'];  ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
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
                                <button name="save-billing" class="btn btn-primary submit-btn">Save</button>
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