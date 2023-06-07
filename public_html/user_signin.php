<?php
session_start();

// if already signed-in redirect to assigned page...
if (isset($_SESSION['userlogin_tok'])) {
    echo '<script>window.location.href=\'index.php\'</script>';
    die();
}

// Initialized parameter
date_default_timezone_set('Asia/Bangkok');
$user_application = '20230513191528';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Application User Login</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@200&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Prompt', sans-serif;
        }

        #grad1 {
            height: 200px;
            background-image: linear-gradient(to right, rgba(50, 10, 10, 1), rgba(10, 50, 10, 1));
        }

        label {
            color: grey !important;
            font-size: 0.8rem;
        }

        .form-control {
            color: grey !important;
        }

        .form-floating label,
        .form-floating input[type="text"],
        .form-floating input[type="password"] {
            padding: 0.4rem 0.75rem;
            /* Set top and bottom padding to 0.5rem and left and right padding to 0.75rem */
            height: 2.5rem;
            /* Set the height to 2rem */
        }
    </style>
</head>

<body id="grad1">

    <div class="container">
        <div class="row mt-5">
            <div class="col-xs-8 offset-xs-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4" style="background-color:whitesmoke;border-radius:5px;">
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <!-- <img id="id4imglogo" src="" alt="applicaion's logo" width="175px"> -->
                        <img id="id4imglogo" src="./imgs/logos/logoSq.png" alt="applicaion's logo" width="175px">
                    </div>
                </div>
                <!-- <hr> -->
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        Sign-In&nbsp;[<a href="./user_signup.php">Sign-Up</a>]
                    </div>
                </div>
                <form action="ajaxroot.php" method="post">
                    <!-- <div class="row mt-3">
                        <div class="col-md-10 offset-md-1 text-center">
                            <select name="application" id="id4inputselect_application" class="form-control js-example-basic-single">
                                <option value="">Select Application</option>
                                <?php
                                $sqlcmd_list_apps = "SELECT * FROM tbl_apps WHERE app_enabled=1 ORDER BY app_dateadd ASC";
                                $sqlres_list_apps = mysqli_query($db_conn, $sqlcmd_list_apps);
                                if ($sqlres_list_apps) :
                                    while ($sqlfet_list_apps = mysqli_fetch_assoc($sqlres_list_apps)) :
                                ?>
                                        <option value="<?= $sqlfet_list_apps['app_reference']; ?>"><?= $sqlfet_list_apps['app_name']; ?></option>
                                <?php
                                    endwhile;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div> -->
                    <div class="row mt-3">
                        <div class="col-md-10 offset-md-1 text-center ">
                            <div class="form-floating">
                                <input type="text" name="user_username" id="id4inputtext_username" class="form-control" placeholder="Username" />
                                <label for="id4inputtext_username">Username</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-10 offset-md-1 text-center">
                            <div class="form-floating">
                                <input type="password" name="user_password" id="id4inputpassword_password" class="form-control" placeholder="Password">
                                <label for="id4inputpassword_password">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-10 offset-md-1">
                            <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="" id="id4checkbox_rememberme">
                                <label class="form-check-label stretched-link" for="id4checkbox_rememberme">Remember
                                    me</label>
                            </li>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <input type="hidden" name="user_application" value="<?= $user_application; ?>">
                            <input type="hidden" name="process_name" value="user_signin" />
                            <!-- <button id="id4inputbutton_submit" type="submit" class="btn btn-sm btn-outline-success btn-round" style="width: 75px;" onclick="lsRememberMe()" disabled>OK</button> -->
                            <button id="id4inputbutton_submit" type="submit" class="btn btn-sm btn-outline-success btn-round" style="width: 75px;">OK</button>
                            <button type="reset" class="btn btn-sm btn-outline-warning btn-round" style="width: 75px;">Cancel</button>
                        </div>
                    </div>
                </form>

                <br>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            console.log("i will survive");

            // document.getElementById('id4imglogo').src = 'imglogo/logo-apks.svg';

            $('.js-example-basic-single').select2();
        });

        // Select change listener
        // document.getElementById('id4inputselect_application').onchange = function() {
        //     let imglogo = document.getElementById('id4imglogo');
        //     if (this.value != '') {
        //         document.getElementById('id4inputtext_username').removeAttribute('disabled');
        //         document.getElementById('id4inputpassword_password').removeAttribute('disabled');
        //         document.getElementById('id4inputbutton_submit').removeAttribute('disabled');
        //         // console.log(this.value);
        //         imglogo.src = 'imglogo/' + this.value + '.svg';
        //     } else {
        //         document.getElementById('id4inputtext_username').setAttribute('disabled', 'disabled');
        //         document.getElementById('id4inputpassword_password').setAttribute('disabled', 'disabled');
        //         document.getElementById('id4inputbutton_submit').setAttribute('disabled', 'disabled');
        //     }
        // }

        // Get the checkbox element and the username and password inputs
        const rememberMeCheckbox = document.getElementById("id4checkbox_rememberme");
        const usernameInput = document.getElementById("id4inputtext_username");
        const passwordInput = document.getElementById("id4inputpassword_password");
        const applicationInput = document.getElementById("id4inputselect_application");

        // If the user has previously checked the checkbox, set the checkbox to be checked and fill in the username and password inputs
        if (localStorage.getItem("rememberMe") === "true") {
            rememberMeCheckbox.checked = true;
            usernameInput.value = localStorage.getItem("username");
            passwordInput.value = localStorage.getItem("password");
            applicationInput.value = localStorage.getItem("application");

            document.getElementById('id4imglogo').src = 'imglogo/' + localStorage.getItem("application") + '.svg';
        }

        // Listen for changes to the checkbox
        rememberMeCheckbox.addEventListener("change", function() {
            if (this.checked) {
                // If the checkbox is checked, store the username and password in local storage
                localStorage.setItem("rememberMe", "true");
                localStorage.setItem("username", usernameInput.value);
                localStorage.setItem("password", passwordInput.value);
                localStorage.setItem("application", applicationInput.value);
            } else {
                // If the checkbox is unchecked, remove the username and password from local storage
                localStorage.removeItem("rememberMe");
                localStorage.removeItem("username");
                localStorage.removeItem("password");
            }
        });
    </script>

</body>

</html>