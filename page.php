<?php
define("LEVELS", array("first-level", "second-level", "third-level", "fourth-level", "fifth-level"));

function get_parameter_level($levelNum)
{
    $key = LEVELS[$levelNum - 1];
    if (isset($_POST[$key])) {
        echo $_POST[$key];
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Akaya+Telivigala&display=swap" rel="stylesheet">

    <title>Lab_2</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Описание страницы">
    <meta name="google" content="notranslate">

</head>

<body>

    <!--Header-->
    <header class="header">
        <div class="container">
            <div class="header__inner">

                <nav class="nav">
                    <?php

                    define("NAV_ITEMS", array("about" => "О компании", "services" => "Услуги",  "price" => "Прайс", "contacts" => "Контакты"));
                    $page = "";
                    if (isset($_GET["page"])) {
                        $page = $_GET["page"];
                    }
                    foreach (NAV_ITEMS as $nav_item_key => $nav_item_value) {
                        if ($nav_item_key == $page) {
                            $active_class = "class=\"nav__active\"  ";
                        } else {
                            $active_class = "";
                        }
                        echo sprintf("<a href=\"page.php?page=%s\" %s><h1>%s</h1></a>", $nav_item_key, $active_class, $nav_item_value);
                    }

                    ?>
                </nav>

            </div>
        </div>
    </header>


    <!-- Form -->
    <div class="basic">
        <div class="container">

            <div class="basic__inner">
                <?php
                $page = "";
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                }
                echo "<form action=\"page.php?page=" . $page . "\" method=\"post\">";
                ?>
                <h2 class="basic__header-2">Enter array elements separated by space</h2>
                <p>1) <input type="text" class="level-input" name="first-level" required <?php get_parameter_level(1) ?> /></p>
                <p>2) <input type="text" class="level-input" name="second-level" required <?php get_parameter_level(2) ?> /></p>
                <p>3) <input type="text" class="level-input" name="third-level" required <?php get_parameter_level(3) ?> /></p>
                <p>4) <input type="text" class="level-input" name="fourth-level" required <?php get_parameter_level(4) ?> /></p>
                <p>5) <input type="text" class="level-input" name="fifth-level" required <?php get_parameter_level(5) ?> /></p>
                <button class="button__submit" type="submit">
                    Получить результат
                </button>
                </form>
                <!-- ./basic__inner -->
            </div>


            <div class="basic__inner ">
                <div class="result" style="text-align: left;">

                    <?php
                    $is_submit = $_SERVER['REQUEST_METHOD'] == 'POST';
                    if ($is_submit) {
                        include('display.php');
                    }
                    ?>
                </div>
                <!-- ./basic__inner -->
            </div>

        </div>
    </div>


</body>

</html>