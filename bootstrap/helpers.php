<?php
function route2class() {
    $prefix = request()->is('admin/*') ? 'admin-panel ' : '';
    return $prefix . str_replace('.', '-', Route::currentRouteName());
}

function description($content, $length = 200) {
    $description = str_replace("&nbsp;", "", $content);
    $description = trimmed_title(strip_tags($description), $length, true);
    $description = preg_replace('/\s\s+/', '', $description);
    return $description;
}

//截取字数
function trimmed_title($text, $limit=12, $omit = true) {
    if ($limit) {
        $val = csubstr($text, 0, $limit);
        return $val[1] ? $val[0] . ($omit==true ? "..." : "") : $val[0];
    } else {
        return $text;
    }
}

function csubstr($text, $start=0, $limit=12) {
    if (function_exists('mb_substr')) {
        $more = (mb_strlen($text, 'UTF-8') > $limit) ? TRUE : FALSE;
        $text = mb_substr($text, 0, $limit, 'UTF-8');
        return array($text, $more);
    } elseif (function_exists('iconv_substr')) {
        $more = (iconv_strlen($text) > $limit) ? TRUE : FALSE;
        $text = iconv_substr($text, 0, $limit, 'UTF-8');
        return array($text, $more);
    } else {
        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);
        if(func_num_args() >= 3) {
            if (count($ar[0])>$limit) {
                $more = TRUE;
                $text = join("",array_slice($ar[0],0,$limit))."...";
            } else {
                $more = FALSE;
                $text = join("",array_slice($ar[0],0,$limit));
            }
        } else {
            $more = FALSE;
            $text =  join("",array_slice($ar[0],0));
        }
        if ($returnArray) {
            
        }
        return array($text, $more);
    }
}

// 排列组合
// $arr = array(
//    array('A', 'B'),
//    array('C', 'D'),
//    array('1', '2', '3'),
// );
// $rs = get_combination($arr);
// printr($rs);
function get_combination($arr) {
    $combArrays = array(array());
    foreach ($arr as $arrValues) {
        $newArrayValues = array();
        foreach ($combArrays as $comArray) {
            foreach ($arrValues as $value) {
                $new = $comArray;
                $new[] = $value;
                $newArrayValues[] = $new;
            }
        }
        $combArrays = $newArrayValues;
    }
    return $combArrays;
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
