<div class="row my-3">

    <div class="col-12">
        <h3>Election</h3>
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
                ?>
                <tr>
                    <td><?= $sno++; ?></td>
                    <td><?= $row['election_topic']; ?></td>
                    <td><?= $row['no_of_candidate']; ?></td>
                    <td><?= $row['starting_date']; ?></td>
                    <td><?= $row['ending_date']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td>
                        <a href="index.php?viewResult=<?= $election_id;?>" class="btn bg-green btn-sm">View Results</a>

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