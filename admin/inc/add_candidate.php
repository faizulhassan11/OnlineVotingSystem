<?php

if(isset($_POST['addCandidateBtn'])){
    $election_id = mysqli_real_escape_string($db,$_POST['election_id']);
    $candidate_name = mysqli_real_escape_string($db,$_POST['candidate_name']);
    $candidate_details = mysqli_real_escape_string($db,$_POST['candidate_details']);
    $inserted_by = $_SESSION['username'];
    $inserted_on = date("Y-m-d");

    //  Photgraph logic starts
    $targeted_folder = "../assets/images/candidate_photos/";

    $candidate_photo =  $targeted_folder.rand(1111111111 , 9999999999)."_".rand(1111111111 , 9999999999).$_FILES['candidate_photo']['name'];

    $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];

    $candidate_photo_type = strtolower(pathinfo($candidate_photo,PATHINFO_EXTENSION));
    $allowed_types = array("jpg","png","jpeg");

    $image_size =  $_FILES['candidate_photo']['size'];

    if($image_size < 2000000){  // 2MB

        if(in_array($candidate_photo_type , $allowed_types)){
            if(move_uploaded_file($candidate_photo_tmp_name,$candidate_photo)){

                 // insert into election table

                 mysqli_query($db,"INSERT INTO candidate_details (election_id,candidate_name,candidate_details,candidate_photo,inserted_by,inserted_on) VALUES('$election_id','$candidate_name','$candidate_details','$candidate_photo','$inserted_by','$inserted_on')")or die(mysqli_error($db));

                header("location:index.php?addCandidatePage=1&added=1");  
    
            }
            else{
        header("location:index.php?addCandidatePage=1&isFailed=1");

            }
        }
        else{
        header("location:index.php?addCandidatePage=1&invalidFile=1");

        }
    }  
    else{
        header("location:index.php?addCandidatePage=1&largeFile=1");
    }
   
   
}

?>




<?php
if(isset($_GET['added'])){
 ?>

<div class="alert alert-success my-3" role="alert">
    Candidate has been added successfully.
</div>

<?php
}
else if (isset($_GET['largeFile'])){
    ?>
<div class="alert alert-danger my-3" role="alert">
    Candidate image is too large , Maximum size is 2mbs.
</div>

<?php
}
else if(isset($_GET['invalidFile'])){
 ?>

<div class="alert alert-danger my-3" role="alert">
    Invalid image type (only , jpg , png and jpeg files are allowed).
</div>

<?php
}
else if(isset($_GET['isFailed'])){
    ?>
<div class="alert alert-danger my-3" role="alert">
    Image uploading failed, please try again.
</div>

<?php
}

?>


<div class="row my-3">
    <div class="col-4">
        <h3>Add New Candidates</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <select class="form-control" name="election_id" id="">
                    <option value="">Select Election</option>
                    <?php
                    $fetchingElections = mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));
                    $isAnyElectionAdded = mysqli_num_rows($fetchingElections);
                    if($isAnyElectionAdded > 0){
                        while($row = mysqli_fetch_assoc($fetchingElections)){

                            $election_id = $row['id'];
                            $election_name = $row['election_topic'];
                            $allowed_candidates = $row['no_of_candidate'];

                            // Now checking how many candidate are added in this election
                            $fetchingCandidate = mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id = '$election_id'")or die(mysqli_error($db));

                            $added_candidates = mysqli_num_rows($fetchingCandidate);

                            // echo "$allowed_candidates ,  $added_candidates";
                            
                            if($added_candidates < $allowed_candidates){

                          
                           ?>


                    <option value="<?=$election_id;?>"><?=$election_name;?></option>

                    <?php
                      }
                        }

                    }
                    else{
                        ?>

                    <option value="">Please add election first</option>



                    <?php
                    }
                    ?>
                </select>

            </div>
            <div class="form-group">
                <input type="text" name="candidate_name" class="form-control" placeholder="Candidate Name" required />
            </div>
            <div class="form-group">
                <input type="file" name="candidate_photo" class="form-control" placeholder="Candidate Photo" required />
            </div>
            <div class="form-group">
                <input type="text" name="candidate_details" class="form-control" placeholder="Candidate Details"
                    required />
            </div>
            <input type="submit" value="Add Candidate" name="addCandidateBtn" class="btn bg-green">

        </form>
    </div>
    <div class="col-8">
        <h3>Candidates Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Elections</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetchingData = mysqli_query($db,"SELECT * FROM candidate_details") or die(mysqli_error($db));
               $isAnyCandidateAdded = mysqli_num_rows($fetchingData);

               if($isAnyCandidateAdded > 0){
                $sno = 1;
                while($row = mysqli_fetch_assoc($fetchingData)){

                    $election_id = $row['election_id'];
                    $fetchingElectionName = mysqli_query($db,"SELECT * FROM elections WHERE id = '$election_id'")or die(mysqli_error($db));
                    $execFetchingElectionName = mysqli_fetch_assoc($fetchingElectionName);
                    $election_name = $execFetchingElectionName['election_topic'];
                    
                    $candidate_photo = $row['candidate_photo'];
                    ?>
                <tr>
                    <td><?= $sno++; ?></td>
                    <td>

                        <img src="<?= $candidate_photo ?>" class="candidate_photo" alt="">
                    </td>
                    <td><?= $row['candidate_name']; ?></td>
                    <td><?= $row['candidate_details']; ?></td>
                    <td><?= $election_name; ?></td>

                    <td>
                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>


                </tr>
                <?php
                }
               }
               else{
                ?>
                <tr>
                    <td colspan="7">No Any Candidate Added Yet.</td>
                </tr>

                <?php
               }
               ?>
            </tbody>
        </table>
    </div>
</div>