# Lisk Download File
A tool to download files, pictures, etc… that are send on the lisk network with [Lisk Send File]( https://github.com/S3x0r/Lisk-Send-File)

## Windows
To use Lisk-Download-File you must download the latest version from the [releases page]( https://github.com/S3x0r/Lisk-Download-File/releases).
### Run the tool
You have 2 ways to use Lisk-Download-File:
1.	Running the DOWNLOAD.BAT.
2.	Or using the command line interface.
#### DOWNLOAD.BAT
If you want to use the DOWNLOAD.BAT file you just must run the file and it will launch the cli version of Lisk-Download-File.
#### Comand line interface
As last option you can use the command line interface. If you choose for this option you need to go with cmd to the folder that you’ve download and use the following command: `./php/php.exe -c “./php/php.ini” -f ”download.php”`. You can also add an argument to the command, so you don’t need to the file id anymore int the download interface. An example for this is `./php/php.exe -c “./php/php.ini” -f ”download.php” 12225769589953605924`.

## Linux
### Configuration
If you haven’t used [Lisk Send File]( https://github.com/S3x0r/Lisk-Send-File) or php before on your linux device, then you must install php and php-zip first to use Lisk-Download-File. This can be done with the following command: `sudo apt-get install php php-zip`.
### Download
After the configuration is done you can download the tool with `wget https://raw.githubusercontent.com/S3x0r/Lisk-Download-File/master/download.php`.

### Run the tool
When the download is finished you can run the tool on two different ways.
1.	The first one is with `php download.php`.
2.	The second one is with `php download.php 12225769589953605924`.

You don’t have to put in a file id in the download interface if you use the second option.
After the download is finished you’ll find the downloaded file in the folder where download.php is located.


