<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Detail - Jelajah Makanan</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="./vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
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
        $id_detail = openssl_decrypt($_GET["id"],'aes-128-cfb',$_SESSION["passphrase"], 0, $_SESSION["iv"]);        

        $json = file_get_contents("https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . $id_detail . "");
        $detail = json_decode($json, TRUE);

        $str_youtube = substr($detail['meals'][0]['strYoutube'], 32);
        $response_youtube_banyak = searchYoutubeByTitle($detail['meals'][0]['strMeal']);

        function searchYoutubeByTitle($q)
        {
            $keyword = urlencode($q);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://youtube.googleapis.com/youtube/v3/search?part=snippet&maxResults=3&q=' . $keyword . '&key=AIzaSyAuNh_4A2MF4SJcut9CoCLHPnFRoXY8Eek');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = 'Accept: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);

            curl_close($ch);
            return json_decode($result, TRUE);
        }

        function translateText($word)
        {
            $text = urlencode($word);
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://google-translate20.p.rapidapi.com/translate?text=$text&tl=id&sl=en",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: google-translate20.p.rapidapi.com",
                    "x-rapidapi-key: 52e8abf9ecmsh071be3a9c3dc76ep120da8jsnd7dcf7bc8a97"
                ],
            ]);

            $response = curl_exec($curl);

            curl_close($curl);

            $result = json_decode($response, TRUE);

            return $result['data']['translation'];
        }

        $listVideo = $response_youtube_banyak['items'];
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
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <div class="col-auto my-1">
                                    <a href="index.php" class="btn btn-warning light d-flex align-items-center"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <div class="col-auto my-1">
                                    <button type="button" class="btn light d-flex align-items-center about-sweet" style="opacity: 10;">Tentang</button>
                                </div>
                            </li>
                        </ul>
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
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="index.php">Daftar Jelajah Makanan</a></li>
                            <li class="breadcrumb-item"><a href="#" style="color: orange;">Detail</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-11">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3 ">
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade show active" id="first">
                                                <img class="img-fluid" src="<?php echo $detail['meals'][0]['strMealThumb']; ?>" alt="">
                                            </div>
                                            <br>
                                            <div role="tabpanel" class="tab-pane fade show active">
                                                <h4><?php echo $detail['meals'][0]['strMeal']; ?></h4>
                                                <hr>
                                                <h6><?php echo "Berasal dari: " . $detail['meals'][0]['strArea']; ?></h6>
                                                <h6><?php echo "Kategori: " . $detail['meals'][0]['strCategory']; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Tab slider End-->
                                    <div class="col-xl-9 col-sm-12">
                                        <div class="product-detail-content">
                                            <!--Product details-->
                                            <div class="new-arrival-content pr">
                                                <h5>Bahan-bahan</h5>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <p>
                                                        <?php
                                                        echo translateText(
                                                            $detail['meals'][0]['strMeasure1'] . " " . $detail['meals'][0]['strIngredient1'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure2'] . " " . $detail['meals'][0]['strIngredient2'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure3'] . " " . $detail['meals'][0]['strIngredient3'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure4'] . " " . $detail['meals'][0]['strIngredient4'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure5'] . " " . $detail['meals'][0]['strIngredient5'] . "</br>"
                                                        );
                                                        ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <p>
                                                        <?php
                                                        echo translateText(
                                                            $detail['meals'][0]['strMeasure6'] . " " . $detail['meals'][0]['strIngredient6'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure7'] . " " . $detail['meals'][0]['strIngredient7'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure8'] . " " . $detail['meals'][0]['strIngredient8'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure9'] . " " . $detail['meals'][0]['strIngredient9'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure10'] . " " . $detail['meals'][0]['strIngredient10'] . "</br>"
                                                        );
                                                        ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <p>
                                                        <?php
                                                        echo translateText(
                                                            $detail['meals'][0]['strMeasure11'] . " " . $detail['meals'][0]['strIngredient11'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure12'] . " " . $detail['meals'][0]['strIngredient12'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure13'] . " " . $detail['meals'][0]['strIngredient13'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure14'] . " " . $detail['meals'][0]['strIngredient14'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure15'] . " " . $detail['meals'][0]['strIngredient15'] . "</br>"
                                                        );
                                                        ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <p>
                                                        <?php
                                                        echo translateText(
                                                            $detail['meals'][0]['strMeasure16'] . " " . $detail['meals'][0]['strIngredient16'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure17'] . " " . $detail['meals'][0]['strIngredient17'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure18'] . " " . $detail['meals'][0]['strIngredient18'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure19'] . " " . $detail['meals'][0]['strIngredient19'] . "</br>"
                                                                . $detail['meals'][0]['strMeasure20'] . " " . $detail['meals'][0]['strIngredient20'] . "</br>"
                                                        );
                                                        ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <p class="text-content">
                                                    <h5>Instruksi Memasak</h5>
                                                    <?php
                                                    echo translateText($detail['meals'][0]['strInstructions']);
                                                    ?>
                                                </p>
                                                <br>
                                                <h5>Video Cara Memasak</h5>
                                                <?php
                                                if ($str_youtube != "") {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6><?php echo $detail['meals'][0]['strMeal'] ?></h6>
                                                            <iframe src="https://www.youtube.com/embed/<?php echo $str_youtube; ?>?hl=id&cc_lang_pref=en&cc_load_policy=1" width="500" height="350" allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }

                                                    if ($listVideo != null) {
                                                        foreach ($listVideo as $row) {
                                                            ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6><?php echo $row["snippet"]["title"] ?></h6>
                                                                <iframe src="https://www.youtube.com/embed/<?php echo $row["id"]["videoId"] ?>?hl=id&cc_lang_pref=en&cc_load_policy=1" width="500" height="350" allowfullscreen></iframe>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
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
    
    <script src="./vendor/highlightjs/highlight.pack.min.js"></script>
    <!-- Circle progress -->

    <script src="./vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script>
        document.querySelector(".about-sweet").onclick = function () {
            swal({
                title: "Halo!!",
                text: "Website ini dibuat oleh Mochamad Nurkhayal Kadafi untuk memenuhi tugas besar mata kuliah Aplikasi Teknologi Online."
            })            
        }
    </script>    

</body>

</html>