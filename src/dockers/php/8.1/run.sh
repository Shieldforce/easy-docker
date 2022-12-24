#!/bin/bash

if [ $# -lt 1 ]; then
   echo "Faltou utilizar pelo menos um argumento!"
   exit 1
fi

version=$1
port=$2
container=$3
remount=$4
scoob_dir="vendor/shieldforce/easy-docker/src/dockers/php/${version}/"
root_dir="/"

if [ $remount == "--build" ]; then
   docker stop ${container}
   docker rm ${container}
   docker image rm ${container}
fi

dir=docker_scoob/php/$version

if [ -d $dir ]; then
  echo "Diretório Docker ok!"
else
  mkdir $dir
fi

cp -R ${scoob_dir}docker/* $dir
chmod 777 $dir

docker build \
            -t ${container} \
            --build-arg PHP_VERSION=${version} \
            --build-arg EXPOSE_PORT=${port} \
            --build-arg SCOOB_DIR=${scoob_dir} \
            --build-arg ROOT_DIR=${root_dir} \
            -f "${scoob_dir}/Dockerfile" .

docker run \
            -d \
            --name ${container} \
            -v "$(pwd):/var/www/" \
            -p "${port}:80" \
            ${container}