Principais casos de uso do sistema, compilados
==============================================

Casos de uso principais
-----------------------

### 1. Novo usuário em busca de eventos

> **Casos possíveis:** indicação de amigos para buscar eventos no site, seja por link direto ou pelo perfil da rede social.

0. Usuário abre o site na página inicial
0. Usuário avalia as proposições do sistema
0. Usuário segue a *call-to-action* e faz uma busca por um tema
0. Sistema carrega os resultados da busca
0. Usuário inicia navegação por:
    1. Eventos: **caso de uso #2**
    2. Temas
        0. Usuário acessa a página de um tema
        0. Sistema carrega os detalhes sobre o tema
        0. Usuário continua a navegação por:
            1. Evento: continuar o fluxo a partir do ponto anterior
            2. Palestrante
                0. Usuário acessa o perfil do palestrante
                0. Após conferir os dados do palestrante, usuário decide salvá-lo sendo "seguidor"
                0. **sub-caso de uso #1**
            3. Acompanhar o tema
                0. Usuário decide salvar o tema sendo "seguidor"
                0. **sub-caso de uso #1**

### 2. Novo usuário buscando informações sobre um evento

> **Casos possíveis:** divulgação de link direto em rede social ou e-mail, por amigos ou pela organização do evento; resultado de mecanismo de busca.

0. Usuário acessa a página de um evento
0. Sistema carrega os detalhes do evento
0. Após verificar os detalhes do evento, usuário decide salvá-lo sendo "participante"
0. **sub-caso de uso #1**

### 3. Usuário existente buscando configuração do sistema

> **Casos possíveis:** Usuário já cadastrado, acessando o link de configurações existente no email

0. Usuário acessa a página de configurações e decide pelos seguintes fluxos:
    1. Configuração de Temas
        0. Sistema carrega a lista de temas que o usuário acompanha ("segue")
        0. Usuário altera configuração de um tema
        0. Sistema salva automaticamente a alteração
    2. Administração de Conexões
        0. Usuário acessa a página de Conexões
        0. Sistema carrega a lista de novas conexões pendentes (se existir) e a lista de conexões existentes
        0. Usuário decide por um dos fluxos:
            1. Aceita uma nova conexão
                0. Sistema salva a operação e recarrega a página, com a nova conexão na lista
            2. Recusa uma nova conexão ou remove uma conexão existente
                0. Sistema recarrega a página, sem o convite/conexão na lista

### 4. Usuário existente, durante ou após o evento

> **Casos possíveis:** no pós-evento, o usuário retorna à página do evento para adicionar novos contatos e seguir tópicos ou palestrantes

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