# Tickets API — Laravel REST API

Готовый исходный проект REST API для системы поддержки тикетов на Laravel 12 и Sanctum.

## Требования

- PHP 8.2+
- Composer 2
- расширения PHP, необходимые Laravel (включая `pdo_sqlite` для конфигурации по умолчанию)

## Установка и запуск

1. Распакуйте архив.
2. В терминале перейдите в папку `tickets-api`.
3. Установите зависимости и создайте `.env`:

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

   В Windows PowerShell вместо `cp` можно выполнить:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Создайте SQLite-файл базы данных:

   ```bash
   # Linux/macOS
   touch database/database.sqlite
   # Windows PowerShell
   New-Item database/database.sqlite -ItemType File
   ```

5. Выполните миграции и запустите сервер:

   ```bash
   php artisan migrate
   php artisan serve --host=127.0.0.1 --port=8000
   ```

API будет доступен по адресу `http://127.0.0.1:8000/api`.

> Архив содержит исходники приложения и минимальные файлы конфигурации. Папка `vendor/` не включена: она устанавливается командой `composer install`. Если в вашей среде используется MySQL, поменяйте `DB_CONNECTION` и параметры `DB_*` в `.env`.

## API

Все запросы отправляйте с заголовками:

```http
Accept: application/json
Content-Type: application/json
```

Для защищённых маршрутов добавляйте:

```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

| Метод | Маршрут | Доступ |
|---|---|---|
| POST | `/api/register` | Без токена |
| POST | `/api/login` | Без токена |
| POST | `/api/logout` | С токеном |
| GET | `/api/tickets` | С токеном |
| POST | `/api/tickets` | С токеном |
| GET | `/api/tickets/{ticket}` | С токеном |
| PUT | `/api/tickets/{ticket}` | С токеном |
| DELETE | `/api/tickets/{ticket}` | С токеном |
| POST | `/api/tickets/{ticket}/comments` | С токеном |
| DELETE | `/api/tickets/{ticket}/comments/{comment}` | С токеном |

## Примеры

Регистрация `POST /api/register`:

```json
{
  "name": "Иван Петров",
  "email": "ivan@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

Создание тикета `POST /api/tickets`:

```json
{
  "title": "Не работает авторизация",
  "body": "При входе получаю ошибку 500."
}
```

Добавление комментария `POST /api/tickets/1/comments`:

```json
{
  "body": "Проверьте логи."
}
```

## Импорт запросов в Insomnia

Импортируйте файл `insomnia/insomnia.yaml` через Import/Export → Import Data → From File. Сначала выполните запрос регистрации или входа, затем скопируйте выданный токен в переменную `token` коллекции (Manage Environments).

## Важные детали

- Пользователь может читать, обновлять и удалять только собственные тикеты.
- Любой авторизованный пользователь может добавить комментарий к существующему тикету.
- Удалять комментарий может только его автор, и комментарий должен принадлежать указанному тикету.
- Удаление пользователя или тикета каскадно удаляет связанные записи.
- В ответах API ошибки валидации возвращаются в формате JSON со статусом `422`.

Перед сдачей выполните `php artisan route:list` и проверьте сценарии из задания. Архив не содержит `vendor/` и не заменяет проверку запуска в вашей локальной среде.
