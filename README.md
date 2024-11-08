# Myfome Especificação

# Escopo

Se trata de um sistema de catalogo para comercios do ramo de comidas (restaurantes, lanchonetes, churrascarias e etc.). O sistema deve disponibilizar a visualização dos produtos ofertados por determinada loja e também o perfil da loja em si contendo seus produtos. Poderá existir funcionalidade de venda através do próprio sistema, porém a priori a finalização do pedido será realizado no WhatsApp.

## Tecnologias

- Backend: PHP, Composer, Laravel, Sanctum, Docker (Sail), PHPUnit, Cloudinary Driver;
- Mobile: Dart, Flutter;
- Colaboração: Git, Github, Notion, Figma, LucidChart, Google Docs;

# **Definição do Processo e Ciclo de Vida do Desenvolvimento**

O Processo que será utilizado para o desenvolvimento do Sistema de catalogo de comidas, será uma mescla dos seguintes modelos de ciclo de vida de software: **iterativo** e **incremental**. Visto que o sistema pode iniciar com a prova de conceito e em cada iteração sofrer incrementos trazendo novas funcionalidades.

## Etapas e atividades

- Planejamento: Definimos o escopo, requisitos (funcionais e não funcionais), design prévio, papeis e diagramas prévios;
- Desenvolvimento: Os requisitos sendo implementados com uma certa regra de negócio e padrão especificado, além dos testes unitários;
- Testes: Testes de integração e inspeção do que foi desenvolvido;
- Entrega: Quando todos os requisitos da iteração forem desenvolvidos e devidamente testados, esses incrementos serão implantados através de alguma ferramenta de automação e colaboração;

## Papéis e responsabilidades

- Dono do produto: Welen;
- Design: Lazáro;
- Desenvolvedor e testador backend: Welen;
- Desenvolvedor e testador mobile: Lazáro;
- DBA:  Lazáro;
- DevOps: Welen;

## Artefatos de entrada e saída

Os principais artefatos são:

- Texto do escopo geral e do escopo de cada iteração;
- requisitos extraídos desses escopos;
- Design UI seguindo os requisitos;
- Diagrama de Banco de dados seguindo os requisitos;
- Código e seus testes seguindo os requisitos;

# **Gestão de Mudanças e Evolução do Projeto**

Caso haja algum pedido de mudança ou alteração, as pessoas em seus respectivos papéis irão verificar a necessidade, onde aprovado, será planejado e implementado durante a próxima iteração.

Estamos usando o Git juntamente com Issues + Github Project.

# Prova de conceito

Para essa prova de conceito, foi criado um escopo onde define o principal do projeto (lojas, produtos e a visualização de ambos).

## Backend

Foi utilizado o Framework Laravel com Composer, Sanctum, PHPUnit, Cloudinary driver e Sail (Docker);

# Links

Design: 

[https://www.figma.com/design/x0YCiQb1Mw3cDUZDhLvzZQ/ConstruSam--Ecommerce-Mobile-App-UI-Kit?node-id=221-117&t=nCuCcgCoKOfqoAtf-1](https://www.figma.com/design/x0YCiQb1Mw3cDUZDhLvzZQ/ConstruSam--Ecommerce-Mobile-App-UI-Kit?node-id=221-117&t=nCuCcgCoKOfqoAtf-1)

Diagrama BD: 

[https://lucid.app/lucidchart/4d551019-d844-4656-9d83-b64220cba89b/edit?viewport_loc=-9519%2C-2335%2C7340%2C3238%2C0_0&invitationId=inv_be648806-80a3-4784-9230-c4d359dcd47b](https://lucid.app/lucidchart/4d551019-d844-4656-9d83-b64220cba89b/edit?viewport_loc=-9519%2C-2335%2C7340%2C3238%2C0_0&invitationId=inv_be648806-80a3-4784-9230-c4d359dcd47b)
