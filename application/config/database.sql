Create table tw_users(
id int primary key auto_increment,
username varchar(200) unique,
email varchar(200) not null,
password varchar(200) not null,
facebookId varchar(200),
first int not null
);

create table tw_village(
villageId int PRIMARY KEY AUTO_INCREMENT,
userId int,
gold int,
mainBuilding int,
cazarma int,
ferma int,
mina int,
guvern int,
targ int,
zid int,
type int,
mineWorkers int not null,
x int,
y int
)

create table tw_log_units(
id int PRIMARY KEY AUTO_INCREMENT,
numberOf int,
villageId int,
userId int,
timestamp Date,
unitName varchar(200)
)


create table tw_units(
villageId int,
Alchemist int,
BeastMaster int,
Earthshaker int,
Kunkka int,
Legion_Commander int,
Tiny int,
Treant_Protector int
)

create table tw_stats(
timestamp date,
workers int,
villageId int
)


create table tw_log_attack(
villageId int,
Barbar int,
Wise int,
Mage int,
Alchemist int,
BeastMaster int,
Earthshaker int,
Kunkka int,
Legion_Commander int,
Tiny int,
Treant_Protector int,
timestamp Date,
x int,
y int
)


create table tw_log_buildings(
id int primary key auto_increment,
villageId int,
userId int,
timestamp date,
type int,
buildingName varchar(200)
);