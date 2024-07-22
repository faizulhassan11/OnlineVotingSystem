<?php

if(isset($_POST['addElectionBtn'])){
    $election_topic = mysqli_real_escape_string($db,$_POST['election_topic']);
    $number_of_candidates = mysqli_real_escape_string($db,$_POST['number_of_candidates']);
    $starting_date = mysqli_real_escape_string($db,$_POST['starting_date']);
    $ending_date = mysqli_real_escape_string($db,$_POST['ending_date']);
    $inserted_by = $_SESSION['username'];
    $inserted_on = date("Y-m-d");

    $date1 = date_create($inserted_on);
    $date2 = date_create($starting_date);
    $diff = date_diff($date1, $date2);

    if((int)$diff->format("%R%a")>0){
        $status = "InActive";
    }else{
        $status = "Active";
    }
    
    // insert into election table

    mysqli_query($db,"INSERT INTO elections(election_topic,no_of_candidate,starting_date,ending_date,status,inserted_by,inserted_on) VALUES('$election_topic','$number_of_candidates','$starting_date','$ending_date','$status','$inserted_by','$inserted_on')")or die(mysqli_error($db));
    header("location:index.php?addElectionPage=1&added=1");  
}

?>




<?php
if(isset($_GET['added'])){
 ?>

<div class="alert alert-success my-3" role="alert">
    Election has been added successfully.
</div>

<?php 
}else if(isset($_GET['delete_id'])){
    $delete_id = $_GET["delete_id"];
    mysqli_query($db,"DELETE FROM elections WHERE id = '$delete_id'" ) or die(mysqli_error($db));
    ?>
<div class="alert alert-danger my-3" role="alert">
    Your Election has been Deleted successfully.
</div>
<?php
} ?>


<div class="row my-3">
    <div class="col-4">
        <h3>Add New Election</h3>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="election_topic" class="form-control" placeholder="Election Topic" required />
            </div>
            <div class="form-group">
                <input type="number" name="number_of_candidates" class="form-control" placeholder="No of Candidates"
                    required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type = 'Date'" name="starting_date" class="form-control"
                    placeholder="Starting Date" required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type = 'Date'" name="ending_date" class="form-control"
                    placeholder="Ending Date" required />
            </div>
            <input type="submit" value="Add Election" name="addElectionBtn" class="btn bg-green">

        </form>
    </div>
    <div class="col-8">
        <h3>Upcoming Election</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Election Name</th>
                    <th scope="col"># Candidates</th>
                    <th scope="col">Starting Date</th>
                    <th scope="col">Ending Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetchingData = mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));
               $isAnyElectionAdded = mysqli_num_rows($fetchingData);

               if($isAnyElectionAdded > 0){
                $sno = 1;
                while($row = mysqli_fetch_assoc($fetchingData)){
                    $election_id = $row['id'];
                    // echo $election_id;
                ?>
                <tr>
                    <td><?= $sno++; ?></td>
                    <td><?= $row['election_topic']; ?></td>
                    <td><?= $row['no_of_candidate']; ?></td>
                    <td><?= $row['starting_date']; ?></td>
                    <td><?= $row['ending_date']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td>
                        <a href="<?=- $row['id'];?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="DeleteData(<?= $election_id;?>)">Delete</button>
                    </td>


                </tr>
                <?php
                }
               }
               else{
                ?>
                <tr>
                    <td colspan="7">No Any Election Added Yet.</td>
                </tr>

                <?php
               }
               ?>
            </tbody>
        </table>
    </div>
</div>

<script>
const DeleteData = (e_id) => {
    let c = confirm('Are you really want to delete it');

    if (c == true) {
        location.assign('index.php?addElectionPage=1&delete_id=' + e_id);
    }
}
</script>