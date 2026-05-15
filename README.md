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

