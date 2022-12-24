#!/bin/bash

version=$1
port=$2
container=$3

docker build \
            -t ${container} \
            --build-arg PHP_VERSION=${version} \
            --build-arg EXPOSE_PORT=${port} \
            -f "vendor/shieldforce/easy-docker/src/dockers/php/${version}/Dockerfile" .