drop table sjb747_building;

create table sjb747_building
(
adress 	varchar2(40),
architect_id int,
buyer_id int,
b_name	varchar2(30),
height 	int,
rooms 	int,
price 	varchar2(7),
primary key(adress)
);

drop table sjb747_architect;

create table sjb747_architect
(
architect_id int,
f_name varchar2(20),
l_name varchar2(20),
email varchar2(60),
primary key(architect_id)
);

drop table sjb747_buyer;

create table sjb747_buyer
(
buyer_id int,
f_name varchar2(20),
l_name varchar2(20),
email varchar2(60),
primary key(buyer_id)
);


insert into sjb747_building(
adress, b_name, architect_id,
height, rooms,
price)
values
('3000 street ave','WillyWolly',00001, 5, 50,'500+');

insert into sjb747_architect
values
(00001, 'Dale', 'Grible', 'truthfinder71@yahoo.com');
