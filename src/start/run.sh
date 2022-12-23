#!/bin/bash

path="$(pwd)/vendor/shieldforce/easy-docker/src/scoob"

echo "" >> ~/.bashrc;
echo "alias scoob='php ${path}'" >> ~/.bashrc;