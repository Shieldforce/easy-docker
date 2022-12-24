#!/bin/bash

if [ $# -lt 1 ]; then
   echo "Faltou utilizar pelo menos um argumento!"
   exit 1
fi

version=$1
port=$2
container=$3
remount=$4
root_dir="vendor/shieldforce/easy-docker/src/dockers/php/${version}/"

if [ $remount == "--build" ]; then
   docker stop ${container}
   docker rm ${container}
   docker image rm ${container}
fi

clear
echo "@>>>>>> Instalação do container de PHP em andamento.....";
echo "";
echo "";
echo "";

dir=/docker/

if [ -d $dir ]; then
  echo "Diretório Docker ok!"
else
  mkdir $dir
  echo "" >> "$dir/run.sh"
  chmod +x ${dir}run.sh
fi

docker build \
            -t ${container} \
            --build-arg PHP_VERSION=${version} \
            --build-arg EXPOSE_PORT=${port} \
            --build-arg ROOT_DIR=${root_dir} \
            -f "${root_dir}/Dockerfile" .

docker run \
            -d \
            --name ${container} \
            -v "$(pwd):/var/www/" \
            -p "${port}:80" \
            ${container}