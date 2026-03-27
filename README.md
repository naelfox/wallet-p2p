
Projeto de startup fintech 

Para rodar localmente sem Docker de forma simples, siga os passos abaixo:
1. Clone o repositório
2. Entre no back com `cd backend` e instale as dependências com `composer install`
3. Faça um `cp .env.example .env` 
4. Rode as migrations com `php artisan migrate`
5. Inicie o servidor com `php artisan serve`
6. Rode o `php artisan db:seed` ou para resetar e recriar o banco de dados `php artisan migrate:fresh --seed`
7. Saia da pasta do back com `cd ..` e entre no front com `cd front`
8. No front-end, instale as dependências com `npm install` e inicie o servidor de desenvolvimento com `npm run dev`

Requisitos para sua máquina:
PHP 8.0 ou superior
MySQL 5.7 ou superior
Node.js 14 ou superior

Minhas decisões técnicas para o projeto:
Layered Architecture (Arquitetura em Camadas) 3-tier simplificação Clean Architecture simplificada totalmente escalável a longo prazo facil de entender e manter para qualquer desenvolvedor da equipe.

-> Controller
recebe request
chama service
retorna response
-> Service
regra de negócio
orquestra fluxo
garante consistência (transaction)
-> Model
acesso ao banco (Eloquent)

Testes:
Como o escopo do projeto é pequeno, optei por fazer testes unitários para os serviços, garantindo que a lógica de negócio esteja correta. Para isso, utilizei o PHPUnit, que é o framework de testes padrão do Laravel.

Outros pontos:
O projeto foi feito sem o uso de IA para refletir o meu pensamento nesse tipo de projeto e revisar bem e com conceitos aplicados em projetos anteriores, mas estou aberto a discutir como a IA poderia ser integrada para melhorar o processo de desenvolvimento ou a experiência do usuário. 

Parte mais critica do projeto foi a transação muitos devs nao entendem a importancia da atomicidade de operações principalmente em sistemas financeiros, onde eu sei que é critico falhar em metade das operações, e isso pode levar a inconsistências e perda de dinheiro. 

Inovações rápidas:
 Laravel pint e php stan 

 Questoes:
 - Colocar saldo no usuario cadastrado pelo endpoint de registro?
 