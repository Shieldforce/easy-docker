#!/bin/bash

if [ $# -lt 1 ]; then
   echo "Faltou utilizar pelo menos um argumento!"
   exit 1
fi

version=$1
port=$2
container=$3
redis_port=$4
mysql_port=$5
remount=$6
scoob_dir="vendor/shieldforce/easy-docker/src/dockers/laravel/${version}/"
root_dir=""

if [ "$remount" == "--build" ]; then
   docker stop ${container}
   docker rm ${container}
   docker image rm ${container}
fi

dir=docker_scoob/laravel/$version

if [ -d $dir ]; then
  echo "Diretório Docker ok!"
else
  if [ -d docker_scoob ]; then
    echo "Diretório docker_scoob ok!"
  else
    mkdir docker_scoob
  fi

  if [ -d docker_scoob/laravel ]; then
    echo "Diretório laravel ok!"
  else
    cd docker_scoob && mkdir laravel
    cd ..
  fi

  if [ -d docker_scoob/laravel/$version ]; then
    echo "Diretório $version ok!"
  else
    cd docker_scoob/laravel && mkdir $version
    cd ..
    cd ..
  fi
fi

cp -R ${scoob_dir}docker/* $dir
chmod 777 $dir

docker build \
            -t ${container} \
            --build-arg PHP_VERSION=${version} \
            --build-arg EXPOSE_PORT=${port} \
            --build-arg SCOOB_DIR=${scoob_dir} \
            --build-arg ROOT_DIR=${root_dir} \
            --build-arg REDIS_PORT=${redis_port} \
            --build-arg MYSQL_PORT=${mysql_port} \
            -f "${scoob_dir}/Dockerfile" .

docker run \
            -d \
            --name ${container} \
            -v "$(pwd):/var/www/" \
            -p "${port}:80" \
            ${container}
