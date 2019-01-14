<?php

//Veritabani bağlantı ayarları
define("MYSQL_DATABASE", "example");
define("MYSQL_HOST", "example");
define("MYSQL_USER", "example");
define("MYSQL_PASSWORD", "example");

// Sanal pos ayarları
define("VPOS_MERCHANTID", "example");
define("VPOS_PASSWORD", "example");
define("VPOS_TERMINALNO", "example");
define("VPOS_POXURL", "example");

//  E-posta gönderim ayarları
define("MAIL_IS_SMTP", false);  // Boolean
//  SMTP true olacaksa aşağıdaki ayarlar önemlidir
define("MAIL_SMTP_AUTH", true); // Boolean
define("MAIL_SMTP_SERVER", "smtp.example.com");
define("MAIL_SMTP_PORT", 587);
define("MAIL_SMTP_SECURE", ""); // "tls", "ssl", "" olabilir
define("MAIL_SMTP_USER", "smtp@example.com");
define("MAIL_SMTP_PASS", "example");

define("MAIL_ADMINISTRATOR_EMAIL", "example@receiver.com");
define("MAIL_ADMINISTRATOR_FROM_EMAIL", "example@sender.com");
define("MAIL_ADMINISTRATOR_FROM_NAME", "LKD Bağış Sistemi");
define("MAIL_ADMINISTRATOR_SUBJECT", "Ödeme geldi");

define("MAIL_USER_SUBJECT", "Ödemeniz için teşekkürler");
define("MAIL_USER_FROM_EMAIL", "example@sender.com");
define("MAIL_USER_FROM_NAME", "Türkiye Linux Kullanıcıları Derneği");