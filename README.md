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

#### Para Rodar um container com PHP7.4/Nginx:
```
scoob --php --version=7.4 --port=8074 --container=php74
```

#### Para Rodar um container com PHP8.1/Nginx:
```
scoob --php --version=7.4 --port=8074 --container=php74
```

#### Para Rodar um container com PHP8.2/Nginx:
```
scoob --php --version=7.4 --port=8074 --container=php74
```