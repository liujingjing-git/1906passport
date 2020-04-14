<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>-hi 欢迎注册-</title>
</head>
<body>
        <center>
        <h3>欢迎注册</h3>
        <form action="{{url('regdo')}}"  method="post">
        @csrf
            <table border="2">
                <tr>
                    <td>用户名:</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>邮箱:</td>
                    <td><input type="text" name="email"></td>
                </tr>
                <tr>
                    <td>手机号码:</td>
                    <td><input type="text" name="mobile"></td>
                </tr>
                <tr>
                    <td>密码:</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td>→</td>
                    <td><input type="submit" value="Registered"></td>
                </tr>
            </table>
        </form>
        </center>
</body>
</html>