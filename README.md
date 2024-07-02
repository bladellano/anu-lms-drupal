# Projeto Drupal com Anu LMS

Este projeto utiliza o módulo Anu LMS para criar um sistema de gerenciamento de aprendizado (LMS) em uma instalação Drupal.

## Visão Geral

Anu LMS é um módulo contribuído para Drupal que fornece funcionalidades robustas para a criação e gerenciamento de cursos online. Ele permite a criação de cursos, lições, questionários e muito mais, proporcionando uma plataforma completa de aprendizado online.
![vendas](./.docs/anulms-demo-content.png)  

## Requisitos

- Drupal 9.x ou superior
- Módulo Anu LMS

## Instalação

1. **Baixe e instale o Drupal**: Se ainda não tiver o Drupal instalado, siga as instruções na [documentação oficial do Drupal](https://www.drupal.org/docs/installing-drupal).
2. **Instale o módulo Anu LMS**:
    - Baixe o módulo Anu LMS do [repositório oficial](https://www.drupal.org/project/anu_lms).
    - Extraia o conteúdo na pasta `modules/contrib` do seu projeto Drupal.
    - Ative o módulo através da interface de administração do Drupal ou usando Drush:
      ```bash
      drush en anu_lms
      ```
3. **Configuração Inicial**:
    - Navegue até a página de configuração do Anu LMS em `/admin/config/anu_lms`.
    - Configure os parâmetros necessários de acordo com suas necessidades.

## Funcionalidades

- **Criação de Cursos**: Permite criar e gerenciar cursos, definindo detalhes como título, descrição, e instrutores.
- **Lições e Módulos**: Estruture o conteúdo em lições e módulos para uma melhor organização.
- **Questionários**: Crie questionários para avaliar o progresso dos alunos.
- **Certificados**: Gere certificados de conclusão para os alunos.

## Documentação Resumida

- Como criar um Curso [PDF](./.docs/como-criar-um-curso.pdf)

- Customizando ANU LMS [PDF](./.docs/como-criar-um-curso.pdf)

## Suporte

Para mais informações e suporte, visite a [página oficial do Anu LMS](https://www.drupal.org/docs/contributed-modules/anu-lms) ou a [seção de issues no Drupal.org](https://www.drupal.org/project/issues/anu_lms).
