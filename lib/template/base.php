<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/styles/style.css">
    <link rel="stylesheet" href="/styles/bootstrap.css">
    <script src="/scripts/jquery.js"></script>
    <script src="/scripts/bootstrap.js"></script>
    <title>Vier Gewinnt</title>
    <?=$HEAD?>
</head>

<body>

    <div class="navbar">
        <a class="navbar-brand" href="/viergewinnt.php">Vier Gewinnt</a>
        <ul class="nav navbar-nav pull-right">
            <?php if(!isset($_SESSION['login'])) { ?>

            <li class="dropdown">
            <a href="#" id="login" role="button" class="dropdown-toggle" data-toggle="dropdown">
                Login/Register
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu" role="menu" area-labelledby="loginMenu">
                <li>
                    <form class="login form-horizontal" action="login.php" method="post">
                        <div class="form-group">
                            <label class="col-lg-4 control-label">
                                Nickname: 
                            </label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" name="nick" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label">
                                Passwort: 
                            </label>
                            
                            <div class="col-lg-8">
                                <input class="form-control" type="password" name="pwd" />
                            </div>
                        </div>
                        <div class="form-group"> 
                            <div class="col-lg-8 col-lg-offset-4">
                            <input class="btn btn-primary btn-lg btn-block" type="submit" value="Login" />
                            </div>
                        </div>
                    </form>
                    <li class="divider"></li>
                    <div class="col-lg-8 col-lg-offset-4"><a href="/register.php" class="btn btn-link">or register instead!</a></div>
                </li>
            </ul>
            </li>
            <?php } else { ?>
                
            <li><p class="navbar-text"><?=$username?> :: <a href="/logout.php">Logout</a></p></li>
            
            <?php } ?>
        </ul>
    </div>
    <div class="col-lg-12"><?=$BODY?></div>
</body>
</html>
