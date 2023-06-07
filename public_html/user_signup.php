<?php

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

    <title>Application User Registration</title>

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
        <div class="row mt-5 gx-5 justify-content-center">
            <div class="col-md-4 col-10" style="background-color:whitesmoke;border-radius:5px;">
                <!-- <div class="col-xs-8 offset-xs-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4" style="background-color:whitesmoke;border-radius:5px;"> -->
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <img id="id4imglogo" src="./imgs/logos/logoSq.png" alt="applicaion's logo" width="175px">
                    </div>
                </div>
                <!-- <hr> -->
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        Sign-Up&nbsp;[<a href="./user_signin.php">Sign-In</a>]
                    </div>
                </div>
                <form action="ajaxroot.php" method="post" id="id4form_registration">
                    <div class="row mt-3">
                        <div class="col-md-10 offset-md-1 text-center ">
                            <div class="form-floating">
                                <input type="text" name="user_username" id="id4inputtext_username" class="form-control" placeholder="Username" tabindex="2">
                                <label for="id4inputtext_username">Username</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 text-center">
                            <span id="id4span_chkuser"></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-10 offset-md-1 text-center">
                            <div class="form-floating">
                                <input type="password" name="user_password1st" id="id4inputpassword_password1st" class="form-control" disabled placeholder="Password (1st)" tabindex="3">
                                <label for="id4inputpassword_password1st">Password (1st)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 text-center">
                            <span id="id4span_chkpassword"></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-10 offset-md-1 text-center">
                            <div class="form-floating">
                                <input type="password" name="user_password2nd" id="id4inputpassword_password2nd" class="form-control form-control-sm" disabled placeholder="Password (2nd)" tabindex="4">
                                <label for="id4inputpassword_password2nd">Password (2nd)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 text-center">
                            <span id="id4span_chkmatch"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <input type="hidden" name="user_application" value="<?= $user_application; ?>">
                            <input type="hidden" name="user_reference" value="<?= date('YmdHis'); ?>" />
                            <input type="hidden" name="process_name" value="user_signup" />
                            <button id="id4inputbutton_submit" type="submit" class="btn btn-sm btn-outline-success btn-round" disabled style="width: 75px;" tabindex="6">OK</button>
                            <button type="reset" class="btn btn-sm btn-outline-warning btn-round" style="width: 75px;" tabindex="5">Cancel</button>
                        </div>
                    </div>
                </form>

                <br>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src=" https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            // document.getElementById('id4imglogo').src = 'imglogo/logo-apks.svg';
            $('.js-example-basic-single').select2();
            console.log("i will sleep");
        });

        function matchchked_password() {
            let pass = document.getElementById('id4inputtext_password').value;
            let repass = document.getElementById('id4inputtext_repassword').value;
            console.log(pass);
            console.log(repass);
            if (pass !== repass) {
                alert('Nooooow');
            }
        }

        // input username check for English input text
        document.getElementById('id4inputtext_username').onkeyup = function(e) {
            e.preventDefault();
            if (this.value.match(/^[a-z0-9_.,'"!?;:& ]+$/i)) {
                if (this.value.length >= 6)
                    $("#id4span_chkuser").text("");
                else {
                    $("#id4span_chkuser").css("color", "red");
                    $("#id4span_chkuser").text("Username 6 char(s) or more");
                }
            } else {
                // $("#id4inputbutton_register").prop("disabled", true);
                $("#id4span_chkuser").css("color", "red");
                $("#id4span_chkuser").text("Wrong username");
            }
        }

        // input passwordfirst check for English input text
        document.getElementById('id4inputpassword_password1st').onkeyup = function(e) {
            e.preventDefault();
            if (this.value.match(/^[a-zA-Z0-9_.,'"!?;:&@]+$/i)) {
                if (this.value.length >= 6) {
                    $("#id4span_chkpassword").text("");
                    document.getElementById('id4inputpassword_password2nd').removeAttribute('disabled');
                } else {
                    document.getElementById('id4inputpassword_password2nd').setAttribute('disabled', 'disabled');
                    $("#id4span_chkpassword").css("color", "red");
                    $("#id4span_chkpassword").text("password 6 char(s) or more");
                }
            } else {
                document.getElementById('id4inputpassword_password2nd').setAttribute('disabled', 'disabled');
                // $("#id4inputbutton_register").prop("disabled", true);
                $("#id4span_chkpassword").css("color", "red");
                $("#id4span_chkpassword").text("Wrong password");
            }
        }

        // input passwordsecond check for match with passwordfirst
        document.getElementById('id4inputpassword_password2nd').onkeyup = function(e) {
            e.preventDefault();
            if (this.value != document.getElementById('id4inputpassword_password1st').value) {
                document.getElementById('id4inputbutton_submit').setAttribute('disabled', 'disabled');
                $("#id4span_chkmatch").css("color", "red");
                $("#id4span_chkmatch").text("password doesn't match");
            } else {
                document.getElementById('id4inputbutton_submit').removeAttribute('disabled');
                $("#id4span_chkmatch").text("");
            }
        }

        // input user check existing or not in selected application
        $("#id4inputtext_username").blur(function(e) {
            let name2chk = document.getElementById("id4inputtext_username").value;
            // let app2regis = document.getElementById("id4inputselect_application").value;
            let app2regis = '<?= $user_application; ?>';
            e.preventDefault();
            if (name2chk != '') {
                $.ajax({
                    type: 'post',
                    url: 'ajaxroot.php?process_name=user_checked_existing',
                    data: {
                        user_username: name2chk,
                        user_application: app2regis
                    },
                    success: function(response) {
                        console.log(typeof(response));
                        console.log(response);
                        if (response === '1') {
                            $("#id4inputbutton_register").prop("disabled", true);
                            $("#id4span_chkuser").css("color", "red");
                            $("#id4span_chkuser").text("user existing");
                        } else if (response === '0') {
                            $("#id4inputbutton_register").prop("disabled", false);
                            // $("#id4span_chkuser").css("color", "green");
                            // $("#id4span_chkuser").text("user available");
                            $("#id4span_chkuser").text("");

                            document.getElementById('id4inputpassword_password1st').removeAttribute('disabled');
                            // document.getElementById('id4inputpassword_passwordsecond').removeAttribute('disabled');
                        } else if (response === '2') {
                            $("#id4inputbutton_register").prop("disabled", true);
                            $("#id4span_chkuser").css("color", "red");
                            $("#id4span_chkuser").text("unknow error");
                        }
                    }
                })
            } else {
                $("#id4inputbutton_register").prop("disabled", true);
                $("#id4span_chkuser").css("color", "red");
                $("#id4span_chkuser").text("user cannot empty");
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const registrationForm = document.getElementById("id4form_registration");
            const usernameInput = document.getElementById("id4inputtext_username");
            const passwordFirstInput = document.getElementById("id4inputpassword_password1st");
            const passwordSecondInput = document.getElementById("id4inputpassword_password2nd");

            registrationForm.addEventListener("keydown", function(event) {
                if (event.key === "Tab") {
                    event.preventDefault();

                    if (document.activeElement === usernameInput) {
                        passwordFirstInput.focus();
                    } else if (document.activeElement === passwordFirstInput) {
                        passwordSecondInput.focus();
                    }
                }
            });
        });
    </script>

</body>

</html>