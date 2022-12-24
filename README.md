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

#### Para Rodar um container com PHP/Apache:
```
scoob --php --version={version} --port={exporse port} --container={contaner name}
```