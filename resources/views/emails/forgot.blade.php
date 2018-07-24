<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>找回密码</title>
</head>
<p>您的帐号 {{ $passwordReset->email }}</p>
<p>
请点击下面的链接重置密码：
{{ route('forgot.reset', ['email'=>$passwordReset->email, 'token'=>$passwordReset->token]) }}
</p>
<p>如果这不是您本人的操作，请忽略此邮件。</p>
<body>
</body>
</html>
