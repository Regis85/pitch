<?php
    /* redimentionne une image */

    if(isset($_POST['submit'])){
      if (isset ($_FILES['myImage'])){
    $imagename = $_FILES['myImage']['name'];
    $source = $_FILES['myImage']['tmp_name'];
    $imagepath = $imagename;
    //Ceci est le nouveau fichier que vous enregistrez
    $save = "images/" . $imagepath;
    $info = getimagesize($imagepath);
    $mime = $info['mime'];
    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            break;
        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            break;
        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            break;
        default:
            throw new Exception('Unknown image type.');
    }

    list($width, $height) = getimagesize($imagepath);
    $modwidth = 500;  //target width
    $diff = $width / $modwidth;
    $modheight = $height / $diff;
    $tn = imagecreatetruecolor($modwidth, $modheight) ;
    $image = $image_create_func($imagepath) ;
    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
    $image_save_func($tn, $save) ;

    echo '<img src="'.$save.'">';
      }
    }
