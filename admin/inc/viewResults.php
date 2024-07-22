<?php

$election_id = $_GET['viewResult'];


?>


<div class="row my-3">
    <div class="col-12">
        <h3>Election Results</h3>

        <?php
        $fetchingActiveElections = mysqli_query($db,"SELECT * FROM elections WHERE id = '$election_id'")or die(mysqli_error($db));

        $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

        if($totalActiveElections > 0){
            while($data = mysqli_fetch_assoc($fetchingActiveElections)){
            
                $election_id = $data['id'];
                $election_topic = $data['election_topic'];
           
            ?>

        <table class="table">
            <thead>
                <tr>
                    <th class=" bg-green">
                        <h5>Election Name <?= strtoupper($election_topic);?></h5>
                    </th>
                </tr>
                <tr>
                    <th>Photo</th>
                    <th>Candidate Details</th>
                    <th># of Votes</th>

                </tr>
            </thead>
            <tbody>
                <?php
                    $fetchingCandidate = mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id = '$election_id'") or die(mysqli_error($db));

                    while($candidateData = mysqli_fetch_assoc($fetchingCandidate) ){
                        $candidate_id = $candidateData['id'];
                        $candidate_photo = $candidateData['candidate_photo'];

                        // Fetching Candidate Votes
                        $fetchingVotes = mysqli_query($db,"SELECT * FROM votings WHERE candidate_id = '$candidate_id'") or die(mysqli_error($db));

                        $totalVotes = mysqli_num_rows($fetchingVotes);

                        ?>
                <tr>
                    <td><img src="<?= $candidate_photo;?>" class="candidate_photo" alt=""></td>
                    <td><?= $candidateData['candidate_name']."<br>".$candidateData['candidate_details'] ?></td>
                    <td><?= $totalVotes;?></td>

                </tr>

                <?php
                    }
                ?>
            </tbody>
        </table>

        <?php
        }
    }
        else{
            echo "No any active elecion.";
        }
        ?>

        <hr>

        <h3>Voting Details</h3>


        <?php
            $fetchingVoteDetails = mysqli_query($db , "SELECT * FROM votings WHERE election_id = '$election_id'") or die(mysqli_error($db));

            $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

            if($number_of_votes > 0){
                $sno = 1;

                ?>


        <table class="table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Voter Name</th>
                    <th>Contact No</th>
                    <th>Voted To</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($data = mysqli_fetch_assoc($fetchingVoteDetails)){
                    
                    $voters_id = $data['voters_id'];
                    $candidate_id = $data['candidate_id'];

                    $fetchingUserName = mysqli_query($db , "SELECT * FROM users WHERE id = '$voters_id'") or die(mysqli_error($db));
                    $isDataAvailable = mysqli_num_rows($fetchingUserName);
                    $userData = mysqli_fetch_assoc($fetchingUserName);
                    if($isDataAvailable > 0){
                       
                        $username = $userData['username'];
                        $contact_no = $userData['contact_no'];
                        
                    }else{
                         $username = "No Data";
                        $contact_no = "No Data";

                    }

                   

                    $fetchingCandidateName = mysqli_query($db , "SELECT * FROM candidate_details WHERE id = '$candidate_id'") or die(mysqli_error($db));
                    $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                    $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                    if($isDataAvailable > 0){
                       
                        $candidate_name = $candidateData['candidate_name'];
                        
                        
                    }else{
                         $candidate_name = "No Data";
                        

                    }
                    
                    ?>

                <tr>
                    <td><?= $sno++;?></td>
                    <td><?= $username;?></td>
                    <td><?= $contact_no;?></td>
                    <td><?= $candidate_name;?></td>
                    <td><?= $data['vote_date'];?></td>
                    <td><?= $data['vote_time'];?></td>


                </tr>
                <?php
                }
            
            ?>
            </tbody>


        </table>
        <?php
            }else{
                echo "No any vote detail is avalaible!";
            }
            ?>




    </div>
</div>