<?php
    $db_conn = mysqli_connect('localhost','root','','RandomXKCD') or die(mysqli_error($db_conn));

    $ID=$_GET['ID'];
    mysqli_select_db($db_conn, "RandomXKCD");
    $remove_query = "DELETE FROM email_table WHERE ID = '$ID'";
    mysqli_query($db_conn, $remove_query);
    $msg = "<div style='padding-top: 25%;'>You have successfully unsubscribed.</div>";
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
    <title>unsubscribe</title>
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