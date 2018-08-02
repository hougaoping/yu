<?php
function route2class() {
    $prefix = request()->is('admin/*') ? 'admin-panel ' : '';
    return $prefix . str_replace('.', '-', Route::currentRouteName());
}

function get_tree($categories, $level = 0) {
    $tree = array();
    foreach ($categories as $category) {
        array_push($tree, array(
            'id'    => $category->id,
            'name'  => $category->name,
            'item'  => $category,
            'level' => $level
        ));

        if ( count($category->children) ) {
            $tree = array_merge($tree, get_tree($category->children, $level+1));
        }
    }
    return $tree;
}

function permission($user, $active) {

    // return true;

    $permissions = is_object($user) ? $user->getAdminPermissions() : [];
    
    $configPermissions = config('admin.permissions');
    $equal = $configPermissions['equal'];

    foreach ($equal as $key => $actions) {
        if (in_array($active, $actions)) {
            $active = $key;
            break;
        }
    }

    $permissions = array_merge($configPermissions['public'], $permissions);
    if (!in_array($active, $permissions)) {
        return false;
    }
    return true;
}

// 隐藏电子邮件
function email_asterisk($email)
{
    $pos = strpos($email, '@');
    $prefix = substr($email, 0, $pos);
    $length = strlen($prefix);
    $hide = substr($prefix, 0 , floor(strlen($prefix)/2));
    $_len = $length - strlen($hide);
    if ($_len >= 2) {
        $suffix = floor($_len / 2);
        $asterisk = str_repeat('*',$_len-$suffix) .substr($prefix, -($suffix));
    } else {
        $asterisk = str_repeat('*',$_len);
    }
    return $hide . $asterisk . substr($email, $pos);
}

//发送电子邮件函数
function email($to, $subject, $body = '', $cc = [], $bcc = [])  {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);                                     // Passing `true` enables exceptions
    try {

        //Server settings
        $mail->SMTPDebug     = 2;                                                        // Enable verbose debug output
        $mail->isSMTP();                                                                 // Set mailer to use SMTP
        $mail->Host          = config('mail.host');                                      // Specify main and backup SMTP servers
        $mail->SMTPAuth      = true;                                                     // Enable SMTP authentication
        $mail->Username      = config('mail.username');                                  // SMTP username
        $mail->Password      = config('mail.password');                                  // SMTP password
        $mail->SMTPSecure    = config('mail.encryption');                                // Enable TLS encryption, `ssl` also accepted
        $mail->Port          = config('mail.port');                                      // TCP port to connect to

        //Recipients
		$mail->setFrom(config('mail.from.address'));
        $mail->addAddress($to);                                                         // Add a recipient
        //$mail->addAddress('ellen@example.com');                                       // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
		foreach($cc as $v){
			$mail->addCC($v);
		}

		foreach($bcc as $v){
			$mail->addBCC($v);
		}
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');                                 // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');                            // Optional name

        //Content
        $mail->isHTML(true);                                                            // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo 'Message has been sent';
    } catch (PHPMailer\PHPMailer\Exception $e) {
        // echo 'Message could not be sent.';
         echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
