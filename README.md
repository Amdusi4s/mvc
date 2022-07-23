# MVC мини приложение

<p>Приложение написано с помощью паттерна проектирования MVC</p>

## Структура папки app:

```
1. controllers - список контроллеров
2. core - системные файлы запускающие проект (ядро)
3. models - модели
4. services - сервисы
5. libs - библиотеки
6. helper.php - отдельные функции используемые в проекте
```

## Структура папки assets:

```
1. AppAsset.php - класс подключения стилей для шаблона main
```

## Структура папки config:

```
1. app.php - конфигурационный файл настроек проекта
```

## Структура папки email:

```
1. register.php - почтовое представление используемое после регистрации пользователя
```

## Структура папки public:

```
1. assets - папка в которой находятся стили, скрипты, картинки проекта
2. index.php - единая точка входа в наше приложение
```

## Структура папки route:

```
1. web.php - список карты роутов для неавторизованных пользователей
```

## Структура папки sql:

```
1. mvc.sql - файл базы данных с дампом
```

## Структура папки views:

```
1. auth - представления связанные с входом и регистрацией
2. layouts - список шаблонов
3. _error.php - представление для вывода ошибок и исключений
4. home.php - представление для главной страницы проекта
```

## Остальные файлы:

```
1. .env - файл конфигов проекта
```

---------------------------------------
# Установка

### 1. Склонируйте текущий репозиторий с помощью команды

```
git clone https://github.com/amdusi4s/mvc.git
```

### 2. Установите менеджер зависимостей с помощью команды

```
composer install
```

### 3. Обновите менеджер зависимостей с помощью команды

```
composer update
```