Uso do Docker
=============

[Docker] é uma plataforma para isolamento do ambiente de desenvolvimento, de forma mais leve que a virtualização tradicional. Para detalhes, visite o site ou dê uma olhada [nessa apresentação][slides] ([vídeo][europython]).

Configurando o ambiente de dev
----------------------------------

1. [Instale o Docker][install]: `wget -qO- https://get.docker.com/ | sh`
2. Baixe a imagem: `docker pull konato/php7-beta`

### Uso comum

#### Criar um container a partir da imagem
É possível fazer o *bind* de uma pasta local com uma pasta do container, de modo que as alterações de arquivos no *filesystem* da sua máquina se reflitam diretamente no container. Para isso, se usa a opção `-v`. Para fazer um bind similar com as portas locais e do container, a opção é `-p`.

Exemplo:

    docker run -d \ # roda o container em background (detach/daemonize)
        -v <<raiz local do projeto>>:/var/www \ # bind nas pastas
        -p <<porta local>>:80 \ # server roda na porta 80 por default
        -t konato/php7-beta # nome da imagem

#### Usar o container novamente
1. localizá-lo em `docker ps -a`
2. se não estiver ligado, ligar com `docker start <<id/name>>`

#### Entrar no shell (com o container ligado)
`docker exec -it <<id/name>> /bin/bash`

Atualizando a imagem
--------------------
1. [Editar o Dockerfile][dockerfile]
2. `docker build --tag konato/php7-beta .`
3. `docker push konato/php7-beta`

**Nota:** Caso crie-se uma imagem com uma configuração diferenciada mas que não substitua a anterior, é importante indicar uma tag específica, como `konato/php7-beta:apache`.


*TO-DO*
=======
- adicionar um script no projeto que crie o container do Docker (com artisan?)
- usar a imagem do projeto no lugar da imagem genérica do PHP7
- atualizar nome dos Dockerfiles



[docker]: http://www.docker.com
[slides]: https://denibertovic.com/talks/supercharge-development-env-using-docker
[europython]: https://youtu.be/-l9xH1X_rvg
[install]: http://docs.docker.com/linux/step_one/
[dockerfile]: https://docs.docker.com/reference/builder/
