
<?php
    $png = imagecreatetruecolor(800, 600);
    imagesavealpha($png, true);

    $trans_colour = imagecolorallocatealpha($png, 0, 0, 0, 127);
    imagefill($png, 0, 0, $trans_colour);
    
    $red = imagecolorallocate($png, 255, 0, 0);
    imagefilledellipse($png, 400, 300, 400, 300, $red);
    
    header("Content-type: image/png");
    imagepng($png);
?>
