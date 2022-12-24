#!/bin/bash

root_dir="vendor/shieldforce/easy-docker/src/dockers/php/${version}/"

if [ $# -lt 1 ]; then
   echo "Faltou utilizar pelo menos um argumento!"
   exit 1
fi

COUNT=0
for ARG in $*; do
   COUNT=`expr $COUNT + 1`
   echo "Argumento $COUNT: $ARG"

   case $ARG in
      "--php")
            echo "Você escolheu implementar PHP"
            ;;
      "-version")
            version=$(($COUNT+1))
            ;;
      "-port")
            port=$(($COUNT+1))
            ;;
      "-container")
            container=$(($COUNT+1))
            ;;
      "-remount")
            docker stop ${container} --force
            docker rm ${container} --force
            docker image rm ${container} --force
            ;;
      *) echo "Opção inválida!"
         #exit 1
         ;;
   esac

done

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