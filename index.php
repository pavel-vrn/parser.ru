<html>
<head>
    <link rel='stylesheet' href='css/bootstrap.css'>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</head>

<body>

<?php
//к времени PhpStorm накинуть 6 часов времени
error_reporting(-1);
require "inc/Parser.php";
require "inc/Pdo_Helper.php";

$db = Pdo_Helper::singleton();

$pars = new Parser();
$result = "";
$result = $pars->getresult(1);
if(isset($_POST['submit']))
{
    //$result = $pars->getresult(1);
    //$result = $pars->getresult($_POST['in_word']);
}
?>


<a href="<?php echo $_SERVER["REQUEST_URI"];?>">Refresh</a>

<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand text-white">
        <!--<img src="/assets/images/favicon/favicon-180x180.png" class="d-inline-block align-top" width="30" height="30" alt="..."> -->
        Глаголы
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar3" aria-controls="navbar3" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar3">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Правила <span class="sr-only">(current)</span></a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>-->
            <!--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>-->
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Поиск">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Поиск</button>
        </form>
    </div>
</nav>


<table class="table table-hover table-bordered">
    <thead class="thead-inverse">
    <tr>
        <th>Пример</th>
        <th>ПредСтОснова</th>
        <th>СтСуф1</th>
        <th>СтСуф2</th>
        <th>КатСуф</th>
        <th>ПричСуф</th>
        <th>Флекс</th>
        <th>Результат</th>
        <th>Правила</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>требуем</td>
        <td>трЕб</td>
        <td>оуj</td>
        <td></td>
        <td>е</td>
        <td></td>
        <td>мъ</td>
        <td><?php print_r($result); ?></td>
        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">изменить</button></td>
    </tr>
    </tbody>
</table>
<!-- Модальное окно -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Правила для «Требуем»</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-bordered">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Пример</th>
                        <th>ПредСтОснова</th>
                        <th>СтСуф1</th>
                        <th>СтСуф2</th>
                        <th>КатСуф</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>требуем</td>
                        <td>трЕб</td>
                        <td>оуj</td>
                        <td></td>
                        <td>е</td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">Любая кнопка</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<div style="width: 300px">
<form method="post">
    <table align="left">
        <tr>
            <td>Входные данные:</td>
            <td><input type="text" name="in_word"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value = "Преобразовать"></td>
        </tr>
    </table>

</form>
</div>


</body>
</html>