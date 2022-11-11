# Создание сессии

```php
Пример создания сессии:
Application::$app->session->set($key, $value);
Пример создания временной сессии:
Application::$app->session->setFlash($key, $value);
```

1. $key - название сессии
2. $value - значение

```php
Пример возврата значения сессии:
Application::$app->session->get($key);
Пример возврата временной сессии:
Application::$app->session->getFlash($key);
```

1. $key - название сессии

```php
Пример удаления сессии:
Application::$app->session->remove($key);
```

1. $key - название сессии