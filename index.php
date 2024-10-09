<?php
  include 'config.php';
  session_start();
  
  if (isset($_POST['submit'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
  
      // Verificar as credenciais do usuário
      $query = "SELECT * FROM users WHERE email = '$email'";
      $result = mysqli_query($conn, $query);
  
      if (mysqli_num_rows($result) > 0) {
          $user = mysqli_fetch_assoc($result);
          if (password_verify($password, $user['senha'])) {
              // Senha está correta, iniciar sessão
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['user_name'] = $user['nome'];
              header("Location: lobby.php");
              exit();
          } else {
              $message = 'Incorrect password';
          }
      } else {
          $message = 'This email does not exist';
      }
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VEchat - Login</title>
    <link rel="shortcut icon" href="img/logo/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style1.css">
                    <!--google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Tilt+Neon&display=swap" rel="stylesheet">
</head>
<body>

    <div class="particles">
        <span style="--i:11;"></span>
        <span style="--i:12;"></span>
        <span style="--i:24;"></span>
        <span style="--i:10;"></span>
        <span style="--i:14;"></span>
        <span style="--i:13;"></span>
        <span style="--i:18;"></span>
        <span style="--i:16;"></span>
        <span style="--i:19;"></span>
        <span style="--i:20;"></span>
        <span style="--i:22;"></span>
        <span style="--i:25;"></span>
        <span style="--i:18;"></span>
        <span style="--i:21;"></span>
        <span style="--i:13;"></span>
        <span style="--i:15;"></span>
        <span style="--i:26;"></span>
        <span style="--i:17;"></span>
        <span style="--i:13;"></span>
        <span style="--i:28;"></span>
        <span style="--i:11;"></span>
        <span style="--i:12;"></span>
        <span style="--i:24;"></span>
        <span style="--i:10;"></span>
        <span style="--i:14;"></span>
        <span style="--i:13;"></span>
        <span style="--i:18;"></span>
        <span style="--i:16;"></span>
        <span style="--i:19;"></span>
        <span style="--i:20;"></span>
        <span style="--i:22;"></span>
        <span style="--i:25;"></span>
        <span style="--i:18;"></span>
        <span style="--i:21;"></span>
        <span style="--i:13;"></span>
        <span style="--i:15;"></span>
        <span style="--i:26;"></span>
        <span style="--i:17;"></span>
        <span style="--i:13;"></span>
        <span style="--i:28;"></span>
    </div>
    

    <div class="container">

        <div class="color"></div>
        <div class="color"></div>
        <div class="color"></div>

        <div class="content">
            <div class="box">
                <h1>VEchat</h1>
                <h3>Come and in join with us</h3>
                <img src="background/animacao1.gif" alt="">
                <h6>Desenvolved by - Tsiangana - 2023 
                    <br> &copy;all things reserved</h6>
            </div>
            <div class="box">
                <div class="box1">
                    <div class="square" style="--i:0;"></div>
                    <div class="square" style="--i:1;"></div>
                    <div class="square" style="--i:2;"></div>
                    <div class="square" style="--i:3;"></div>
                    <div class="square" style="--i:4;"></div>
                    <div class="container1">
                        <div class="form">
                            
                        <div class="login">
                            <h2>Login</h2>
                            <form action="" method="post">
                                <div class="inputBox">
                                    <input type="email" placeholder="email:" name="email" required>
                                </div>
                                <div class="inputBox">
                                    <input type="password" placeholder="password:" name="password" required>
                                </div>
                                <?php if (isset($message)): ?>
                                        <p class="error" style="color:#d12929; text-align:center;margin-top: 5px;"><?php echo $message; ?></p>
                                    <?php endif; ?>
                                <a href="#"><p class="forget password"> Forgot password ?</p></a>
                                <div class="buttons">
                                    <div class="inputBox">
                                        <input type="submit" value="Login" name="submit">
                                    </div>
                                    <div class="inputBox">
                                        <input onclick="redirectToPage()" value="Sign up" id="change2">
                                    </div>
                                </div>
                                <a href="sign.php"><p class="forget forget1">Click here for help</p></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    
    <script src="js/animatio_bachground.js"></script>
    <script>
    function redirectToPage() {
      window.location.href = "sign.php";
    }
  </script>
</body>
</html>