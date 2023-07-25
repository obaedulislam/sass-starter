<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morning Reads</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/corefunctions.js"></script>
    <script type="text/javascript" src="../js/admin.js"></script>
</head>

<body class="login">
    <section class="login-panel">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 login-form-wrapper">
                <div class="semitransparent-bg">
                    <div class="login-form">
                        <h1>Admin Console</h1>
                        <div id="loginSuccess" class="success"></div>
                        <div id="loginError" class="error"></div>
                        <form id="login">
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="text" class="form-control" name="userid">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group text-right mt-5">
                                <input type="submit" value="Sign In" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>