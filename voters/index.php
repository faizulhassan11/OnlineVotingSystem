<?php
require_once("inc/header.php");
require_once("inc/navigation.php");


?>

<div class="row my-3">
    <div class="col-12">
        <h3>Voters Panel</h3>

        <?php
        $fetchingActiveElections = mysqli_query($db,"SELECT * FROM elections WHERE status = 'Active'")or die(mysqli_error($db));

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
                    <th>Action</th>
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
                    <td>
                        <?php
                        $checkIfVoteCasted =mysqli_query($db,"SELECT * FROM votings WHERE voters_id = '".$_SESSION['user_id']."' AND election_id =  ' $election_id'") or die(mysqli_error($db));

                        $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                       if($isVoteCasted > 0){
                        $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                        $voteCastedToCandidate = $voteCastedData['candidate_id'];

                        if($voteCastedToCandidate == $candidate_id){

                        
                            ?>
                        <img src="../assets/images/vote.jpg" width="100px" alt="">
                        <?php  
                        }  
                       }
                       else{

                       ?>
                        <button class="btn bg-green btn-md"
                            onclick="castVote(<?= $election_id;?>,<?= $candidate_id;?>,<?= $_SESSION['user_id'];?>);">Vote</button>

                        <?php
                       }
                       ?>
                    </td>
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


    </div>
</div>

<script>
const castVote = (election_id, candidate_id, voter_id) => {
    $.ajax({
        type: "POST",
        url: "inc/ajaxCalls.php",
        data: "e_id=" + election_id + "&c_id=" + candidate_id + "&v_id=" + voter_id,
        success: function(response) {
            if (response == "success") {
                location.assign("index.php?voteCasted=1");
            } else {
                location.assign("index.php?voteCasted=1");

            }
        }
    })
};
</script>

<?php


require_once("inc/footer.php");


?>