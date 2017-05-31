create database if not exists blog_ecrivain character set utf8 collate utf8_unicode_ci;
use blog_ecrivain;

grant all privileges on blog_ecrivain.* to 'Forteroche'@'localhost' identified by 'Alaska';