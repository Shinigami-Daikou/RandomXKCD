<?php
    $db_conn = mysqli_connect('localhost','root','','RandomXKCD') or die(mysqli_error($db_conn));

    $ID=$_GET['ID'];
    mysqli_select_db($db_conn, "RandomXKCD");

    $check_duplicate_query = "SELECT * FROM email_table WHERE ID = '$ID'";
    $result = mysqli_query($db_conn, $check_duplicate_query);
    $check_duplicate = @mysqli_num_rows($result);
    if($check_duplicate != 0){
        $msg = "<div style='padding-top: 25%;'>Email has already been verified.</div>";
    }
    else{
        $check_entry_query = "SELECT Email FROM temp_table WHERE ID = '$ID'";
        $result = mysqli_query($db_conn, $check_entry_query);
        $check_entry = @mysqli_num_rows($result);
        if($check_entry == 0){
            $msg = "<div style='padding-top: 7%;'>You haven't registered your email yet. <br> Please register the email first. <br><a href='index.php'>Register</a></div>";
        }
        else{
            $list = mysqli_fetch_assoc($result);
            $email = $list['Email'];
            $insert_query = "INSERT INTO email_table(ID, email) VALUES('$ID', '$email');";
            mysqli_query($db_conn, $insert_query) or die(mysqli_error($db_conn));

            $msg = "<div style='padding-top: 10%;'>Your email has been verified, you'll receive a Random XKCD image every 5-minutes from now.</div>";
        }
    }
    

    $remove_query = "DELETE FROM temp_table WHERE ID = '$ID'";
    mysqli_query($db_conn, $remove_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <title>Verify</title>
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
<body style="background-color: #17202a;">
        <div class="container" style="height: 90%; width: 90%;">
            <div class="row" style="height: 100%; margin-right: -4vw;">
                <div class="col-sm-6 column column1">
                    <div style="color: rgb(245, 234, 173); font-size: 3vw; padding-right: 10%; height: 100%;">
                        <?php 
                            if(isset($msg)){
                                echo $msg;
                            }
                        ?>
                    </div>
                </div>
                <div class="col-sm-6 column2 column">
                    <p style="font-size: 5vw; padding-top: 14%;">
                        Random XKCD
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>