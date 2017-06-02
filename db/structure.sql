drop table if exists billets;
drop table if exists comments;

create table billets (
    billet_id integer not null primary key auto_increment,
    billet_title varchar(100) not null,
    billet_content text not null,
    billet_date datetime not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table comments (
    com_id integer not null primary key auto_increment,
    com_author varchar(100) not null,
    com_content varchar(500) not null,
    billet_id integer not null,
    constraint fk_com_art foreign key(billet_id) references billets(billet_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;