# Myfome Especificação

# Escopo

O MyFome se trata de um sistema de catálogo virtual de produtos do ramo alimentício, introduzido para fins comerciais. O sistema deve disponibilizar a visualização dos produtos ofertados por determinada loja e também o perfil da loja em si contendo seus produtos. Poderá existir funcionalidade de venda através do próprio sistema, porém a priori a finalização do pedido será realizado no WhatsApp.

## Tecnologias

- Backend: PHP, Composer, Laravel, Sanctum, Docker (Sail), PHPUnit, Cloudinary Driver;
- Mobile: Dart, Flutter;
- Colaboração: Git, Github, Notion, Figma, LucidChart, Google Docs;

# **Definição do Processo e Ciclo de Vida do Desenvolvimento**

O desenvolvimento do sistema de catálogo de comidas seguirá um modelo de ciclo de vida **iterativo** e **incremental**, começando com uma prova de conceito e recebendo incrementos a cada iteração com novas funcionalidades.

## Etapas e atividades

- Planejamento:  Definição do escopo, requisitos (funcionais e não funcionais), design preliminar, papéis e diagramas iniciais.
- Desenvolvimento: Implementação dos requisitos conforme as regras de negócio e padrões especificados, além de testes unitários.
- Testes: Realização de testes de integração e inspeção do que foi desenvolvido.
- Entrega: Implantação dos incrementos desenvolvidos e testados, utilizando ferramentas de automação e colaboração.

## Papéis e responsabilidades

- Dono do produto: Welen;
- Design: Lázaro;
- Desenvolvedor e testador backend: Welen;
- Desenvolvedor e testador mobile: Lázaro;
- DBA:  Lázaro;
- DevOps: Welen;

## Artefatos de entrada e saída

Os principais artefatos são:

- Texto do escopo geral e do escopo de cada iteração;
- requisitos extraídos desses escopos;
- Design UI seguindo os requisitos;
- Diagrama de Banco de dados seguindo os requisitos;
- Código e seus testes seguindo os requisitos;

# **Gestão de Mudanças e Evolução do Projeto**

Caso haja algum pedido de mudança ou alteração, as pessoas em seus respectivos papéis irão verificar a necessidade. Se aprovado, será planejado e implementado na próxima iteração.
O controle de mudanças será feito usando Git juntamente com Issues e GitHub Project.

# Prova de conceito

Para essa prova de conceito, foi criado um escopo que define o principal do projeto (lojas, produtos e a visualização de ambos).

## Backend

Foi utilizado o Framework Laravel com Composer, Sanctum, PHPUnit, Cloudinary driver e Sail (Docker);

# Links

Design: 

[https://www.figma.com/design/x0YCiQb1Mw3cDUZDhLvzZQ/ConstruSam--Ecommerce-Mobile-App-UI-Kit?node-id=221-117&t=nCuCcgCoKOfqoAtf-1](https://www.figma.com/design/x0YCiQb1Mw3cDUZDhLvzZQ/ConstruSam--Ecommerce-Mobile-App-UI-Kit?node-id=221-117&t=nCuCcgCoKOfqoAtf-1)

Diagrama BD: 

[https://lucid.app/lucidchart/4d551019-d844-4656-9d83-b64220cba89b/edit?viewport_loc=-9519%2C-2335%2C7340%2C3238%2C0_0&invitationId=inv_be648806-80a3-4784-9230-c4d359dcd47b](https://lucid.app/lucidchart/4d551019-d844-4656-9d83-b64220cba89b/edit?viewport_loc=-9519%2C-2335%2C7340%2C3238%2C0_0&invitationId=inv_be648806-80a3-4784-9230-c4d359dcd47b)
