docker build \
            -t ${CONTAINER} \
            --build-arg REDIS_PORT=${REDIS_PORT} \
            --build-arg MYSQL_PORT=${MYSQL_PORT} \
            --build-arg WEB_PORT=${WEB_PORT} \
            --build-arg PHP_PORT=${PHP_PORT} \
            -f 'docker/runs/Dockerfile' .