#! /usr/bin/bash

sudo systemctl start virtualbox.service
sudo systemctl status virtualbox.service
vagrant up

# login to container
echo "==> 'cd ~/Code/platform-api' to find the platform code"
vagrant ssh
