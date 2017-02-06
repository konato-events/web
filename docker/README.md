Uso do Docker
=============

[Docker] é uma plataforma para isolamento do ambiente de desenvolvimento, de forma mais leve que a virtualização tradicional. Para detalhes, visite o site ou dê uma olhada [nessa apresentação][slides] ([vídeo][europython]).

Configurando o ambiente de dev
------------------------------

1. [Instale o Docker][install]: `wget -qO- https://get.docker.com/ | sh`
2. Baixe a imagem: `docker pull konato/php7-beta`

### Uso comum

#### Criar um container a partir da imagem
É possível fazer o *bind* de uma pasta local com uma pasta do container, de modo que as alterações de arquivos no *filesystem* da sua máquina se reflitam diretamente no container. Para isso, se usa a opção `-v`. Para fazer um bind similar com as portas locais e do container, a opção é `-p`.

Exemplo:

    docker run -d \ # roda o container em background (detach/daemonize)
        -v <<raiz local do projeto>>:/var/www \ # bind nas pastas (use `pwd`, não um path relativo!)
        -p 81:80 \ # HTTP do container vai rodar na 81 local
        -p 444:443 \ # HTTPS do container vai rodar na 444
        -p 5433:5432 \ # Postgre vai ficar na 5433
	    --name konato # nome do container a ser criado
        konato/project:dev # nome da imagem


#### Usar o container novamente
1. localizá-lo em `docker ps -a`
2. se não estiver ligado, ligar com `docker start <<id/name>>`

#### Entrar no shell (com o container ligado)
`docker exec -it <<id/name>> /bin/bash`

#### Atualizando a imagem
1. [Editar o Dockerfile][dockerfile]
2. `docker build --tag=konato/php7-beta --file=php7-beta.dockerfile`
3. `docker push konato/php7-beta`

**Nota:** Caso crie-se uma imagem com uma configuração diferenciada mas que não substitua a anterior, é importante indicar uma tag específica, como `konato/php7-beta:apache`.


Imagem de testes e produção
---------------------------

Além da imagem pura com o PHP7 + Nginx (`konato/php7-beta`), há também uma imagem pré-configurada para executar o projeto: `konato/project`. Seu Dockerfile é o `project.dockerfile`.

### Atualização / rebuild
Atualmente, para ter a versão mais atualizada do projeto dentro da imagem, é necessário fazer o re-build.

    docker build --tag=konato/project:latest --file=project.dockerfile .

### Executar
Com o comando seguinte o projeto estará disponível na porta `81` da máquina local:

    docker run -d -p 81:80 konato/project

### Imagem para desenvolvimento
A imagem do `project.dockerfile` é focada no ambiente de produção, copiando o source-code diretamente do GitHub para o container. Para desenvolvimento é recomendável usar o `project-dev.dockerfile` e fazer o bind das pastas do banco de dados e de código, conforme demonstrado no exemplo longo do `docker run`.


*TO-DO*
=======
- adicionar um script no projeto que crie o container de dev do Docker (o `docker run` ali em cima) (com artisan?)
- adicionar script (bash/php?) para atualizar o source do projeto dentro da imagem de produção, sem precisar fazer re-build da imagem (necessário?)


[docker]: http://www.docker.com
[slides]: https://denibertovic.com/talks/supercharge-development-env-using-docker
[europython]: https://youtu.be/-l9xH1X_rvg
[install]: http://docs.docker.com/linux/step_one/
[dockerfile]: https://docs.docker.com/reference/builder/
