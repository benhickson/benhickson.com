# benhickson.com
code for my homepage

## Notable Features
- Custom-built image resizing and compression engine
- Clean routing for portfolio requests and full separation of data and presentation
- Clean routing for housing favicons
- Integrated with Vimeo API to detect aspect ratio of videos - data is cached
- Extremely DRY

## Setup
- Start with an Apache + PHP environment
- Install the Imagick extension/module for PHP
- Set the folder `images/serveable` permissions with `chmod` to `777` to enable Imagick to create new images in that folder:
  ```bash
  chmod 777 ./images/serveable
  ```
- Install XSendFile extension/module for PHP
- Enable XSendFile to send files in the `images/serveable` folder

## Run Locally on OSX (development)
- Follow these setup instructions to install Apache and PHP properly https://getgrav.org/blog/macos-catalina-apache-multiple-php-versions
- Add above extensions/modules (Imagick, XSendFile)
- Modify `/usr/local/etc/httpd/httpd.conf`'s `DocumentRoot` and `<Directory>` paths to point to this project folder
