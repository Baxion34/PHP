CREATE TABLE users(
	login VARCHAR(20) PRIMARY KEY,
    	passwd VARCHAR(30),
    	nb_Cours1 INT,
   	 nb_Cours2 INT,
	date-heure_visite DATETIME
   	 ip VARCHAR(15)
);

INSERT INTO users(login,passwd,nb_Cours1,nb_Cours2) VALUES ('admin', 'administrator', 0, 0), ('test', 'test123', 0, 0);