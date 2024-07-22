<?php

    require_once('./admin/inc/config.php');

    $fetchingElections = mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));

    while($data = mysqli_fetch_assoc($fetchingElections)){

        $starting_date = $data['starting_date'];
        $ending_date = $data['ending_date'];
        $curr_date = date("Y-m-d");
        $election_id = $data['id'];
        $status = $data['status'];

        if($status == "Active" ){
        
        $date1 = date_create($curr_date);
        $date2 = date_create($ending_date);
        $diff = date_diff($date1, $date2);
      
        

        if((int)$diff->format("%R%a") < 0){
        //    update;
        echo "expired";
        mysqli_query($db,"UPDATE elections SET status = 'Expired' WHERE id = '$election_id'") or die(mysqli_error($db));

        }
    }
        else if($status == "InActive"){
        $date1 = date_create($curr_date);
        $date2 = date_create($starting_date);
        $diff = date_diff($date1, $date2);
      
        

        if((int)$diff->format("%R%a") <= 0){
            
            // update
    
         
        mysqli_query($db,"UPDATE elections SET status = 'Active' WHERE id = '$election_id'") or die(mysqli_error($db));

        

        }

        }
        

        
    }



?>


<!DOCTYPE html>
<html>

<head>
    <title>Login - Online Voting System</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
        integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="./assets/images/logo.gif" class="brand_logo" alt="Logo">
                    </div>
                </div>

                <?php

                if(isset($_GET['sign-up'])){

                ?>

                <div class="d-flex justify-content-center form_container">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text p-3"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="su_username" class="form-control input_user" placeholder="username"
                                required />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text p-3"><i class="fa-solid fa-address-book"></i></span>
                            </div>
                            <input type="text" name="su_contact_no" class="form-control input_contact"
                                placeholder="Contact #" required />
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text p-3"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="su_password" class="form-control input_pass"
                                placeholder="password" required />
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text p-3"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="su_retype_password" class="form-control input_pass"
                                placeholder="Retype password" required />
                        </div>

                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="sign_up_btn" class="btn login_btn">Sign Up</button>
                        </div>
                    </form>
                </div>



                <div class="mt-4">
                    <div class="d-flex justify-content-center links text-white">
                        Already Have An Account? <a href="index.php" class="ml-2 text-white">Sign In</a>
                    </div>

                </div>

                <?php
                }else{

                    ?>


                <div class="d-flex justify-content-center form_container">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text p-3 "><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="contact_no" class="form-control input_user"
                                placeholder="Contact No" required />
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text p-3"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control input_pass"
                                placeholder="password" required />
                        </div>
                        <!-- <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customControlInline">
                                <label class="custom-control-label text-white" for="customControlInline">Remember
                                    me</label>
                            </div>
                        </div> -->
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="loginBtn" class="btn login_btn">Login</button>
                        </div>
                        <div class="d-flex justify-content-center links">
                            <a href="#" class="text-white">Forgot your password?</a>
                        </div>
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links text-white">
                        Don't have an account? <a href="?sign-up=1" class="ml-2 text-white">Sign Up</a>
                    </div>

                </div>


                <?php
                }


            ?>

                <?php
                if(isset($_GET['registered'])){

             
            ?>
                <span class="bg-white text-success text-center my-3">Your Account Has Been Created Successfully!</span>

                <?php
                }else if(isset($_GET['invalid'])){
                    ?>
                <span class="bg-white text-danger text-center my-3">Password Mismatch Try Again!</span>
                <?php
                }else if(isset($_GET['not_registered'])){
                    ?>
                <span class="bg-white text-warning text-center my-3">Sorry You are not Registered!</span>
                <?php
                }
                else if(isset($_GET['invalid_access'])){
                    ?>
                <span class="bg-white text-danger text-center my-3">Invalid Username or Password!</span>
                <?php
                }
            ?>




            </div>
        </div>
    </div>
</body>

<script src="./js/assets/bootstrap.min.js"></script>
<script src="./js/assets/jquery.min.js"></script>

</html>


<?php
require_once('./admin/inc/config.php');

if(isset($_POST['sign_up_btn'])){
    $su_username = mysqli_real_escape_string($db,$_POST['su_username']);
    $su_contact_no = mysqli_real_escape_string($db,$_POST['su_contact_no']);
    $su_password = mysqli_real_escape_string($db,sha1($_POST['su_password']));
    $su_retype_password = mysqli_real_escape_string($db,sha1($_POST['su_retype_password']));
    $user = "voter";

   
    if($su_password == $su_retype_password){
        // Insert Query
     
        mysqli_query($db, "INSERT INTO users(username, contact_no, password, user_role) VALUES('$su_username', '$su_contact_no', '$su_password', '$user')") or die(mysqli_error($db));
       header('location:index.php?&registered=1');

    } else {
       header('location:index.php?sign-up=1&invalid=1');
    }
}
else if(isset($_POST['loginBtn'])){
    $contact_no = mysqli_real_escape_string($db,$_POST['contact_no']);
    $password = mysqli_real_escape_string($db,sha1($_POST['password']));

    // Query Fetch  / Select

    $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE contact_no = '".$contact_no."' AND password = '".$password."'") or die(mysqli_error($db));

    if(mysqli_num_rows($fetchingData)>0){
        $data = mysqli_fetch_assoc($fetchingData);

        print_r($data);

        if($contact_no == $data['contact_no'] AND $password == $data['password']){
            
            session_start();
            $_SESSION['user_role'] = $data['user_role'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['user_id'] = $data['id'];
          



            if($data['user_role'] == 'admin'){
            $_SESSION['key'] = 'AdminKey';

            header('location:admin/index.php?homepage=1');

            }else{
            $_SESSION['key'] = 'VotersKey';

            header('location:voters/index.php');

            }

        }else{
            header('location:index.php?&invalid_access=1');

        }
    }else{
        header('location:index.php?sign-up=1&not_registered=1');

    }


}
?>