<?php
session_start();
if (isset($_SESSION["user"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Morning Reads</title>
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/tinymce/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="../js/admin.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#publishingDate").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
            });
        </script>
    </head>

    <body class="admin">
        <?php
            include "sidebar.php";
            include "controllers/randomstring.php";
            function clean($string) {
                return stripslashes($string);
            }
             
            $randomString;
            if (!isset($_SESSION["folder"])) {
                $randomString = generateRandomString();
                $_SESSION["folder"] = $randomString;
            }
        ?>
        <section class="admin-section">
            <div class="container-fluid">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="tile">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h1 class="section-title">News Section</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <ul class="tabs">
                                    <li class="active"><a href="#newsTab">Add News</a></li>
                                    <li><a href="#newsListTab">News List</a></li>
                                </ul>
                                <ul class="tab-windows">
                                    <li id="newsTab" class="tab-window show">
                                    </li>
                                    <li id="newsListTab" class="tab-window">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

    </html>

<?php
} else {
    header("location:index.php");
}
?>