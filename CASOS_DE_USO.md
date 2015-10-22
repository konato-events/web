Principais casos de uso do sistema, compilados
==============================================

Os casos de uso descritos abaixo servem como um compilado de ações que o usuário pode tomar, percorrendo todas as telas do sistema de forma lógica e fluida. As telas acessadas são indicadas em `{chaves}`.

Casos de uso principais
-----------------------

### 1. Novo usuário em busca de eventos

> **Casos possíveis:** indicação de amigos para buscar eventos no site, seja por link direto ou pelo perfil da rede social.

0. Usuário abre o site na página inicial `{1.0}`
0. Usuário avalia as proposições do sistema
0. Usuário segue a *call-to-action* e faz uma busca por um tema
0. Sistema carrega os resultados da busca `{1.1}`
0. Usuário inicia navegação por:
    0. Eventos: **caso de uso #2**
    0. Temas
        0. Usuário acessa a página de um tema `{1.3}`
        0. Sistema carrega os detalhes sobre o tema
        0. Usuário continua a navegação por:
            0. Evento: continuar o fluxo a partir do ponto anterior
            0. Palestrante
                0. Usuário acessa o perfil do palestrante `{1.5.2}`
                0. Após conferir os dados do palestrante, usuário decide salvá-lo sendo "seguidor"
                0. **sub-caso de uso #1**
            0. Acompanhar o tema
                0. Usuário decide salvar o tema sendo "seguidor"
                0. **sub-caso de uso #1**

### 2. Novo usuário buscando informações sobre um evento

> **Casos possíveis:** divulgação de link direto em rede social ou e-mail, por amigos ou pela organização do evento; resultado de mecanismo de busca.

0. Usuário acessa a página de um evento `{1.4}`
0. Sistema carrega os detalhes do evento
0. Após verificar os detalhes do evento, usuário decide salvá-lo sendo "participante"
0. Usuário acessa a página de histórico do evento `{1.4.1}`
0. Sistema exibe listagem de edições anteriores, com estatísticas básicas sobre cada uma delas
0. Usuário prossegue a navegação acessando uma das edições anteriores
0. Sistema carrega os detalhes do evento anterior, no mesmo formato de tela do evento atual
0. **sub-caso de uso #1**

### 3. Usuário existente buscando configuração do sistema

> **Casos possíveis:** Usuário já cadastrado, acessando o link de configurações existente no email; usuário navegando pelo sistema, e decide alterar suas configurações.

O usuário acessa a página de configurações e decide pelos seguintes fluxos:

0. Configuração de Temas `{1.6.2}`
    0. Sistema carrega a lista de temas que o usuário acompanha ("segue")
    0. Usuário altera configuração de um tema
    0. Sistema salva automaticamente a alteração
0. Administração de Conexões
    0. Usuário acessa a página de Conexões `{1.6.4}`
    0. Sistema carrega a lista de novas conexões pendentes (se existir) e a lista de conexões existentes
    0. Usuário decide por um dos fluxos:
        0. Visita o perfil de uma das conexões `{1.6.5}`
            0. Caso seja uma conexão pendente, as informações do perfil podem ser limitadas
            0. Caso seja uma conexão já confirmada, ele poderá verificar informações sobre as participações em eventos e interesses do usuário em questão
        0. Aceita uma nova conexão
            0. Sistema salva a operação e recarrega a página, com a nova conexão na lista
        0. Recusa uma nova conexão ou remove uma conexão existente
            0. Sistema recarrega a página, sem o convite/conexão na lista

### 4. Usuário existente, durante o evento

> **Casos possíveis:** durante o evento, o usuário pode consultar o site rapidamente no seu celular para adicionar um novo contato que fez lá, visualizar a programação do evento, ou visualizar detalhes / seguir um palestrante em especial.

**Nota:** a implementação completa deste caso de uso foi adiada por estar fora do escopo do projeto de TCC. No entanto, o sistema ainda pode ser utilizado de forma plena em dispositivos móveis, possibilitando percorrer os passos abaixo de forma simplificada.

0. Usuário carrega o aplicativo web no seu celular - ou abre o aplicativo já pré-instalado
0. Usuário decide por um dos fluxos, não-excludentes:    
    0. Usuário acessa a página do evento `{1.4}`
        0. Sistema carrega, em versão responsiva para o dispositivo, os dados do evento
        0. Usuário verifica os detalhes da grade de programação
    0. Usuário efetua uma busca pelo nome do contato/palestrante no topo da página
        0. Sistema carrega a lista de resultados, relacionando as pessoas correspondentes
        0. Usuário acessa o perfil do novo contato/palestrante
        0. Sistema exibe os detalhes sobre o perfil em questão
        0. Usuário decide adicionar o contato, ou seguir o palestrante
        0. Sistema verifica se o usuário está logado
            0. Caso esteja, efetua a ação e retorna feedback imediato
            0. Caso não esteja, pede para que o usuário se logue ou se cadastre (**sub-caso de uso #1**)

### 5. Usuário existente, após o evento

> **Casos possíveis:** no pós-evento, o usuário retornaria à página do evento para adicionar novos contatos e seguir tópicos ou palestrantes. No caso dele não conhecer o sistema anteriormente, o **caso de uso #2** se aplicaria.

Este caso de uso é similar aos casos #2 e #4 - neste, podendo ser efetuado de um computador também.

Casos de uso secundários
------------------------

Aqui estão listados casos de uso que são incluídos em outros, e que não ocorrem sozinhos no sistema de forma natural.
            
### 1. Cadastro a partir de *call-to-action*

> **Casos possíveis:** usuário é levado à tela de cadastro ao tentar efetuar uma operação que exige autenticação.

0. O usuário ativa alguma operação que exige autenticação
0. O sistema notifica o usuário de que é necessário estar cadastrado e logado para efetuar aquela operação
0. O usuário decide se cadastrar
0. O sistema armazena a página onde a operação foi requisitada
0. O sistema carrega a página de cadastro
0. Usuário preenche o formulário e efetua o cadastro no sistema
0. Sistema retorna o usuário para a tela armazenada anteriormente, já com a operação requisitada efetivada

Lista das telas do sistema
==========================

- **1.0.** Home
- **1.1.** Resultados de busca
- **1.2.** Listagem por lugares - *esta tela foi adiada por ser principalmente de cunho estatístico, necessitando de alto volume de dados para ter algum fim prático*
- **1.3.** Detalhes de tema
- **1.4.** Detalhes de evento
    - **1.4.1.** Edições do evento
- **1.5.** Listagem de palestrantes
    - **1.5.1.** Palestrantes dentro de um tema
    - **1.5.2.** Perfil de palestrante
- **1.6.** Perfil de usuário
    - **1.6.1.** Dashboard
    - **1.6.2.** Preferências de temas
    - **1.6.3.** Notificações
    - **1.6.4.** Lista de conexões
    - **1.6.5.** Perfil de uma conexão