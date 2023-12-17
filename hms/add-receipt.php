<?php
session_start();
if(empty($_SESSION['name']) || $_SESSION['role']!=1)
{
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');
    
      $fetch_query = mysqli_query($connection, "select max(id) as id from tbl_receipt");
      $row = mysqli_fetch_row($fetch_query);
      if($row[0]==0)
      {
        $ptnt_no = 1;
      }
      else
      { 
        $ptnt_no = $row[0] + 1;
      }
    if(isset($_REQUEST['add-receipt']))
    {
      
      $patient_no = 'PTNT-'.$ptnt_no;
      $patient_name = $_REQUEST['patient_name'];
      $room = $_REQUEST['room'];    
      $doctor = $_REQUEST['doctor'];
      $address = $_REQUEST['address'];
      $admitted = $_REQUEST['admitted'];
      $status = $_REQUEST['status'];

        
      $insert_query = mysqli_query($connection, "insert into tbl_receipt set patient_no='$patient_no', patient_name='$patient_name', room='$room', doctor='$doctor', address='$address', admitted='$admitted', status='$status'");

      if($insert_query>0)
      {
          $msg = "Receipt created successfully";
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
                        <h4 class="page-title">Add Receipt</h4>
                         
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
                                        <input class="form-control" type="text" name="patient_id" value="<?php if(!empty($ptnt_no)) { echo 'PTNT-'.$ptnt_no; } else { echo "PTNT-1"; } ?>" disabled> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Name</label>
                                            <select class="select" name="patient_name" required>
                                                <option value="">Select</option>
                                            <?php
                                            $fetch_query = mysqli_query($connection, "select concat(first_name,' ',last_name) as name from tbl_patient");
                                            while($row = mysqli_fetch_array($fetch_query)){
                                            ?>
                                                
                                                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Room</label>
                                        <select class="select" name="room" required>
                                            <option value="">Select</option>
                                        <?php
                                        $fetch_query = mysqli_query($connection, "select category from tbl_roomrates");
                                        while($row = mysqli_fetch_array($fetch_query)){
                                        ?>
                                            <option><?php echo $row['category']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <select class="select" name="doctor" required>
                                            <option value="">Select</option>
                                            <?php
                                        $fetch_query = mysqli_query($connection, "select concat(first_name,' ',last_name) as name from tbl_employee where role=2 and status=1");
                                        while($row = mysqli_fetch_array($fetch_query)){
                                        ?>
                                            <option><?php echo $row['name']; ?></option>
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
                                            <input type="text" class="form-control" name="address" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Admitted</label>
                                        <div class="#">
                                            <input type="text" class="form-control" name="admitted" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="display-block">Receipt Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="1" checked>
                                    <label class="form-check-label" for="product_active">
                                    Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="0">
                                    <label class="form-check-label" for="product_inactive">
                                    Inactive
                                    </label>
                                </div>
                            </div>
                             
                            <div class="m-t-20 text-center">
                                <button name="add-receipt" class="btn btn-primary submit-btn">Create Receipt</button>
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