drop table if exists billets;
drop table if exists users;
drop table if exists comments;

create table billets (
    billet_id integer not null primary key auto_increment,
    billet_title varchar(100) not null,
    billet_content text not null,
    billet_date datetime not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table users (
    user_id integer not null primary key auto_increment,
    user_name varchar(50) not null,
    user_password varchar(88) not null,
    user_salt varchar(23) not null,
    user_role varchar(50) not null 
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table comments (
    com_id integer not null primary key auto_increment,
    com_content varchar(500) not null,
    billet_id integer not null,
    user_id integer not null,
    constraint fk_com_billet foreign key(billet_id) references billets(billet_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;