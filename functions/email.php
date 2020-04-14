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
        $hemail = htmlentities($femail, ENT_QUOTES);
        $to = $hemail;
        $subject = 'Reset Password';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To:' . $hemail;
        $headers[] = 'From: Camagru <noreply@camagru.co.za>';

        return (mail($to, $subject, $fbody, implode("\r\n", $headers)));
    }

    function sendemailcon($cemail, $cusername, $cbody)
    {
        $hemail = htmlentities($cemail, ENT_QUOTES);
        $to = $hemail;
        $subject = 'Email Confirmation for Camagru Account';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To:' . $hemail;
        $headers[] = 'From: Camagru <noreply@camagru.co.za>';

        return (mail($to, $subject, $body, implode("\r\n", $headers)));
    }  
?>