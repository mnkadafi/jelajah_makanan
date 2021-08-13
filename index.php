<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home - Jelajah Makanan</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link rel="stylesheet" href="./vendor/select2/css/select2.min.css">
    <link href="./vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper" class="show menu-toggle">

        <?php
        session_start();
        $_SESSION["passphrase"] = openssl_random_pseudo_bytes(16);
        $_SESSION["iv"] = openssl_random_pseudo_bytes(16);

        if ($_SESSION["category"] == "") {
            $_SESSION["category"]  = "Beef";
        }

        $pilih_category = $_SESSION["category"];

        $json = file_get_contents("http://www.themealdb.com/api/json/v1/1/categories.php");
        $category = json_decode($json, TRUE);

        if (isset($_POST['kategori'])) {
            $pilih_category = $_POST['kategori'];
            $_SESSION["category"] = $_POST['kategori'];
        }

        $json = file_get_contents("https://www.themealdb.com/api/json/v1/1/filter.php?c=" . $_SESSION["category"] . "");
        $meals = json_decode($json, TRUE);

        ?>

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown show">
                                <div class="dropdown-menu p-0 m-0 show">
                                    <div class="mr-auto d-none d-lg-block">
                                        <h2 class="text-black font-w600 mb-0">Jelajah Makanan</h2>
                                        <p class="mb-0">Pilih dan Lihat bagaimana makanan dibuat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="index.php" method="post">
                            <ul class="navbar-nav header-right">
                                <li class="nav-item dropdown notification_dropdown">
                                    <div class="col-auto my-1">
                                        <label class="mr-sm-2">Kategori</label>
                                        <select class="mr-sm-2" id="single-select" name="kategori">
                                            <?php foreach ($category['categories'] as $row) { ?>
                                                <option <?php if ($pilih_category == $row['strCategory']) {
                                                                echo "selected";
                                                            } ?> value="<?php echo $row['strCategory'] ?>"><?php echo $row['strCategory'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-auto my-1">
                                        <label class="mr-sm-2">Aksi</label>
                                        <button type="submit" class="btn btn-warning light d-flex align-items-center"> Lihat</button>
                                    </div>
                                </li>
                                <li class="nav-item dropdown header-profile">
                                    <div class="col-auto my-1">
                                        <label class="mr-sm-2">&nbsp;</label>
                                        <button type="button" class="btn light d-flex align-items-center about-sweet" style="opacity: 10;">Tentang</button>
                                    </div>
                                </li>
                            </ul>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-xxl-11 col-lg-12 col-lg-9 col-md-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body tab-content pb-0">
                                        <div class="tab-pane fade show active" id="monthly1">
                                            <div class="row">
                                                <?php
                                                foreach ($meals['meals'] as $rowMeals) {
                                                    ?>
                                                    <div class="col-md-3 col-xl-3 col-xxl-3 col-sm-3 mb-5">
                                                        <div class="media mb-4">
                                                            <img src="<?php echo $rowMeals['strMealThumb']; ?>" style="width:100%;" class="rounded" alt="" />
                                                        </div>
                                                        <div class="info">
                                                            <h5 class="text-black mb-3"><?php echo $rowMeals['strMeal']; ?></h5>
                                                        </div>
                                                        <a href="detail.php?id=<?php echo openssl_encrypt($rowMeals['idMeal'], 'aes-128-cfb', $_SESSION["passphrase"], 0, $_SESSION["iv"]); ?>" class="btn btn-primary light btn-sm btn-rounded px-4"><i class="fa fa-search "></i> Lihat Detail</a>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->



    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="./vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="./js/custom.min.js"></script>
    <script src="./js/deznav-init.js"></script>

    <script src="./vendor/select2/js/select2.full.min.js"></script>
    <script src="./js/plugins-init/select2-init.js"></script>

    <script src="./vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script>
        document.querySelector(".about-sweet").onclick = function() {
            swal({
                title: "Halo!!",
                text: "Website ini dibuat oleh Mochamad Nurkhayal Kadafi untuk memenuhi tugas besar mata kuliah Aplikasi Teknologi Online."
            })
        }

        $(document).ready(function(e) {
            $('#kategori').select2({
                dropdownParent: $('#select2-modal')
            });
        });
    </script>
</body>

</html>