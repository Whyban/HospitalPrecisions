<?php
session_start();
if(empty($_SESSION['name']) || $_SESSION['role']!=1)
{
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');
    
      $fetch_query = mysqli_query($connection, "select max(id) as id from tbl_billing");
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
      
      $patient_name = $_REQUEST['patient_name'];
      $medicine = $_REQUEST['medicine'];    
      $room = $_REQUEST['room'];
      $total = $_REQUEST['total'];
      $status = $_REQUEST['status'];

        
      $insert_query = mysqli_query($connection, "insert into tbl_billing set patient_name='$patient_name', medicine='$medicine', room='$room', total='$total', status='$status'");

      if($insert_query>0)
      {
          $msg = "Billing created successfully";
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
                        <h4 class="page-title">Add Billing</h4>
                         
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Medicine</label>
                                            <select class="select" name="medicine" required>
                                                <option value="">Select</option>
                                            <?php
                                            $fetch_query = mysqli_query($connection, "select concat(category,' ',price) as medicine from tbl_medicine");
                                            while($row = mysqli_fetch_array($fetch_query)){
                                            ?>
                                                
                                                <option value="<?php echo $row['medicine']; ?>"><?php echo $row['medicine']; ?></option>
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
                                            $fetch_query = mysqli_query($connection, "select concat(category,' ',price) as room from tbl_roomrates");
                                            while($row = mysqli_fetch_array($fetch_query)){
                                            ?>
                                                
                                                <option value="<?php echo $row['room']; ?>"><?php echo $row['room']; ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <div class="">
                                            <input type="text" class="form-control" name="total" required>
                                        </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="display-block">Receipt Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="billing_active" value="1" checked>
                                    <label class="form-check-label" for="billing_active">
                                    Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="billing_inactive" value="0">
                                    <label class="form-check-label" for="billing_inactive">
                                    Inactive
                                    </label>
                                </div>
                            </div>
                            <div class="m-t-50 text-center ">
                                <button name="add-receipt" class="btn btn-primary submit-btn">Create Billing</button>
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