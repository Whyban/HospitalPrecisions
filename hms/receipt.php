<?php
session_start();
if(empty($_SESSION['name']))
{
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');
?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Receipt</h4>
                    </div>
                    <?php if($_SESSION['role']==1 || $_SESSION['role']==2){?>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-receipt.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Receipt</a>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                                    <table class="datatable table table-stripped ">
                                    <thead>
                                        <tr>
                                            <th>Patient No.</th>
                                            <th>Patient Name</th>
                                            <th>Room</th>
                                            <th>Doctor Name</th>
                                            <th>Address</th>
                                            <th>Admitted</th>
                                            <th>Status</th>
                                            <?php if($_SESSION['role']==1 || $_SESSION['role']==2){?>
                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($_GET['ids'])){
                                        $id = $_GET['ids'];
                                        $delete_query = mysqli_query($connection, "delete from tbl_receipt where id='$id'");
                                        }
                                        $fetch_query = mysqli_query($connection, "select * from tbl_receipt");
                                        while($row = mysqli_fetch_array($fetch_query))
                                        {
                                            $name = explode(",", $row['patient_name']);
                                            $name = $name[0];
                                        ?>
                                        <tr>
                                        <td><?php echo $row['patient_no']; ?></td>
                                            <td><?php echo $name; ?></td>
                                            <td><?php echo $row['room']; ?></td>
                                            <td><?php echo $row['doctor']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['admitted']; ?></td>
                                            <?php if($row['status']==1) { ?>
                                            <td><span class="custom-badge status-green">Active</span></td>
                                        <?php } else {?>
                                            <td><span class="custom-badge status-red">Inactive</span></td>
                                        <?php } ?>
                                        <?php if($_SESSION['role']==1 || $_SESSION['role']==2){?>
                                            <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-receipt.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="receipt.php?ids=<?php echo $row['id'];?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            <?php } ?>
                                            </div>
                                        </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
				
            </div>
            
        </div>
		
   
<?php
include('footer.php');
?>
<script language="JavaScript" type="text/javascript">
function confirmDelete(){
    return confirm('Are you sure want to delete this Receipt?');
}
</script>