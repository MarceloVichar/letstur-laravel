# Letstur Laravel API

API para administração de agências de passeios turísticos, desenvolvida em Laravel

## Features no repositório

* Configuração de docker com docker compose para ambientes de desenvolvimento e produção;
* Projeto Laravel API;
* Testes de unidade e de feature, para garantir o comportamento das funcionalidades propostas;
* Workflows GitHub para rodar testes, lint e deploy via AWS;
* Horizon configurado para visualizar jobs disparados;
* Mailcatcher para visualizar email enviados pela aplicação;


## Utilizando o projeto pelo docker

Em primeiro lugar é necessário ter o docker e o docker compose instalados em sua máquina, para isso segue o tutorial:

* [Tutorial de instalação do docker com compose](https://docs.docker.com/install/linux/docker-ce/ubuntu/)

Para iniciar o projeto pela **primeira vez**, basta rodar os comandos abaixo:

```bash
$> ./laravel-docker start
$> ./setup.sh
```

Uma vez configurado, você não precisará mais rodar o script `setup.sh`.
Em vez disso, você precisará se preocupar apenas em subir e derrubar o ambiente:

#### Subir o ambiente
```
$> ./laravel-docker start
```

#### Derrubar o ambiente
```
$> ./laravel-docker stop
```

#### Limpar o ambiente
Este comando irá derrubar o ambiente, limpar os container órfãos e derrubar a rede interna do ambiente de desenvolvimento.
```
$> ./laravel-docker clean
```
