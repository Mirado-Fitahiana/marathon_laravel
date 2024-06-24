CREATE SCHEMA IF NOT EXISTS "public";

CREATE  TABLE "public".categorie ( 
	id_categorie         serial  NOT NULL  ,
	nom_categorie        varchar    ,
	CONSTRAINT pk_categorie PRIMARY KEY ( id_categorie )
 );

CREATE  TABLE "public".etape ( 
	id_etape             serial  NOT NULL  ,
	nom_etape            varchar    ,
	nombre_coureur       integer    ,
	longueur             numeric    ,
	rang_etape           integer    ,
	CONSTRAINT pk_etape PRIMARY KEY ( id_etape )
 );

CREATE  TABLE "public".penalite ( 
	id_penalite          serial  NOT NULL  ,
	penalite             time    ,
	nom_penalite         varchar    ,
	CONSTRAINT pk_penalite PRIMARY KEY ( id_penalite )
 );

CREATE  TABLE "public".utilisateur ( 
	id_utilisateur       serial  NOT NULL  ,
	nom                  varchar    ,
	mail                 varchar    ,
	"password"           varchar    ,
	is_admin             integer DEFAULT 0   ,
	CONSTRAINT pk_utilisateur PRIMARY KEY ( id_utilisateur )
 );

CREATE  TABLE "public".coureur ( 
	id_coureur           serial  NOT NULL  ,
	nom_coureur          varchar    ,
	numero_dossard       varchar    ,
	genre                integer    ,
	date_naissance       date    ,
	fk_equipe            integer    ,
	CONSTRAINT pk_coureur PRIMARY KEY ( id_coureur ),
	CONSTRAINT fk_coureur_utilisateur FOREIGN KEY ( fk_equipe ) REFERENCES "public".utilisateur( id_utilisateur )   
 );

CREATE  TABLE "public".course_temps ( 
	id_course_temps      serial  NOT NULL  ,
	fk_etape             integer    ,
	fk_coureur           integer    ,
	debut                timestamp    ,
	fin                  timestamp    ,
	duree                interval    ,
	CONSTRAINT pk_course_temps PRIMARY KEY ( id_course_temps ),
	CONSTRAINT fk_course_temps_coureur FOREIGN KEY ( fk_coureur ) REFERENCES "public".coureur( id_coureur )   ,
	CONSTRAINT fk_course_temps_etape FOREIGN KEY ( fk_etape ) REFERENCES "public".etape( id_etape )   
 );

CREATE  TABLE "public".categorie_coureur ( 
	id_categorie_coureur serial  NOT NULL  ,
	fk_coureur           integer    ,
	fk_categorie         integer    ,
	CONSTRAINT pk_categorie_coureur PRIMARY KEY ( id_categorie_coureur ),
	CONSTRAINT fk_categorie_coureur_categorie FOREIGN KEY ( fk_categorie ) REFERENCES "public".categorie( id_categorie )   ,
	CONSTRAINT fk_categorie_coureur_coureur FOREIGN KEY ( fk_coureur ) REFERENCES "public".coureur( id_coureur )   
 );

CREATE  TABLE "public".classement ( 
	id_classement        serial  NOT NULL  ,
	fk_etape             integer    ,
	fk_coureur           integer    ,
	temps                interval    ,
	point                integer    ,
	rang                 integer    ,
	CONSTRAINT pk_classement PRIMARY KEY ( id_classement ),
	CONSTRAINT fk_classement_coureur FOREIGN KEY ( fk_coureur ) REFERENCES "public".coureur( id_coureur )   ,
	CONSTRAINT fk_classement_etape FOREIGN KEY ( fk_etape ) REFERENCES "public".etape( id_etape )   
 );


INSERT INTO "public".etape (nom_etape, nombre_coureur, longueur, rang_etape) VALUES
('Betsizaraina', 5, 42, 1),
('Ampasimbe',4, 21, 2);

insert into utilisateur values(default,'mazava','mazava@gmail.com','root',default);
insert into utilisateur values(default,'maizina','maizina@gmail.com','root',default);

INSERT INTO "public".coureur (nom_coureur, numero_dossard, genre, date_naissance, fk_equipe) VALUES
('Jean de La Croix', 101,1, '1999-01-01', 2),
('Mirado', 102, 1, '2002-02-02', 2),
('Oni', 103, 2, '2001-03-03', 2),
('Mahery', 104, 1, '2003-04-04', 2),
('Dania', 105, 1, '2004-05-05', 2),

('Isabelle', 201,2 , '2000-06-06', 3),
('Fy', 202, 2, '2002-07-07', 3),
('Idealisoa', 203, 2, '2001-08-08', 3),
('DM', 204, 1, '2003-09-09', 3),
('Maroussia', 205, 2, '2004-10-10', 3);

-- ('Yohan', 301, 1, '2000-11-11', 3),
-- ('Andréa', 302, 2, '2002-12-12', 3),
-- ('Tiavina', 303, 2, '2001-01-01', 3),
-- ('Ralph', 304, 1, '2003-02-02', 3),
-- ('Rebecca', 305, 2, '2004-03-03', 3);

insert into categorie values(default,'homme'),(default,'femme'),(default,'junior');

INSERT INTO "public".categorie_coureur (fk_coureur, fk_categorie) VALUES
(16, 1), -- Jean de La Croix, homme
(17, 1), -- Mirado, homme
(18, 2), -- Oni, femme
(19, 1), -- Mahery, homme
(20, 1), -- Dania, homme
(21, 2), -- Isabelle, femme
(22, 2), -- Fy, femme
(23, 2), -- Idealisoa, femme
(24, 1), -- DM, homme
(25, 2); -- Maroussia, femme

-- Si vous voulez également catégoriser les juniors (moins de 20 ans en 2024)
INSERT INTO "public".categorie_coureur (fk_coureur, fk_categorie) VALUES
(20, 3), -- Dania, junior
(25, 3); -- Maroussia, junior


create  or replace view v_etape_coureur_lib as
select coureur.*,etape.*, fin,duree,utilisateur.*,course_temps.id_course_temps,penalite,duree_total from course_temps
join etape on etape.id_etape = course_temps.fk_etape
join coureur on coureur.id_coureur = course_temps.fk_coureur
join utilisateur on utilisateur.id_utilisateur = coureur.fk_equipe;

-- 
create or replace view v_classement_rang as
WITH classements AS (
    SELECT
        id_course_temps,
        id_coureur,
        nom_coureur,
        numero_dossard,
        date_naissance,
		genre,
        id_etape,
        nom_etape,
        nombre_coureur,
        debut,
        fin,
        duree,
        id_utilisateur,
        nom AS nom_equipe,
		penalite,
		duree_total,
        dense_rank() OVER (PARTITION BY id_etape ORDER BY duree_total) AS rang
    FROM v_etape_coureur_lib
)
SELECT 
    classements.*,
    COALESCE(point.points, 0) AS points
FROM 
    classements
LEFT JOIN 
    point 
ON 
    point.classement = classements.rang;


-- 
create or replace view v_classement_general as
select nom_coureur,numero_dossard,sum(points) as points , nom_equipe from v_classement_rang group by points,nom_coureur,v_classement_rang.numero_dossard , nom_equipe;

create view v_classement_equipe as
select 
	sum(points) as points ,
	nom_equipe , 
	id_utilisateur ,
	dense_rank() over (order by sum(points) desc) as rang 
	from v_classement_rang 
	group by nom_equipe,id_utilisateur;

create view v_categorie_coureur_lib as
select * from categorie_coureur cc join coureur on coureur.id_coureur = cc.fk_coureur join categorie on categorie.id_categorie = cc.fk_categorie;

create view v_classement_categorie_lib as
select v.*,cc.id_categorie,cc.nom_categorie from v_classement_rang v join v_categorie_coureur_lib cc on cc.fk_coureur = v.id_coureur

create view v_classement_categorie_sans_rang as
	select id_coureur,
	nom_coureur,
	numero_dossard,
	date_naissance,
	genre,
	id_etape,
	nom_etape,
	nombre_coureur,
	debut,
	fin,
	duree,
	id_utilisateur,
	nom_equipe,
	id_categorie,
	nom_categorie,
	penalite,
	duree_total
	from v_classement_categorie_lib 

-- 
WITH classement as (
	select *,
	dense_rank() over (PARTITION BY id_etape,id_categorie order by duree_total) as rang 
	from v_classement_categorie_sans_rang
	where id_categorie = 5
),
point_attributs as(
	select
		classement.*,
		COALESCE(point.points,0) as points,
		point.couleur
		from classement
		left join point on classement.rang = point.classement
)
select 
	pa.id_utilisateur,
	pa.nom_equipe,
	sum(pa.points) as total_points,
	pa.couleur,
	dense_rank() over (order by sum(pa.points) desc ) as rang
	
from point_attributs pa
group by 
	pa.id_utilisateur,
	pa.nom_equipe,
	pa.couleur
order by
	total_points desc

	

create view v_detail_penalite as
select * from penalite join etape on etape.id_etape = penalite.fk_etape join utilisateur u on u.id_utilisateur = penalite.fk_equipe;
-- v_classement_rang

with penalites as(
	select
		penalite.fk_equipe,
		penalite.fk_etape,
		sum(penalite.penalite) as sum_penalite
	from penalite 
	group by penalite.fk_equipe,penalite.fk_etape
)
select
	v.*,
	penalites.sum_penalite,
	case when v.duree + penalites.sum_penalite is null then v.duree
		else v.duree + penalites.sum_penalite
	end as temps_avec_penalite

	from etape

	join v_classement_rang v on  v.id_etape = etape.id_etape
	left join penalites on penalites.fk_equipe = v.id_utilisateur and penalites.fk_etape = v.id_etape


	create or replace view v_classement_coureur_par_equipe as
	with rank as(
		select sum(points) as points ,
		nom_coureur ,
		id_utilisateur ,
		nom_equipe ,
		numero_dossard ,
		dense_rank() over (PARTITION BY id_utilisateur order by sum(points) desc) as rang
		from v_classement_rang group by nom_coureur,id_utilisateur,nom_equipe,numero_dossard
	)select rank.* from rank;