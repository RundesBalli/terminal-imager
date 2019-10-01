<?php
/**
 * terminal-imager
 * 
 * @author    RundesBalli <rundesballi@rundesballi.com>
 * @copyright 2019 RundesBalli
 * @version   1.0
 * @license   MIT-License
 * 
 * @see https://github.com/RundesBalli/terminal-imager
 */

/**
 * Parse command line args, read inputfile and create image resource.
 */
if(isset($argv[1]) AND !empty($argv[1])) {
  if (!file_exists($argv[1])) {
    die("\e[48;2;128;0;0m\e[38;2;255;255;255mError:\e[0m The file does not exist.\n");
  }
  $extension = strtolower(pathinfo($argv[1], PATHINFO_EXTENSION));
  if($extension == 'png') {
    $input = imagecreatefrompng($argv[1]);
  } elseif($extension == 'jpg' OR $extension == 'jpeg') {
    $input = imagecreatefromjpeg($argv[1]);
  } else {
    die("\e[48;2;128;0;0m\e[38;2;255;255;255mError:\e[0m Invalid file type.\n\e[48;2;0;128;0m\e[38;2;255;255;255mSupported file types are:\e[0m .png, .jpg, .jpeg\n");
  }
} else {
  die("\e[48;2;128;0;0m\e[38;2;255;255;255mError:\e[0m You must specify an image path as command line argument.\n\e[48;2;0;128;0m\e[38;2;255;255;255mExample:\e[0m ".$argv[0]." ./image.png\n");
}

/**
 * Open outputfile and write initial comment and start the image line.
 */
$fp = fopen("output.sh", "w");
fwrite($fp, "# terminal-imager by RundesBalli\n# see: https://github.com/RundesBalli/terminal-imager\n");
fwrite($fp, "echo -e \"");
/**
 * Go line by line, pixel by pixel and create RGB ANSI escape sequence.
 * @see https://en.wikipedia.org/wiki/ANSI_escape_code#24-bit
 */
for($y = 0; $y < imagesy($input); $y++) {
  for($x = 0; $x < imagesx($input); $x++) {
    if($x == 0 && $y != 0) {
      fwrite($fp, "\"\necho -e \"");
    }
    $color = imagecolorsforindex($input, imagecolorat($input, $x, $y));
    fwrite($fp, "\\e[48;2;".$color['red'].';'.$color['green'].';'.$color['blue']."m ");
  }
}
/**
 * End image line and reset colors to default, then close the file.
 */
fwrite($fp, "\"\necho -e \"\\e[0m\"\n");
fclose($fp);
?>
