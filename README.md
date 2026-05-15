# 📌 Contact Score Processing

Este projeto implementa o fluxo de **processamento de score de contatos** seguindo princípios de **DDD** e **Arquitetura Limpa**.

---

## 🚀 Fluxo de Negócio

1. **Endpoint de gatilho**  
   `POST /api/contacts/{id}/process-score`  
   - Enfileira o processamento do contato.

2. **Processamento assíncrono (Job)**  
   - O status do contato muda para `processing`.  
   - O cálculo do score é feito por um **Domain Service** (`ScoreCalculator`).  
   - Após o cálculo, o status muda para `active` ou `failed`.  
   - O campo `processed_at` é preenchido.  
   - O evento de domínio `ContactScoreProcessed` é disparado.

3. **Reação ao evento**  
   - **Log**: Listener grava em `storage/logs/contact.log`.  
   - **Broadcast**: Evento é transmitido via **Laravel Reverb** no canal `contacts.{id}`.

---

## 🏗️ Arquitetura

- **Domain Layer**  
  - Entidades ricas (`Contact`)  
  - Value Objects (`Email`, `Phone`, `Status`)  
  - Regras de negócio isoladas (`ScoreCalculator`)

- **Application Layer**  
  - Use Cases (`CalculateScoreUseCase`)  
  - Orquestração do fluxo

- **Infrastructure Layer**  
  - Controllers  
  - Jobs (`ProcessContactScoreJob`)  
  - Events (`ContactScoreProcessed`)  
  - Listeners (`LogContactScoreProcessed`)  
  - Repositórios Eloquent  
  - Form Requests (`ProcessContactScoreRequest`)  
  - API Resources (`ContactResource`)

- **Inversão de Dependência**  
  - Interfaces (`ContactRepositoryInterface`)  
  - Configuração no Service Container

---

## ⚙️ Configuração

### Logging
No `config/logging.php`:

```php
'channels' => [
    'contact' => [
        'driver' => 'single',
        'path' => storage_path('logs/contact.log'),
        'level' => 'info',
    ],
],
<<<<<<< HEAD

=======
```
No `Listener`

```php
Log::channel('contact')->info('Contact processed', [...]);
```
### Queue & Broadcast

No `.env.example
```
QUEUE_CONNECTION=redis
BROADCAST_DRIVER=reverb
```
## Exemplo de Frontend

```
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Escuta de Contact Score</title>
  <script src="https://unpkg.com/@laravel/reverb-js"></script>
</head>
<body>
  <h1>Escutando atualização de contato</h1>
  <div id="output"></div>

  <script>
    const reverb = new Reverb({
      host: "http://localhost:8080", // ajuste conforme sua configuração
      key: "app-key",                // chave definida no servidor
    });

    const contactId = 1; // exemplo
    reverb.subscribe(`contacts.${contactId}`)
      .listen("ContactScoreProcessed", (event) => {
        document.getElementById("output").innerText =
          `Contato atualizado: ID=${event.id}, Score=${event.score}, Status=${event.status}`;
      });
  </script>
</body>
</html>
```
## 🧪 Como executar em ambiente de teste

1. **Instale dependências:**
   ```bash
   composer install
   npm install

2. **Rode as migrations:**
   ```bash
   php artisan migrate

3. **Inicie fila e servidor**
 ```bash
    php artisan queue:work
    php artisan serve
```
4. **Inicie fila e servidor**
    ```bash
       php artisan test

   




>>>>>>> bf70030f0dfde1d700a80bd70bcbfdd333d9e442
