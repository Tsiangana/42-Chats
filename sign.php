<?php
include 'config.php';
session_start();
$message = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = 'Aboth password are not the same';
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $message = 'This Email already exist';
        } else {
            $photo = $_FILES['photo']['name'];
            $photo_tmp = $_FILES['photo']['tmp_name'];
            $photo_path = "photos/" . $photo;
            move_uploaded_file($photo_tmp, $photo_path);

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (nome, email, senha, foto) VALUES ('$name', '$email', '$hashed_password', '$photo_path')";
            if (mysqli_query($conn, $query)) {
                $message = 'Sucesss!';
                // Redirecionar para a página de login
                header("Location: index.php");
                exit();
            } else {
                $message = 'Sign up Error';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - Creating acount</title>
    <link rel="shortcut icon" href="img/logo/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Tilt+Neon&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/sign.css">
</head>
<body>

    <div class="container">
        <div class="content">
                  <?php if (!empty($message)): ?>
                    <div id="modal-container" onclick="hideModal()"><p id="modal"><?php echo $message; ?></p></div>
                  <?php endif; ?>
            <div class="img"><img src="img/sign/Social media-cuate.png" alt=""></div>
            <button class="circleBtn" onclick="generate();redirectToPage();">Cancelar</button>
            <div class="text" id="minhaDiv">
                <div class="text0" id="conteudo0">
                    <h1>Wellcome to VEchat</h1>
                    <h3>
                        Create your account and be connected to all your friends on VEchat
                    </h3>
                    <h1><img src="img/sign/oie_1017555hyF5pOVA.gif" alt=""></h1>
                    <button class="circleBtn" onclick="cancel();generate(); "><a>Cancelar</a></button>
                </div>
                <div class="text1" id="conteudo">
                    <h1>VEchat - Create acount</h1>
                    <h3>
                        Welcome to VEchat, an online 
                        platform where you can make video 
                        calls with your friends in a very 
                        simple and fast way.
                    </h3>
                    <p>
                        VEchat aims to allow connection between people 
                        in a real and meaningful way, if you use it you 
                        will be accepting all the terms and conditions 
                        that the platform has. In case you want to know 
                        more before continuing, we insist that you read
                         more about the terms and conditions.
                    </p>
                    <label class="container1">
                        <input type="checkbox" checked="checked" onclick="generate();">
                        <div class="checkmark"></div>
                    </label>
                    <p><a href="informacoes.html">Terms and conditions</a></p>
                    <button class="cta" onclick="generate();change();"><span>Next </span><svg viewBox="0 0 13 10" height="10px" width="15px"><path d="M1,5 L11,5"></path><polyline points="8 1 12 5 8 9"></polyline></svg>
                    </button>
                </div>
            </div>
            <div class="text2"  id="conteudo1">
                <div class="form-container" tabindex="0">
                    <div class="form-container__block">
                      <div class="form-container__header">
                        <h1>Welcome!</h1>
                        <p>Create your account</p>
                        <form class="form-container__form" action="" method="post" enctype="multipart/form-data">
                          <input placeholder="Your Name" type="text" name="name" id="name" required>
                          <input placeholder="Email address" type="email" name="email" id="email" required>
                          <input placeholder="Password" type="password" name="password" id="password" required>
                          <input placeholder="Confirm password" type="password" name="confirm_password" id="confirm_password">
                          <input placeholder="Photo" type="file"  name="photo" id="photo">
                          <div class="form-container__register-buttons">
                            <button class="form-container__sign" type="submit" name="submit" value="Cadastrar">Sign In</button>
                          </div>
                        </form>
                      </div>
                      <div class="form-container__footer">
                        <!--<p class="top-line">Or sign in with:</p>-->
                        <div class="form-container__sign-app-buttons">
                          <button class="google"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 512 512" y="0" x="0" height="512" width="512" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                              <g>
                                <path data-original="#167ee6" fill="#167ee6" d="m492.668 211.489-208.84-.01c-9.222 0-16.697 7.474-16.697 16.696v66.715c0 9.22 7.475 16.696 16.696 16.696h117.606c-12.878 33.421-36.914 61.41-67.58 79.194L384 477.589c80.442-46.523 128-128.152 128-219.53 0-13.011-.959-22.312-2.877-32.785-1.458-7.957-8.366-13.785-16.455-13.785z"></path>
                                <path data-original="#12b347" fill="#12b347" d="M256 411.826c-57.554 0-107.798-31.446-134.783-77.979l-86.806 50.034C78.586 460.443 161.34 512 256 512c46.437 0 90.254-12.503 128-34.292v-.119l-50.147-86.81c-22.938 13.304-49.482 21.047-77.853 21.047z"></path>
                                <path data-original="#0f993e" fill="#0f993e" d="M384 477.708v-.119l-50.147-86.81c-22.938 13.303-49.48 21.047-77.853 21.047V512c46.437 0 90.256-12.503 128-34.292z"></path>
                                <path class="" data-original="#ffd500" fill="#ffd500" d="M100.174 256c0-28.369 7.742-54.91 21.043-77.847l-86.806-50.034C12.502 165.746 0 209.444 0 256s12.502 90.254 34.411 127.881l86.806-50.034c-13.301-22.937-21.043-49.478-21.043-77.847z"></path>
                                <path class="" data-original="#ff4b26" fill="#ff4b26" d="M256 100.174c37.531 0 72.005 13.336 98.932 35.519 6.643 5.472 16.298 5.077 22.383-1.008l47.27-47.27c6.904-6.904 6.412-18.205-.963-24.603C378.507 23.673 319.807 0 256 0 161.34 0 78.586 51.557 34.411 128.119l86.806 50.034c26.985-46.533 77.229-77.979 134.783-77.979z"></path>
                                <path data-original="#d93f21" fill="#d93f21" d="M354.932 135.693c6.643 5.472 16.299 5.077 22.383-1.008l47.27-47.27c6.903-6.904 6.411-18.205-.963-24.603C378.507 23.672 319.807 0 256 0v100.174c37.53 0 72.005 13.336 98.932 35.519z"></path>
                              </g>
                            </svg><span>Google</span></button>
                          <button onclick="generate();"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 24 24" y="0" x="0" height="512" width="512" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                              <g>
                                <path class="" data-original="#000000" fill="#000000" d="M12 .5C5.37.5 0 5.78 0 12.292c0 5.211 3.438 9.63 8.205 11.188.6.111.82-.254.82-.567 0-.28-.01-1.022-.015-2.005-3.338.711-4.042-1.582-4.042-1.582-.546-1.361-1.335-1.725-1.335-1.725-1.087-.731.084-.716.084-.716 1.205.082 1.838 1.215 1.838 1.215 1.07 1.803 2.809 1.282 3.495.981.108-.763.417-1.282.76-1.577-2.665-.295-5.466-1.309-5.466-5.827 0-1.287.465-2.339 1.235-3.164-.135-.298-.54-1.497.105-3.121 0 0 1.005-.316 3.3 1.209.96-.262 1.98-.392 3-.398 1.02.006 2.04.136 3 .398 2.28-1.525 3.285-1.209 3.285-1.209.645 1.624.24 2.823.12 3.121.765.825 1.23 1.877 1.23 3.164 0 4.53-2.805 5.527-5.475 5.817.42.354.81 1.077.81 2.182 0 1.578-.015 2.846-.015 3.229 0 .309.21.678.825.56C20.565 21.917 24 17.495 24 12.292 24 5.78 18.627.5 12 .5z"></path>
                              </g>
                            </svg></button>
                          <button onclick="generate();"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 512 512" y="0" x="0" height="512" width="512" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                              <g>
                                <path data-original="#ffa100" fill="#ffa100" d="M29.653 201.648.957 289.816c-2.599 8.006.208 16.843 7.07 21.834l247.972 180.183-79.366-155.859-146.98-134.326zM482.347 201.648l28.696 88.168c2.599 8.006-.208 16.843-7.07 21.834L256.001 491.832l87.212-184.854 139.134-105.33z"></path>
                                <path class="" data-original="#ff6d18" fill="#ff6d18" d="m256 491.832-.001-178.6-94.302-111.585-65.97-32.822-66.074 32.822L256 491.832zM256 491.832l.001-189.402 94.302-100.783 71.367-32.822 60.677 32.822L256 491.832z"></path>
                                <path class="" data-original="#fc3819" fill="#fc3819" d="m256 491.832 94.302-290.185H161.698L256 491.832z"></path>
                                <path class="" data-original="#fc3819" fill="#fc3819" d="M29.654 201.65h132.148L104.929 26.874c-2.911-8.942-15.596-8.942-18.611 0L29.654 201.65zM482.346 201.65H350.198l56.769-174.776c2.911-8.942 15.596-8.942 18.611 0l56.768 174.776z"></path>
                              </g>
                            </svg></button>
                          <button onclick="generate();"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 512 512" y="0" x="0" height="512" width="512" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                              <g>
                                <path class="" data-original="#2684ff" fill="#2684ff" d="M16.436 25.814c-10.23 0-17.903 9.378-16.198 18.756l69.056 422.86c1.705 11.085 11.083 18.756 22.166 18.756h334.196c7.674 0 14.494-5.967 16.198-13.641l69.907-427.123c1.707-10.231-5.967-18.756-16.196-18.756l-479.129-.852zm293.275 305.21H203.143l-28.134-150.899H336.14l-26.429 150.899z"></path>
                                <linearGradient gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 -1 0 2434)" y2="2012.875" y1="2211.385" x2="270.312" x1="524.616" id="a">
                                  <stop style="stop-color:#0052CC" offset=".176"></stop>
                                  <stop style="stop-color:#2684FF" offset="1"></stop>
                                </linearGradient>
                                <path fill="" style="fill:url(#a);" d="M488.743 180.125H335.286L309.71 331.024H203.14L77.818 480.219s5.968 5.116 14.493 5.116h334.196c7.674 0 14.494-5.969 16.198-13.643l46.038-291.567z"></path>
                              </g>
                            </svg></button>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js" integrity="sha512-z4OUqw38qNLpn1libAN9BsoDx6nbNFio5lA6CuTp9NlK83b89hgyCVq+N5FdBJptINztxn1Z3SaKSKUS5UP60Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let container = document.querySelector('.container');
        for (let i = 0; i <= 80; i++) {
            let blocks = document.createElement('div');
            blocks.classList.add('block');
            container.appendChild(blocks);
        }

        function generate() {
            anime({
                targets: '.block',
                translateX: function () {
                    return anime.random(-700,700);
                },
                translateY: function () {
                    return anime.random(-500,500);
                },
                scale: function () {
                    return anime.random(1,5);
                }
            })
        }
        generate()

        function change() {
            var div = document.getElementById("minhaDiv");
            var conteudo = document.getElementById("conteudo");
            var conteudo0 = document.getElementById("conteudo0");
            var conteudo1 = document.getElementById("conteudo1");
            
            // Desaparece o conteúdo
            conteudo.style.display = "none";
            conteudo0.style.display = "block";
            conteudo1.style.display = "block";
            
            // Desloca a div para a esquerda
            div.style.transform = "translateX(-100%)";
        }

        function cancel() {
            var div = document.getElementById("minhaDiv");
            var conteudo = document.getElementById("conteudo");
            var conteudo0 = document.getElementById("conteudo0");
            var conteudo1 = document.getElementById("conteudo1");
            
            // Volta a exibir o conteúdo original
            conteudo.style.display = "block";
            conteudo0.style.display = "none";
            conteudo1.style.display = "none";
            
            // Retorna a posição original da div
            div.style.transform = "translateX(0)";
        }

        function hideModal() {
          document.getElementById('modal-container').style.display = 'none';
        }

        function redirectToPage() {
          window.location.href = "index.php";
        }
    </script>
    
</body>
</html>