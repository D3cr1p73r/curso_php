<!DOCTYPE html>
<html lang="pt-be">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style type="text/css" >
    * { margin: 0; padding: 0; font-family:Tahoma; font-size:9pt;}
      #divCenter {   
        background-color: #e1e1e1; 
        width: 100%; 
        height: 130%; 
        left: 50%; 
        margin: -130px 0 0 -210px; 
        padding:10px;
        position: absolute; 
        top: 30%; }
      }
    </style>
</head>
<body>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">

    <div class="container" id="divCenter" >
        <div class="row" >
            <aside class="col-md-4 mt-4 pb-10">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title text-center mb-4 mt-1">Login</h4>
                        <hr>
                        <p class="text-success text-center">Informe seu usuario e senha</p>
                        <form action="file:///C:/xampp/htdocs/Sistema_Cadastro/telas/home_cad.php">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input name="" class="form-control" placeholder="Email or login" type="email">
                                </div> <!-- input-group.// -->
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input class="form-control" placeholder="******" type="password">
                                </div> <!-- input-group.// -->
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"> Login  </button>
                            </div> <!-- form-group// -->
                            <p class="text-center"><a href="#" class="btn">Esqueci minha senha</a></p>
                        </form>
                    </article>
                </div> <!-- card.// -->
            </aside> 
        </div> <!-- row.// -->
    </div> 
    <!--container end.//-->
</body>
</html>
                            