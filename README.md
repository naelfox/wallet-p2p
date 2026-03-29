
  

## Projeto de startup fintech

  

**Para rodar localmente sem Docker de forma simples, siga os passos abaixo:**

# 1. Clonar
git clone <repo>

# 2. Backend
cd backend
composer install
cp .env.example .env
php artisan migrate
php artisan serve

# (opcional)
php artisan db:seed
# ou reset total
php artisan migrate:fresh --seed

# 3. Frontend
cd ../front
npm install
npm run dev

  

**Requisitos para sua máquina:**

PHP 8.0 ou superior

MySQL 5.7 ou superior

Node.js 14 ou superior

  

**Minhas decisões técnicas para o projeto:**

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

  

**Testes:**

Como o escopo do projeto é pequeno, optei por fazer testes unitários para os serviços, garantindo que a lógica de negócio esteja correta. Para isso, utilizei o PHPUnit, que é o framework de testes padrão do Laravel.

  

**Outros pontos:**

O projeto foi feito sem o uso de IA para refletir o meu pensamento nesse tipo de projeto e revisar bem e com conceitos aplicados em projetos anteriores, mas estou aberto a discutir como a IA poderia ser integrada para melhorar o processo de desenvolvimento ou a experiência do usuário.

  


  

**Inovações rápidas:**

Laravel pint e php stan

  

****Questoes:****

- Colocar saldo no usuario cadastrado pelo endpoint de registro?

  

**Interpretações de requisitos e decisões**

  

Durante o desenvolvimento, alguns pontos do desafio exigiram interpretação de negócio:

  

- Cada transferência gera um registro no histórico para facilitar o rastreamento e a transparência das transações, e tbm filtros, eu achei melhor dessa forma.

- Transferências para a própria conta foram bloqueadas. No caso, considerei que não representa um caso de uso válido para o MVP.

- Interpretei o saldo inicial definido no Seeder como requisito de inicialização do ambiente. Na parte de registro pelo endpoint preferir utilizar a criação de uima conta com mil reais tbm para fins de testes e facilitação.

- Parte mais critica do projeto foi a transação muitos devs nao entendem a importancia da atomicidade de operações principalmente em sistemas financeiros, onde eu sei que é critico falhar em metade das operações, e isso pode levar a inconsistências e perda de dinheiro.

- utilização de centavvos para melhorar a precisão e evitar problemas de arredondamento comuns em operações financeiras. 

- O logout invalida o token atual do usuário.


**Coisas que acrecentaria se tivesse mais tempo:**

- lockForUpdate() no serviço de transferência para evitar caso o usuário tente realizar múltiplas transferências simultâneas que possam causar e quebrar o saldo.
- Caches para melhorar a performance do dashboard
- limitar transferências por minuto
- Detalhar mais a resposta da api talvez.