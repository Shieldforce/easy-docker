#!/bin/bash

version=$1
port=$2
container=$3
root_dir="vendor/shieldforce/easy-docker/src/dockers/php/${version}/"

docker build \
            -t ${container} \
            --build-arg PHP_VERSION=${version} \
            --build-arg EXPOSE_PORT=${port} \
            --build-arg ROOT_DIR=${root_dir} \
            -f "${root_dir}/Dockerfile" .

docker run \
            --name ${container} \
            -v "$(pwd):/var/www/" \
            -p "${port}:80" \
            ${container}