#!/bin/bash
# shellcheck disable=SC1090

path="vendor/shieldforce/easy-docker/scoob"

echo "" >> ~/.bashrc;
echo "alias scoob='chmod -R 755 vendor/shieldforce/easy-docker/ && php ${path}'" >> ~/.bashrc;
source ~/.bashrc
chmod -R 755 vendor/shieldforce/easy-docker/

echo "Alias criado com sucesso!"