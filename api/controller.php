<?php

switch ($url[1]) {
    case '':
        include ('description.php');
        break;
    case 'helper':
        include ('helper/search.php');
        break;
}