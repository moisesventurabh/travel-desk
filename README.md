
## 📌 Sobre o Projeto

O **Travel Desk** é uma aplicação Full Stack para gestão de viagens corporativas, permitindo:

- Solicitação de viagens
- Aprovação e cancelamento com regras de negócio
- Monitoramento completo do fluxo
- Notificações automáticas por e-mail (Mailtrap)

---

## 🧱 Arquitetura

```txt
/travel-desk
│
├── 🧠 backend/              
│   (Laravel 11 + PHP 8.3 | API REST)
│
├── 🎨 frontend/             
│   (Vue 3 + Vite | Node.js 20-alpine)
│
├── 🌐 nginx/                
│   (Nginx Alpine - Proxy Reverso)
│
├── 🗄️ database/            
│   (MySQL 8.0)
│
├── 🐳 docker/              
│   (Dockerfiles + configs)
│
└── ⚙️ docker-compose.yml   
    (Orquestração)
````

# 📖 Guia de Uso

O fluxo do **Travel Desk** foi projetado para garantir controle, rastreabilidade e segurança na gestão de viagens corporativas.

---

## 🔐 Acesso ao Sistema

* Acesse a aplicação via navegador
* Realize login com suas credenciais
* Autenticação baseada em **JWT**

👉 Usuários autenticados são redirecionados automaticamente para o **Dashboard**

---

## 👤 Fluxo do Usuário (Solicitante)

Responsável por criar e acompanhar suas próprias solicitações.

### ✈️ Solicitar viagem

* Acesse: **Viagens → Nova Solicitação**
* Informe:

  * Origem
  * Destino
  * Datas

---

### 📊 Acompanhar solicitações

* Visualização restrita às próprias viagens
* Status inicial: `solicitado`

---

### 📧 Notificações

* Recebimento automático de e-mails ao:

  * Aprovar
  * Cancelar
* Envio realizado via Mailtrap

---

## 👨‍💼 Fluxo do Administrador (Aprovador)

Responsável pela gestão e decisão das solicitações.

### 📋 Gestão de demandas

* Visualiza **todas as viagens**
* Acesso ao Dashboard e listagem completa

---

### 🔍 Análise

* Filtros para identificar solicitações pendentes
* Visão consolidada do sistema

---

### ⚙️ Atualização de status

1. Acessar a viagem
2. Selecionar:

   * `aprovado` ou `cancelado`
3. Adicionar observação
4. Confirmar ação

📌 O sistema:

* Valida a operação
* Dispara notificação automática

---

## 🛡️ Regras de Interface e Segurança

* 🔒 **Controle de acesso**

  * Usuários comuns não acessam rotas administrativas
  * Tentativas indevidas retornam **403 (Acesso Negado)**

* 📌 **Imutabilidade**

  * Viagens `aprovadas` não podem ser alteradas

* 🔐 **Isolamento de dados**

  * Usuários visualizam apenas suas próprias solicitações


---

## 🛠️ Setup

### 1. Clonar o projeto

```bash
git clone <repo-url>
cd travel-desk
```

### 2. Configurar ambiente

```bash
cp backend/.env.example backend/.env
```

Configurações principais:

* `DB_HOST=db`
* `MAIL_HOST=sandbox.smtp.mailtrap.io`
* `JWT_SECRET` → gerar via artisan

---

### 3. Subir containers

```bash
docker-compose up -d --build
```

---

## ▶️ Execução

### Backend

```bash
docker exec -it travel-api bash

composer install

//Inicia o projeto - Atencao ao .env
docker exec -it travel-api composer install
docker exec -it travel-api php artisan key:generate

//Token da API JWT para login no VUE
docker exec -it travel-api php artisan jwt:secret

docker exec -it travel-api php artisan config:clear

//Cria o banco de dados, insere os usuário com Seeder e cria viagens falsas com Factory
docker exec -it travel-api php artisan migrate --seed

usuários padrao:
admin@test.com | senha123
user@test.com  | senha123


```

---

### Frontend

```bash
cd frontend

npm install
npm run dev
```

Acesse:

* Frontend: [http://localhost:5173](http://localhost:5173)
* Backend: [http://localhost:8000](http://localhost:8000)
* Observe os endereços do seu ambiente
---

## 🧪 Testes

```bash
docker exec travel-api php artisan test
```

### Cobertura

* ✔ Regras de negócio (Services)
* ✔ Disparo de e-mails
* ✔ Autenticação e permissões
* ✔ Endpoints da API

---

## 🔌 API

### 🔐 Autenticação

```http
Authorization: Bearer {token}
Content-Type: application/json
```

---

### 📍 Endpoints principais

| Método | Endpoint                   | Descrição        |
| ------ | -------------------------- | ---------------- |
| GET    | /admin/viagens             | Listar viagens   |
| POST   | /admin/viagens             | Criar viagem     |
| GET    | /admin/viagens/{id}        | Detalhes         |
| PATCH  | /admin/viagens/{id}/status | Atualizar status |

---

### 📦 Exemplo de requisição

```http
PATCH /admin/viagens/5/status
```

```json
{
  "status": "aprovado",
  "observacao": "Aprovado pelo gestor"
}
```

---

## 🛡️ Regras de Negócio

* ❌ Não é permitido alterar viagens aprovadas
* 📧 Notificações apenas em eventos críticos
* 🔐 Isolamento de dados por usuário
* 👨‍💼 Controle de acesso por roles (Admin/User)

---

## 🎨 Design

Interface baseada em tema **Dark Premium**
(Oxford Blue + Navy), com foco em:

* Usabilidade
* Clareza de informação
* Experiência corporativa

---

## 📄 Licença

Este projeto é de uso privado para fins educacionais e profissionais.

---

