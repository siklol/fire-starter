sudo apt-get install cutycapt xvfb xfs xfonts-scalable xfonts-100dpi libgl1-mesa-dri libqt4-webkit libqt4-dev -y


xvfb-run --server-args="-screen 0, 1024x768x24" cutycapt --url=http://www.google.com --out=/var/www/vhosts/fire_starter/master/web/images/screens/example.jpg