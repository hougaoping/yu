<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>注册确认链接</title>
</head>
<p>感谢注册 {{ setting('name') }}</p>
<p>
请点击下面的链接完成注册：
{{ route('confirm.email', ['email' => $user->email, 'token' => $user->userEmail->activation_token]) }}
</p>
<p>如果这不是你的操作，请忽略邮件</p>
<body>
</body>
</html>
