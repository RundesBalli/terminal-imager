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
 * Parse command line args
 */
$type = isset($argv[1]) ? $argv[1] : NULL;
if (!isset($type)){
    echo("Specify image path as command line argument.\n\nExample: $argv[0] ./image.png\n");
    exit(1);
}

$datatype = substr($type, strrpos($type, '.') + 1);

/**
 * Read inputfile and create image resource.
 */
$input = "";
if (strtolower($datatype) === 'png') $input = imagecreatefrompng($type);
else if (strtolower($datatype) === 'jpg' || strtolower($datatype) === 'jpeg') $input = imagecreatefromjpeg($type);
else {
    echo("Invalid file type.\n");
    exit(1); 
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
    if($x == 0 && $y != 0) fwrite($fp, "\"\necho -e \"");
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
