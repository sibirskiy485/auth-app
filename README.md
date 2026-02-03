Структура проекта

tz/
├── config/
│   └── db.php
│
├── includes/
│   ├── session.php
│   ├── functions.php
│   └── smartcaptcha.php
│
├── handlers/
│   ├── login_handler.php
│   ├── register_handler.php
│   └── profile_handler.php
│
├── pages/
│   ├── home.php
│   ├── login.php
│   ├── register.php
│   ├── profile.php
│   └── logout.php
│
├── templates/
│   ├── login_form.php
│   └── user_form.php
│
├── logs/
│   └── captcha.log
│
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── assets/
│       └── css/
│           └── style.css
│
└── README.md

pages/ — страницы приложения
templates/ — HTML-шаблоны форм
handlers/ — обработчики POST-запросов
includes/ — общие функции
config/ — конфигурация приложения
public/ — публичная часть проекта
logs/ — логи приложения