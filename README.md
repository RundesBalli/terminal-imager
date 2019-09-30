# terminal-imager
A PHP script which creates "terminal images" from an inputfile.

## Usage
Supported file types: `.png`, `.jpg`, `.jpeg`.
  
1. Open terminal
2. `php imager.php ./path/to/image.png`
3. The output is stored in `output.sh`
4. You can test the output with `chmod +x output.sh && ./output.sh`

## Note
Most terminals are 80 to 130 columns wide and 25 to 40 rows in height. So it's recommended to use pictures within this dimensions.

## Screenshots
RundesBalli logo:  
![RundesBalli logo](https://raw.githubusercontent.com/RundesBalli/terminal-imager/master/screenshots/1.png)  
  
Integrated circuit ([from wikipedia](https://en.wikipedia.org/wiki/File:Integrated_Circuit.jpg)):  
![integrated circuit](https://raw.githubusercontent.com/RundesBalli/terminal-imager/master/screenshots/2.png)
