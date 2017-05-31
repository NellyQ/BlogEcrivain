drop table if exists billets;

create table billets (
billet_id integer not null primary key auto_increment,
billet_title varchar(100) not null,
billet_content text not null,
billet_date datetime not null
) engine=innodb character set utf8 collate utf8_unicode_ci;