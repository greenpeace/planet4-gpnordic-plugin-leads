<?php

function planet4_get_partial($name, $data = [])
{
    $path = __DIR__ . "/../parts/$name.php";
    if (file_exists($path)) {
        extract($data);
        // Start output buffering
        ob_start();
        // Include the template file
        include $path;
        // End buffering and return its contents
        $output = ob_get_clean();

        echo $output;
    }
};

function svg_icon($icon) {
  $file = file_get_contents(__DIR__ . "/../assets/images/icons/$icon.svg");
  echo $file;
}

function hexToHsl($hex)
{
    $red = hexdec(substr($hex, 0, 2)) / 255;
    $green = hexdec(substr($hex, 2, 2)) / 255;
    $blue = hexdec(substr($hex, 4, 2)) / 255;

    $cmin = min($red, $green, $blue);
    $cmax = max($red, $green, $blue);
    $delta = $cmax - $cmin;

    if ($delta === 0) {
        $hue = 0;
    } elseif ($cmax === $red) {
        $hue = (($green - $blue) / $delta) % 6;
    } elseif ($cmax === $green) {
        $hue = ($blue - $red) / $delta + 2;
    } else {
        $hue = ($red - $green) / $delta + 4;
    }

    $hue = round($hue * 60);
    if ($hue < 0) {
        $hue += 360;
    }

    $lightness = (($cmax + $cmin) / 2) * 100;
    $saturation = $delta === 0 ? 0 : ($delta / (1 - abs(2 * $lightness - 1))) * 100;
    if ($saturation < 0) {
        $saturation += 100;
    }

    $lightness = round($lightness);
    $saturation = round($saturation);

    //For the current purpose we want these values. Turn off or change this override to adapt to output
    $saturation = 100;
    $lightness = 20;

    return "hsl(${hue}, ${saturation}%, ${lightness}%)";
}

function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
    //Return default if no color provided
    if(empty($color))
          return $default; 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
        //Return rgb(a) color string
        return $output;
}

