<?php
    function sendemailnotif($email, $username, $body)
    {
        $hemail = $email;
        $to = $hemail;
        $subject = 'Activity On Your Posts';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To:' . $hemail;
        $headers[] = 'From: Camagru <noreply@camagru.co.za>';

        return (mail($to, $subject, $body, implode("\r\n", $headers)));
    }

    function sendemailfor($femail, $fusername, $fbody)
    {
        $email = htmlentities($femail, ENT_QUOTES);
        $to = $email;
        $subject = 'Reset Password';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To:' . $email;
        $headers[] = 'From: Camagru <noreply@camagru.co.za>';

        return (mail($to, $subject, $fbody, implode("\r\n", $headers)));
    }

    function sendemailcon($cemail, $cusername, $cbody)
    {
        $email = htmlentities($cemail, ENT_QUOTES);
        $to = $email;
        $subject = 'Email Confirmation for Camagru Account';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To:' . $email;
        $headers[] = 'From: Camagru <noreply@camagru.co.za>';

        return (mail($to, $subject, $cbody, implode("\r\n", $headers)));
    }  
?>