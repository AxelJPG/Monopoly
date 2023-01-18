-- Active: 1668744166056@@127.0.0.1@3306@banck_monopoly

drop table if exists players;
drop table if exists transf_set;
drop table if exists transf_get;
drop table if exists propertys;
drop table if exists utilities;

create table players (
  id int primary key auto_increment not null,
  name varchar(50) not null,
  color varchar(50) not null,
  monto int not null
);

create table transf_set (
  id int,
  recive varchar(50),
  transferMonto int,
  time_transfers datetime default null
);

create table transf_get (
  id int,
  recive varchar(50),
  transferMonto int,
  time_transfers datetime default null
);

create table propertys (
  id int primary key auto_increment not null,
  nombre_player varchar(100) not null,
  nombre varchar(100) not null,
  color varchar(50) not null,

  precio int not null,
  precioP int not null,

  alquiler int not null,

  alquiler1 int not null,
  alquiler2 int not null,
  alquiler3 int not null,
  alquiler4 int not null,
  alquilerH int not null,

  status_hipoteca boolean not null,
  hipoteca int not null,

  NroC  int not null,
  NroH  int not null
);

create table utilities (
  id int primary key auto_increment not null,
  nombre_player varchar(100) not null,
  nombre varchar(100) not null,
  precio int not null,

  hipoteca int not null,
  status_hipoteca boolean not null,

  precio2 int not null,
  precio3 int not null,
  precio4 int not null
);

insert into utilities values (null, 'Bank', 'Ferrocarril Reading', 25, 100, false, 50, 100, 200),
                             (null, 'Bank', 'Ferrocarril De Pensilvania', 25, 100, false, 50, 100, 200),
                             (null, 'Bank', 'Ferrocarril B & O', 25, 100, false, 50, 100, 200),
                             (null, 'Bank', 'Ferrocarril ShortLine', 25, 100, false, 50, 100, 200),
                             (null, 'Bank', 'Electricidad', 150, 75, false, 0, 0, 0),
                             (null, 'Bank', 'Agua', 150, 75, false, 0, 0, 0);


insert into propertys values (null, 'Banck', 'Ave. Mediterraneo', "#5E3E89", 60, 50, 2, 10, 30, 90, 160, 250, false, 30, 0, 0),
                             (null, 'Banck', 'Ave. Baltica', "#5E3E89", 60, 50, 4, 20, 60, 180, 320, 450, false, 30, 0, 0),
                             ----------------------------------------------------------------------------------------------------->,
                             (null, 'Banck', 'Ave. Oriental', "#AED8E4", 100, 50, 6, 30, 90, 270, 400, 550, false, 50, 0, 0),
                             (null, 'Banck', 'Ave. Vermont', "#AED8E4", 100, 50, 6, 30, 90, 270, 400, 550, false, 50, 0, 0),
                             (null, 'Banck', 'Ave. Connecticut', "#AED8E4", 120, 50, 8, 60, 100, 300, 450, 600, false, 60, 0, 0),
                             ----------------------------------------------------------------------------------------------------->,
                             (null, 'Banck', 'Plaza San Carlo', "#B24E91", 140, 100, 10, 50, 150, 450, 625, 750, false, 70, 0, 0),
                             (null, 'Banck', 'Ave. De Los Estados', "#B24E91", 140, 100, 10, 50, 150, 450, 625, 750, false, 70, 0, 0),
                             (null, 'Banck', 'Ave. Virginia', "#B24E91", 160, 100, 12, 60, 180, 500, 700, 900, false, 80, 0, 0),
                             ----------------------------------------------------------------------------------------------------->,
                             (null, 'Banck', 'Plaza Santiago', "#F29B4E", 180, 100, 14, 70, 200, 550, 750, 950, false, 90, 0, 0),
                             (null, 'Banck', 'Plaza Tennessee', "#F29B4E", 180, 100, 14, 70, 200, 550, 750, 950, false, 90, 0, 0),
                             (null, 'Banck', 'Plaza New York', "#F29B4E", 200, 100, 16, 80, 220, 600, 800, 1000, false, 100, 0, 0),
                             ----------------------------------------------------------------------------------------------------->,
                             (null, 'Banck', 'Ave. Kentucky', "#FA363D", 220, 150, 18, 90, 250, 700, 875, 1050, false, 110, 0, 0),
                             (null, 'Banck', 'Ave. Indiana', "#FA363D", 220, 150, 18, 90, 250, 700, 875, 1050, false, 110, 0, 0),
                             (null, 'Banck', 'Ave. Illinois', "#FA363D", 240, 150, 20, 100, 300, 750, 925, 1100, false, 120, 0, 0),
                             ----------------------------------------------------------------------------------------------------->,
                             (null, 'Banck', 'Ave. Atlantico', "#F8E042", 260, 150, 22, 110, 330, 800, 975, 1150, false, 130, 0, 0),
                             (null, 'Banck', 'Ave. Ventnor', "#F8E042", 260, 150, 22, 110, 330, 800, 975, 1150, false, 130, 0, 0),
                             (null, 'Banck', 'Jardines Marvin', "#F8E042", 280, 150, 22, 120, 360, 850, 1025, 1200, false, 140, 0, 0),
                             ----------------------------------------------------------------------------------------------------->,
                             (null, 'Banck', 'Ave. Pacifica', "#42C253", 300, 200, 26, 130, 390, 900, 1100, 1275, false, 150, 0, 0),
                             (null, 'Banck', 'Ave. Carolina Del Nort', "#42C253", 300, 200, 26, 130, 390, 900, 1100, 1275, false, 150, 0, 0),
                             (null, 'Banck', 'Ave. Pensilvania', "#42C253", 320, 200, 28, 150, 450, 1000, 1200, 1400, false, 160, 0, 0),
                             ----------------------------------------------------------------------------------------------------->,
                             (null, 'Banck', 'Plaza Del Parque', "#4785F2", 350, 200, 35, 175, 500, 1100, 1300, 1500, false, 175, 0, 0),
                             (null, 'Banck', 'Paseo Tablado', "#4785F2", 400, 200, 50, 200, 600, 1400, 1700, 2000, false, 200, 0, 0);
