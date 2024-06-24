CREATE SCHEMA IF NOT EXISTS "public";

CREATE SEQUENCE "public".categorie_coureur_id_categorie_coureur_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".categorie_id_categorie_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".classement_id_classement_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".coureur_id_coureur_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".course_temps_id_course_temps_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".etape_id_etape_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".failed_jobs_id_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".jobs_id_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".migrations_id_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".penalite_id_penalite_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".point_id_point_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".users_id_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".utilisateur_id_utilisateur_seq AS integer START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public"."cache" ( 
	"value"              text  NOT NULL  ,
	expiration           integer  NOT NULL  
 );

CREATE  TABLE "public".cache_locks ( 
	"owner"              varchar(255)  NOT NULL  ,
	expiration           integer  NOT NULL  
 );

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
	debut                timestamp    ,
	date_debut           date    ,
	heure_debut          time    ,
	CONSTRAINT pk_etape PRIMARY KEY ( id_etape )
 );

CREATE  TABLE "public".etape_temporaire ( 
	etape                varchar    ,
	longueur             varchar    ,
	nb_coureur           varchar    ,
	rang                 varchar    ,
	date_depart          varchar    ,
	heure_depart         varchar    
 );

CREATE  TABLE "public".failed_jobs ( 
	id                   bigserial  NOT NULL  ,
	uuid                 varchar(255)  NOT NULL  ,
	"connection"         text  NOT NULL  ,
	queue                text  NOT NULL  ,
	payload              text  NOT NULL  ,
	"exception"          text  NOT NULL  ,
	failed_at            timestamp(0) DEFAULT CURRENT_TIMESTAMP NOT NULL  ,
	CONSTRAINT failed_jobs_pkey PRIMARY KEY ( id ),
	CONSTRAINT failed_jobs_uuid_unique UNIQUE ( uuid ) 
 );

CREATE  TABLE "public".job_batches ( 
	id                   varchar(255)  NOT NULL  ,
	name                 varchar(255)  NOT NULL  ,
	total_jobs           integer  NOT NULL  ,
	pending_jobs         integer  NOT NULL  ,
	failed_jobs          integer  NOT NULL  ,
	failed_job_ids       text  NOT NULL  ,
	"options"            text    ,
	cancelled_at         integer    ,
	created_at           integer  NOT NULL  ,
	finished_at          integer    ,
	CONSTRAINT job_batches_pkey PRIMARY KEY ( id )
 );

CREATE  TABLE "public".jobs ( 
	id                   bigserial  NOT NULL  ,
	queue                varchar(255)  NOT NULL  ,
	payload              text  NOT NULL  ,
	attempts             smallint  NOT NULL  ,
	reserved_at          integer    ,
	available_at         integer  NOT NULL  ,
	created_at           integer  NOT NULL  ,
	CONSTRAINT jobs_pkey PRIMARY KEY ( id )
 );

CREATE INDEX jobs_queue_index ON "public".jobs USING  btree ( queue );

CREATE  TABLE "public".migrations ( 
	id                   serial  NOT NULL  ,
	migration            varchar(255)  NOT NULL  ,
	batch                integer  NOT NULL  ,
	CONSTRAINT migrations_pkey PRIMARY KEY ( id )
 );

CREATE  TABLE "public".password_reset_tokens ( 
	email                varchar(255)  NOT NULL  ,
	token                varchar(255)  NOT NULL  ,
	created_at           timestamp(0)    ,
	CONSTRAINT password_reset_tokens_pkey PRIMARY KEY ( email )
 );

CREATE  TABLE "public".point ( 
	id_point             serial  NOT NULL  ,
	classement           integer    ,
	points               integer    ,
	couleur              varchar    ,
	CONSTRAINT point_pkey PRIMARY KEY ( id_point ),
	CONSTRAINT unq_point UNIQUE ( classement ) 
 );

CREATE  TABLE "public".point_temporaire ( 
	classement           varchar    ,
	points               varchar    
 );

CREATE  TABLE "public".resultat_temporaire ( 
	etape_rang           integer    ,
	numero_dossard       varchar    ,
	nom                  varchar    ,
	genre                varchar    ,
	date_naissance       varchar    ,
	equipe               varchar    ,
	arrivee              varchar    
 );

CREATE  TABLE "public".sessions ( 
	id                   varchar(255)  NOT NULL  ,
	user_id              bigint    ,
	ip_address           varchar(45)    ,
	user_agent           text    ,
	payload              text  NOT NULL  ,
	last_activity        integer  NOT NULL  ,
	CONSTRAINT sessions_pkey PRIMARY KEY ( id )
 );

CREATE INDEX sessions_user_id_index ON "public".sessions USING  btree ( user_id );

CREATE INDEX sessions_last_activity_index ON "public".sessions USING  btree ( last_activity );

CREATE  TABLE "public".users ( 
	id                   bigserial  NOT NULL  ,
	name                 varchar(255)  NOT NULL  ,
	email                varchar(255)  NOT NULL  ,
	email_verified_at    timestamp(0)    ,
	"password"           varchar(255)  NOT NULL  ,
	remember_token       varchar(100)    ,
	created_at           timestamp(0)    ,
	updated_at           timestamp(0)    ,
	CONSTRAINT users_pkey PRIMARY KEY ( id ),
	CONSTRAINT users_email_unique UNIQUE ( email ) 
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
	genre                varchar    ,
	date_naissance       date    ,
	fk_equipe            integer    ,
	CONSTRAINT pk_coureur PRIMARY KEY ( id_coureur ),
	CONSTRAINT unq_coureur UNIQUE ( numero_dossard ) ,
	CONSTRAINT fk_coureur_utilisateur FOREIGN KEY ( fk_equipe ) REFERENCES "public".utilisateur( id_utilisateur )   
 );

CREATE  TABLE "public".course_temps ( 
	id_course_temps      serial  NOT NULL  ,
	fk_etape             integer    ,
	fk_coureur           integer    ,
	debut                timestamp    ,
	fin                  timestamp    ,
	duree                interval    ,
	penalite             interval DEFAULT '00:00:00'::time without time zone   ,
	duree_total          interval    ,
	CONSTRAINT pk_course_temps PRIMARY KEY ( id_course_temps ),
	CONSTRAINT fk_course_temps_coureur FOREIGN KEY ( fk_coureur ) REFERENCES "public".coureur( id_coureur )   ,
	CONSTRAINT fk_course_temps_etape FOREIGN KEY ( fk_etape ) REFERENCES "public".etape( id_etape )   
 );

CREATE  TABLE "public".penalite ( 
	id_penalite          serial  NOT NULL  ,
	penalite             time    ,
	fk_etape             integer    ,
	fk_equipe            integer    ,
	CONSTRAINT pk_penalite PRIMARY KEY ( id_penalite ),
	CONSTRAINT fk_penalite_etape FOREIGN KEY ( fk_etape ) REFERENCES "public".etape( id_etape )   ,
	CONSTRAINT fk_penalite_utilisateur FOREIGN KEY ( fk_equipe ) REFERENCES "public".utilisateur( id_utilisateur )   
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
	temps                interval    ,
	fk_course_temps      integer    ,
	CONSTRAINT pk_classement PRIMARY KEY ( id_classement ),
	CONSTRAINT fk_classement_course_temps FOREIGN KEY ( fk_course_temps ) REFERENCES "public".course_temps( id_course_temps )   
 );

CREATE OR REPLACE VIEW v_categorie_coureur_lib AS SELECT "public".v_categorie_coureur_lib,
    cc.fk_coureur,
    cc.fk_categorie,
    coureur.id_coureur,
    coureur.nom_coureur,
    coureur.numero_dossard,
    coureur.genre,
    coureur.date_naissance,
    coureur.fk_equipe,
    categorie.id_categorie,
    categorie.nom_categorie
   FROM ((categorie_coureur cc
     JOIN coureur ON ((coureur.id_coureur = cc.fk_coureur)))
     JOIN categorie ON ((categorie.id_categorie = cc.fk_categorie)));

CREATE OR REPLACE VIEW v_detail_penalite AS SELECT "public".v_detail_penalite,
    penalite.penalite,
    penalite.fk_etape,
    penalite.fk_equipe,
    etape.id_etape,
    etape.nom_etape,
    etape.nombre_coureur,
    etape.longueur,
    etape.rang_etape,
    etape.debut,
    etape.date_debut,
    etape.heure_debut,
    u.id_utilisateur,
    u.nom,
    u.mail,
    u.password,
    u.is_admin
   FROM ((penalite
     JOIN etape ON ((etape.id_etape = penalite.fk_etape)))
     JOIN utilisateur u ON ((u.id_utilisateur = penalite.fk_equipe)));

CREATE OR REPLACE VIEW v_etape_coureur_lib AS SELECT "public".v_etape_coureur_lib,
    coureur.nom_coureur,
    coureur.numero_dossard,
    coureur.genre,
    coureur.date_naissance,
    coureur.fk_equipe,
    etape.id_etape,
    etape.nom_etape,
    etape.nombre_coureur,
    etape.longueur,
    etape.rang_etape,
    etape.debut,
    etape.date_debut,
    etape.heure_debut,
    course_temps.fin,
    course_temps.duree,
    utilisateur.id_utilisateur,
    utilisateur.nom,
    utilisateur.mail,
    utilisateur.password,
    utilisateur.is_admin,
    course_temps.id_course_temps,
    course_temps.penalite,
    course_temps.duree_total
   FROM (((course_temps
     JOIN etape ON ((etape.id_etape = course_temps.fk_etape)))
     JOIN coureur ON (("public".v_etape_coureur_lib = course_temps.fk_coureur)))
     JOIN utilisateur ON ((utilisateur.id_utilisateur = coureur.fk_equipe)));

CREATE OR REPLACE VIEW v_classement_rang AS WITH classements AS (
         SELECT v_etape_coureur_lib.id_course_temps,
            v_etape_coureur_lib.id_coureur,
            v_etape_coureur_lib.nom_coureur,
            v_etape_coureur_lib.numero_dossard,
            v_etape_coureur_lib.date_naissance,
            v_etape_coureur_lib.genre,
            v_etape_coureur_lib.id_etape,
            v_etape_coureur_lib.nom_etape,
            v_etape_coureur_lib.nombre_coureur,
            v_etape_coureur_lib.debut,
            v_etape_coureur_lib.fin,
            v_etape_coureur_lib.duree,
            v_etape_coureur_lib.id_utilisateur,
            v_etape_coureur_lib.nom AS nom_equipe,
            v_etape_coureur_lib.penalite,
            v_etape_coureur_lib.duree_total,
            dense_rank() OVER (PARTITION BY v_etape_coureur_lib.id_etape ORDER BY v_etape_coureur_lib.duree_total) AS rang
           FROM v_etape_coureur_lib)
 SELECT "public".v_classement_rang,
    classements.id_coureur,
    classements.nom_coureur,
    classements.numero_dossard,
    classements.date_naissance,
    classements.genre,
    classements.id_etape,
    classements.nom_etape,
    classements.nombre_coureur,
    classements.debut,
    classements.fin,
    classements.duree,
    classements.id_utilisateur,
    classements.nom_equipe,
    classements.penalite,
    classements.duree_total,
    classements.rang,
    COALESCE(point.points, 0) AS points
   FROM (classements
     LEFT JOIN point ON ((point.classement = classements.rang)));

CREATE OR REPLACE VIEW v_classement_categorie_lib AS SELECT "public".v_classement_categorie_lib,
    v.id_coureur,
    v.nom_coureur,
    v.numero_dossard,
    v.date_naissance,
    v.genre,
    v.id_etape,
    v.nom_etape,
    v.nombre_coureur,
    v.debut,
    v.fin,
    v.duree,
    v.id_utilisateur,
    v.nom_equipe,
    v.penalite,
    v.duree_total,
    v.rang,
    v.points,
    cc.id_categorie,
    cc.nom_categorie
   FROM (v_classement_rang v
     JOIN v_categorie_coureur_lib cc ON ((cc.fk_coureur = v.id_coureur)));

CREATE OR REPLACE VIEW v_classement_categorie_sans_rang AS SELECT "public".v_classement_categorie_sans_rang,
    v_classement_categorie_lib.nom_coureur,
    v_classement_categorie_lib.numero_dossard,
    v_classement_categorie_lib.date_naissance,
    v_classement_categorie_lib.genre,
    v_classement_categorie_lib.id_etape,
    v_classement_categorie_lib.nom_etape,
    v_classement_categorie_lib.nombre_coureur,
    v_classement_categorie_lib.debut,
    v_classement_categorie_lib.fin,
    v_classement_categorie_lib.duree,
    v_classement_categorie_lib.id_utilisateur,
    v_classement_categorie_lib.nom_equipe,
    v_classement_categorie_lib.id_categorie,
    v_classement_categorie_lib.nom_categorie,
    v_classement_categorie_lib.penalite,
    v_classement_categorie_lib.duree_total
   FROM v_classement_categorie_lib;

CREATE OR REPLACE VIEW v_classement_coureur_par_equipe AS WITH rank AS (
         SELECT sum(v_classement_rang.points) AS points,
            v_classement_rang.nom_coureur,
            v_classement_rang.id_utilisateur,
            v_classement_rang.nom_equipe,
            v_classement_rang.numero_dossard,
            dense_rank() OVER (PARTITION BY v_classement_rang.id_utilisateur ORDER BY (sum(v_classement_rang.points)) DESC) AS rang
           FROM v_classement_rang
          GROUP BY v_classement_rang.nom_coureur, v_classement_rang.id_utilisateur, v_classement_rang.nom_equipe, v_classement_rang.numero_dossard)
 SELECT "public".v_classement_coureur_par_equipe,
    rank.nom_coureur,
    rank.id_utilisateur,
    rank.nom_equipe,
    rank.numero_dossard,
    rank.rang
   FROM rank;

CREATE OR REPLACE VIEW v_classement_equipe AS SELECT sum(v_classement_rang.points) AS points,
    "public".v_classement_equipe,
    v_classement_rang.id_utilisateur,
    dense_rank() OVER (ORDER BY (sum(v_classement_rang.points)) DESC) AS rang
   FROM v_classement_rang
  GROUP BY "public".v_classement_equipe, v_classement_rang.id_utilisateur;

CREATE OR REPLACE VIEW v_classement_general AS SELECT "public".v_classement_general,
    v_classement_rang.numero_dossard,
    sum(v_classement_rang.points) AS points,
    v_classement_rang.nom_equipe
   FROM v_classement_rang
  GROUP BY v_classement_rang.points, "public".v_classement_general, v_classement_rang.numero_dossard, v_classement_rang.nom_equipe;
