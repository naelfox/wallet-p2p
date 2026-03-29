# Projeto de startup fintech


Link do projeto https://wallet-p2p-1.onrender.com

O usuário principal é o email: `natanaelvila2@gmail.com` senha: `password`

na parte de registro você poderá criar outras contas para testar as transferências.
Para rodar localmente sem Docker de forma simples, siga os passos abaixo:



**1. Clonar**

git clone <repo>

  

2. **Backend**

cd backend

composer install

cp .env.example .env

php artisan migrate

php artisan serve

  

(opcional)

php artisan db:seed

ou reset total

php artisan migrate:fresh --seed

  

**3. Frontend**

cd ../front

npm install

npm run dev

  

  

**Minhas decisões técnicas para o projeto:**

Layered Architecture (Arquitetura em Camadas), modelo 3-tier, com uma simplificação da Clean Architecture, totalmente escalável a longo prazo e fácil de entender e manter por qualquer desenvolvedor da equipe.

  

→ Controller

  

Recebe a request

Chama o service

Retorna a response

  

→ Service

  

Regra de negócio

Orquestra o fluxo

Garante consistência (transaction)

  

→ Model

  
Acesso ao banco (Eloquent)

  

**Testes**:
Como o escopo do projeto é pequeno, optei por realizar testes unitários e de feature. Para isso, utilizei o PHPUnit, que é o framework de testes padrão do Laravel.

  

**Outros pontos:**
O projeto foi feito sem o uso de IA, para refletir o meu pensamento nesse tipo de projeto, além de permitir uma revisão mais cuidadosa, com conceitos aplicados em projetos anteriores. No entanto, estou aberto a discutir como a IA poderia ser integrada para melhorar o processo de desenvolvimento ou a experiência do usuário.

  
  

**Interpretações de requisitos e decisões**

Durante o desenvolvimento, alguns pontos do desafio exigiram interpretação de negócio:

- Cada transferência gera um registro no histórico para facilitar o rastreamento e a transparência das transações, bem como permitir filtros. Achei melhor dessa forma.

- Transferências para a própria conta foram bloqueadas. Nesse caso, considerei que não representa um caso de uso válido para o MVP.

- Diante da dúvida sobre adicionar ou não saldo inicial no endpoint de registro, assim como é feito no Seeder, interpretei o saldo inicial como parte da inicialização do ambiente. Ainda assim, optei por criar a conta com mil reais também no registro, para facilitar os testes.

- A parte mais crítica do projeto foi a transação. Muitos devs não entendem a importância da atomicidade de operações, principalmente em sistemas financeiros, onde é crítico falhar em metade das operações, pois isso pode levar a inconsistências e perda de dinheiro.

- Utilização de centavos para melhorar a precisão e evitar problemas de arredondamento comuns em operações financeiras.

- O logout invalida o token atual do usuário.

  

**Coisas que acrescentaria se tivesse mais tempo:**

- Uso de lockForUpdate() no serviço de transferência para evitar casos em que o usuário tente realizar múltiplas transferências simultâneas que possam comprometer o saldo.

- Cache para melhorar a performance do dashboard.

- Limitar transferências por minuto.

- Detalhar mais a resposta da API, talvez.