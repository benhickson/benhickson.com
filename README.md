# benhickson.com
code for my homepage

# Setup
- Install imagick for php
- Set the folder `images/serveable` permission with `chmod` to `777` to enable Imagick to write to the folder
- Install xsendfile for php
- Enable xsendfile to send files in the `images/serveable` folder

# Notable Features
- Custom-built image resizing and compression engine
- Clean routing for portfolio requests and 
- Clean routing for housing favicons
- Integrated with Vimeo API to detect aspect ratio of videos - data is cached
- Extremely DRY
