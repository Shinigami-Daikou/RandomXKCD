<?php
    //Creates database if it's not already created
    $db_conn= mysqli_connect('localhost','root','') or die(mysqli_error($db_conn_conn));

    if(!@mysqli_connect('localhost','root','','RandomXKCD')){
        $db_create="CREATE Database RandomXKCD";
        if(mysqli_query($db_conn,$db_create)){
            $db_conn = mysqli_connect('localhost','root','','RandomXKCD') or die(mysqli_error($db_conn));

            $emailtable_create = "CREATE Table email_table(
                ID VARCHAR(250) NOT NULL PRIMARY KEY,
                Email VARCHAR(250) NOT NULL
            )";
            mysqli_query($db_conn,$emailtable_create) or die(mysqli_error($db_conn));

            $temptable_create = "CREATE Table temp_table(
                ID VARCHAR(250) NOT NULL PRIMARY KEY,
                Email VARCHAR(250) NOT NULL
            )";
            mysqli_query($db_conn,$temptable_create) or die(mysqli_error($db_conn));
        }
        else{
            die("Error creating database: " . mysqli_error($db_conn));
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RandomXKCD</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet"> 
        <style>
            html,body {
                height: 100%; 
            }
            .column{
                height: 90%;
                background-color:  #5d6d7e;
                font-family: Raleway, sans-serif;
                position: relative;
                margin-top: 10vh;
                opacity: 0.8;
            }
            .column1{
                color: white;
                padding-left: 5vw;
                padding-top: 5%;
                font-size: 2.2vw;
                border-bottom-left-radius: 3%; 
                border-top-left-radius: 3%;
            }
            .column2{
                margin-left: -4vw;
                padding-left: 8vw;
                padding-top: 20vh;
                font-size: 2.5vw;
                background-color:  white;  
                border-bottom-right-radius: 3%; 
                border-top-right-radius: 3%;    
            }
        </style>
    </head>
    
    <?php
        $msg = NULL;
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email =mysqli_escape_string($db_conn, $_POST['email']);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $msg = "The email entered is invalid, please try again.";
            }
            else{
                mysqli_select_db($db_conn, "RandomXKCD");
                $check_duplicate_query = "SELECT * FROM temp_table WHERE Email = '$email'";
                $result = mysqli_query($db_conn, $check_duplicate_query);
                $check_duplicate = @mysqli_num_rows($result);
                if($check_duplicate != 0){
                    $msg = "Email already exists.";
                }
                else{
                    $ID = md5($email);

                    //Email verification via mail
                    $to = $email;
                    $subject = "Verification for RandomXKCD";
                    $message = '
                    Your account has been created.
                    Youll start receiving a Random XKCD comic after activation of your email by clicking on the link below.
                    *************************************************
                    Email: '.$email.'
                    *************************************************
                    
                    Please click this link to activate your account:
                    https://localhost/RandomXKCD/verify.php?ID='.$ID
                    ;

                    if(!(mail($to, $subject, $message))){
                        $msg = "Verification mail not sent. Sorry";
                    }
                    else{
                        $insert_query = "INSERT INTO temp_table(ID, email) VALUES('$ID', '$email');";
                        mysqli_query($db_conn, $insert_query) or die(mysqli_error($db_conn));
                        $msg = "Please verify your account by clicking the activation link that has been send to your email.";
                    }
                }
            }
        }


    ?>
    <body style="background-color: #17202a;">
        <div class="container" style="height: 90%; width: 90%;">
            <div class="row" style="height: 100%; margin-right: -4vw;">
                <div class="col-sm-6 column column1">
                    <p style="color:  #a9cce3; font-size: 3vw; margin-left: -2vw;">&lt;/info&gt;</p>
                    <u style="font-size: 2.8vw;">Random XKCD</u><br>
                    Enter the email and a random XKCD comic will be send to you every 5 minutes..
                    <form action=" " method="POST" style="margin-top: 8%;">
                        <label for="email">Email:</label>
                        <br>
                        <input type="text" name="email" style="font-size: 1.7vw; width: 70%; color: black;"/>
                        <input type="submit" value="Submit"  style="font-size: 1.7vw; color: black; background-color:rgb(137, 224, 250)"/>
                        <div style="font-size: 1.5vw; padding-right: 10%;">
                            <?php 
                                if(isset($msg)){
                                    echo $msg;
                                }
                            ?>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6 column2 column">
                    Hi, I'm <br>
                    <p style="font-size: 3.2vw;">
                        <b>B</b>hupendra <b>C</b>hauhan
                    </p>
                    - Web Developer<br>
                    - GCP Aspirant<br>
                </div>
            </div>
        </div>
    </body>
</html>