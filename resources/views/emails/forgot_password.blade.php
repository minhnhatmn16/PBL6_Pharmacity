<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<head>
    <title>Đặt lại mật khẩu</title>
</head>

<body>
    <div style="
    background-color: rgb(240, 255, 240);
    justify-content: center;
    border: 2px solid silver;
    margin-bottom: 3px;
    padding: 10px;
    text-align: center;
    ">
        <p style="font-style: italic;margin: 0;margin-bottom: 10px;">Xin chào! Bạn có một thông báo từ hệ thống Pharmacity!</p>
        <p style="margin: 0;margin-bottom: 5px;">{{ now() }}</p>
    </div>

    <div style="background-color: #007eff1c;padding: 20px;border: 2px dashed #007bff;">
        <p>
            <h4>Đây là đường dẫn để bạn reset password. Vui lòng click vào đường dẫn.</h4>
            <h4><a style="color: rgb(0, 123, 255);text-decoration: underline" href="{{ $url }}">{{ $url }}</a></h4>
        </p>
    </div>

    <div style="
    background-color: rgb(240, 255, 240);
    justify-content: center;
    border: 2px solid silver;
    margin-top: 3px;
    padding: 20px;
    text-align: center;
    ">
</div>
</body>

</html>
