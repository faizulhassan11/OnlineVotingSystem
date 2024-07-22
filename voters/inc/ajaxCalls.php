<?php

require_once('../../admin/inc/config.php');


if(isset($_POST['e_id']) AND isset($_POST['c_id']) AND isset($_POST['v_id'])){
    
    $election_id = $_POST['e_id'];
    $voter_id = $_POST['v_id'];
    $candidate_id = $_POST['c_id'];
    $vote_date = date("Y-m-d");
    $vote_time = date("h:i:s a");
    
    mysqli_query($db,"INSERT INTO votings (election_id, voters_id, candidate_id, vote_date, vote_time) VALUES ('$election_id','$voter_id','$candidate_id','$vote_date','$vote_time')") or die(mysqli_error($db));

    echo "success";
}else{
    echo "Not working";
}
?>