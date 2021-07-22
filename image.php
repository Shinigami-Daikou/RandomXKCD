<?php
    $db_conn = mysqli_connect('localhost','root','','RandomXKCD') or die(mysqli_error($db_conn));
    mysqli_select_db($db_conn, "RandomXKCD");
    $get_email_query = "SELECT * FROM email_table";
    $result = mysqli_query($db_conn, $get_email_query);
    $n = @mysqli_num_rows($result);

    while($email = mysqli_fetch_assoc($result)){
        $url = "https://c.xkcd.com/random/comic/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        $url = $url.'info.0.json';

        $data = file_get_contents($url);
        $decoded_data = json_decode($data);
        $image_url = $decoded_data->img;
        $alt = $decoded_data->alt;

        $ID = $email['ID'];

        $to = $email['Email'];
        $subject = "Random XKCD Comic";
        $header = "Content-Type: text/html; charset=utf-8\n";
        $message = '
        <html>
        <body>
        <img src=\''.$image_url.'\' alt=\''.$alt.'\'/>
        <p>To unsubscribe, <a href=\'https://localhost/RandomXKCD/unsubscribe.php?ID='.$ID.'\'>click here</a></p>
        </body>
        </html>
        ';

        mail($to, $subject, $message, $header);
    } 
?>