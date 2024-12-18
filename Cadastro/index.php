<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="images/img-01.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="POST" action="/cadastro.php">
                    <span class="login100-form-title">
                        Cadastro
                    </span> 


                    <?php if(isset($_GET['login_error']) && $_GET['login_error'] == 'email'): ?>
                        <div class="alert alert-danger" role="alert">
                            Email já cadastrado.
                        </div>
						<br>
                    <?php endif; ?>

                    <?php if(isset($_GET['new_account']) && $_GET['new_account'] == 'false'): ?>
                        <div class="alert alert-danger" role="alert">
                            Erro ao cadastrar. Tente novamente
                        </div>
						<br>
                    <?php endif; ?>

                    <div class="wrap-input100 validate-input" data-validate="Name is required">
                        <input class="input100" type="text" name="nome" id="nome" placeholder="Nome">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" id="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="senha" id="senha" placeholder="Senha">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Cadastrar
                        </button>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="/Login/">
                            Entre com sua Conta
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
