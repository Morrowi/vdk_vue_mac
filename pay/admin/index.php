<?
include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/function.php';
global $connect;
//


if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){

    $query = mysqli_query($connect,"SELECT * FROM user WHERE id = '".intval($_COOKIE['id'])."' LIMIT 1");

    $userdata = mysqli_fetch_assoc($query);
    if(($userdata['hash'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id'])){
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        $showAuth = true;
    }else{
        $showAuth = false;
    }
} else {
    echo 1;
    $showAuth = true;
}

;
?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>
        Soft UI Design System by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/soft-design-system.css?v=1.0.5" rel="stylesheet" />
</head>

<body class="sign-in-illustration">
<!-- Navbar -->
<?if($showAuth){?>
<section>
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-left">
                            <h4 class="font-weight-bolder">Sign In</h4>
                            <p class="mb-0">Enter your email and password to sign in</p>
                        </div>
                        <div class="card-body">
                            <form role="form" id="auth" action="" onsubmit="auth(); return false;">
                                <div class="mb-3">
                                    <input name="login" type="text" class="form-control form-control-lg" placeholder="Login" aria-label="Login" aria-describedby="login-addon">
                                </div>
                                <div class="mb-3">
                                    <input name="password" type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                </div>
                                <div class="form-check form-switch">
                                    <input name="remember" class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit"  class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                    <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
                        <img src="assets/img/shapes/pattern-lines.svg" alt="pattern-lines" class="position-absolute opacity-4 start-0">
                        <div class="position-relative">
                            <img class="max-width-500 w-100 position-relative z-index-2" src="assets/img/illustrations/chat.png">
                        </div>
                        <h4 class="mt-5 text-white font-weight-bolder">Admin panel Karelforum</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?}else{?>
    <section class="py-sm-7 py-5 position-relative">
        <div class="container">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Участники</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Телефон</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">E-mail</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Организация</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Дата</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">КТО?</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Цена</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Промо</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Оплата</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Отправка билета</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?

                        if (isset($_GET['page'])){
                            $page = $_GET['page'];
                        }else{
                            $page = 1;
                        }
                        $kol = 10;  //количество записей для вывода
                        $art = ($page * $kol) - $kol; // определяем, с какой записи нам выводить

                        $query = mysqli_query($connect,"SELECT * FROM customer ORDER BY id DESC LIMIT $art,$kol");

                        while ($customer = $customers = mysqli_fetch_assoc($query)) {

                            ?>
                        <tr id="element_line_<?=$customer['id']?>" class="fix_before">
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['id']?></p>
                            </td>
                            <td>
                                <?
                                $users = json_decode($customer['user']);
                                $ids = join("','",$users);
                                $users = mysqli_query($connect,"SELECT * FROM users  WHERE id IN ('$ids')");


                                ?>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <?
                                        while ($user = $customers = mysqli_fetch_assoc($users)){
                                            unset($user['id'],$user['customer']);
                                            ?>
                                        <h6 class="mb-0 text-xs"><?echo  implode(' ', $user)?></h6>
                                        <?}?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['phone']?></p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['email']?></p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center">
                                    <?
                                    switch ( $customer['what']){
                                        case 'company_one_day':
                                        case 'company_full_day':
                                            echo '<a href="javascript:;" onclick="showRequzit('.$customer['id'].');" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Выслать билет">'.$customer['name_organiz'].'</a>';
                                            break;
                                        default:
                                            echo '-';
                                            break;
                                    }
                                    ?>

                                </p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['date']?></p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center">
                                    <?
                                    switch ( $customer['what']){
                                        case 'company_one_day':
                                            echo 'Ю. день';
                                            break;
                                        case 'company_full_day':
                                            echo 'Ю. вce день';
                                            break;
                                        case 'private_one_day':
                                            echo 'Ф. один день';
                                            break;
                                        case 'private_full_day':
                                            echo 'Ф. все дни';
                                            break;
                                        case 'private_stud_full_day':
                                            echo 'Студ.';
                                            break;
                                    }
                                    ?>
                                </p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['price']?></p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['promo']?></p>
                            </td>
                            <td>
                                <?if($customer['paymend']==0){?>
                                <p class="text-xs font-weight-bold mb-0 text-center">Нет</p>
                                <p class="text-xs text-secondary mb-0 text-center"><a href="javascript:;" onclick="paymend(<?=$customer['id']?>);" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Выслать билет">Оплачен</a></p>
                                <?}else{?>
                                    <p class="text-xs text-secondary mb-0 text-center">Да</p>
                                <?}?>

                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0 text-center">
                                    <?=($customer['send_ticket']==0)?'<a href="javascript:;" onclick="sendTiket('.$customer['id'].');" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Выслать билет">Выслать</a>':'Отправлен'?>
                                </p>
                            </td>
                        </tr>
                        <?}?>

                        </tbody>
                    </table>
                </div>
            </div>
            <?


            $res = mysqli_query($connect,"SELECT  COUNT(*) FROM customer");
            $row = mysqli_fetch_row($res);
            $total = $row[0]; // всего записей

            $str_pag = ceil($total / $kol);
            ?>
            <nav aria-label="Page navigation example" class="d-flex justify-content-between align-content-center my-4">
                <ul class="pagination">
                    <?for ($i = 1; $i <= $str_pag; $i++){
                        if($_GET['page']== $i){$active='active';}else{$active='';}
                        echo '<li class="page-item '.$active.' "><a class="page-link" href=/admin/?page='.$i.'>'.$i.' </a></li>';
                    }
                    ?>
                </ul>
                <div><span class="badge bg-gradient-primary">Всего: <?=$total?> </span></div>
            </nav>

        </div>
    </section>
    <footer class="footer py-5 bg-gradient-dark position-relative overflow-hidden">
        <img src="assets/img/shapes/waves-white.svg" alt="pattern-lines" class="position-absolute start-0 top-0 w-100 opacity-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 me-auto mb-lg-0 mb-4 text-lg-start text-center">
                    <h6 class="text-white font-weight-bolder text-uppercase mb-lg-4 mb-3">Soft</h6>
                    <ul class="nav flex-row ms-n3 justify-content-lg-start justify-content-center mb-4 mt-sm-0">
                        <li class="nav-item">
                            <a class="nav-link text-white opacity-8" href="https://www.creative-tim.com" target="_blank">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white opacity-8" href="https://www.creative-tim.com/presentation" target="_blank">
                                About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white opacity-8" href="https://www.creative-tim.com/blog" target="_blank">
                                Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white opacity-8" href="https://www.creative-tim.com" target="_blank">
                                Services
                            </a>
                        </li>
                    </ul>
                    <p class="text-sm text-white opacity-8 mb-0">
                        Copyright © <script>
                            document.write(new Date().getFullYear())
                        </script> Soft by Creative Tim.
                    </p>
                </div>
                <div class="col-lg-6 ms-auto text-lg-end text-center">
                    <p class="mb-5 text-lg text-white font-weight-bold">
                        The reward for getting on the stage is fame. The price of fame is you can’t get off the stage.
                    </p>
                    <a href="javascript:;" target="_blank" class="text-white me-xl-4 me-4 opacity-5">
                        <span class="fab fa-dribbble"></span>
                    </a>
                    <a href="javascript:;" target="_blank" class="text-white me-xl-4 me-4 opacity-5">
                        <span class="fab fa-twitter"></span>
                    </a>
                    <a href="javascript:;" target="_blank" class="text-white me-xl-4 me-4 opacity-5">
                        <span class="fab fa-pinterest"></span>
                    </a>
                    <a href="javascript:;" target="_blank" class="text-white opacity-5">
                        <span class="fab fa-github"></span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Modal -->
    <div class="modal fade" id="showRequzit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Реквизиты</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="container_requzit">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?}?>
<!--   Core JS Files   -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
<!--  Plugin for Parallax, full documentation here: https://github.com/wagerfield/parallax  -->
<script src="assets/js/plugins/parallax.min.js"></script>
<!-- Control Center for Soft UI Kit: parallax effects, scripts for the example pages etc -->
<script src="assets/js/soft-design-system.min.js?v=1.0.5" type="text/javascript"></script>
<script src="assets/js/main.js" type="text/javascript"></script>
</body>

</html>