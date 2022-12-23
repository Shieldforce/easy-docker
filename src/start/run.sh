#!/bin/bash
# shellcheck disable=SC1090

path="/vendor/shieldforce/easy-docker/src/scoob"

echo "" >> ~/.bashrc;
echo "alias scoob='${path}'" >> ~/.bashrc;
source ~/.bashrc

echo "Alias criado com sucesso!"