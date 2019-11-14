<?php
    function sendemail($email, $username, $body)
    {
        $hemail = htmlentities($email, ENT_QUOTES);
        $to = $hemail;
        $subject = 'Email Confirmation for Camagru Account';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To:' . $hemail;
        $headers[] = 'From: Camagru <noreply@camagru.co.za>';

        return (mail($to, $subject, $body, implode("\r\n", $headers)));
    }
?>