Easy Docker

Simples instalação:

#### Rode o comando para baixar o pacote para sua vendor:
```
composer require shieldforce/easy-docker
```

#### Rode o comando para criar atalhos, assim vamos facilitar nosso trabalho:
```
bash vendor/shieldforce/easy-docker/src/start/run.sh
```

#### Rode o comando para atualizar o arquivo de configuração do usuário:
```
source ~/.bashrc
```

#### Para Rodar um container com PHP/Nginx:
```
scoob --php --version={version} --port={exporse port} --container={contaner name}
```

#### Para Remontar um container utilize a flag --remount:
```
scoob --php --version={version} --port={exporse port} --container={contaner name} --remount
```

# Exemplos:

#### Para Rodar um container com PHP7.4/Nginx | Levantará um server nesse endereço (http://localhost:8074) :
```
scoob --php --version=7.4 --port=8074 --container=php74
```

#### Para Rodar um container com PHP8.1/Nginx | Levantará um server nesse endereço (http://localhost:8081) :
```
scoob --php --version=8.1 --port=8081 --container=php81
```

#### Para Rodar um container com PHP8.2/Nginx | Levantará um server nesse endereço (http://localhost:8082) :
```
scoob --php --version=8.2 --port=8082 --container=php82
```

#### Para Rodar um container com Laravel/PHP7.4/Nginx/MariaDB-10/Redis/Horizon/Cron | Levantará um server nesse endereço (http://localhost:9074) :
```
scoob --laravel --version=7.4 --port=9074 --container=laravel-php74
```

#### Para Rodar um container com Laravel/PHP8.1/Nginx/MariaDB-10/Redis/Horizon/Cron | Levantará um server nesse endereço (http://localhost:9081) :
```
scoob --laravel --version=8.1 --port=9081 --container=laravel-php81
```

#### Para Rodar um container com Laravel/PHP8.2/Nginx/MariaDB-10/Redis/Horizon/Cron | Levantará um server nesse endereço (http://localhost:9082) :
```
scoob --laravel --version=8.2 --port=9082 --container=laravel-php82
```
---
### Se precisar remontar acrescente a flag --remount