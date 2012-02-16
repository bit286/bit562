
/*

Author:       Tim & ?
Date:         Thu Feb  9 02:06:16 PST 2012
Last Updated: Thu Feb 16 02:23:36 PST 2012

Create Script for URLs, Analytics, and Notes

IN PROGRESS

*/

--DROP TABLE urls

CREATE TABLE urls
(object_ID  CHAR(23)        NOT NULL PRIMARY KEY,
useroid     CHAR(23)        NOT NULL,
url         VARCHAR(255)    NOT NULL,
description VARCHAR(255)    NULL,
entrydate   DATETIME        NOT NULL
FOREIGN KEY (useroid) REFERENCES users(object_ID))

/*+
TABLE::tablename=urls::database=BIT276/285_database ::description= description=stores URLs and description of each url .;;
FIELD::fieldname=Object_ID :: description=unique id number for an object within the database. ;;
FIELD::fieldname=useroid::description=a unique id linking to the user who has entered this URL.;;
FIELD::fieldname=url::description=the URL that the user has put into the database.;;
FIELD::fieldname=description::description=the description of the URL provided.;;
FIELD::fieldname=entrydate::description=the date that the user has uploaded the URL into the database.
*/

--DROP TABLE notes

CREATE TABLE notes
(object_ID  CHAR(23)        NOT NULL PRIMARY KEY,
useroid     CHAR(23)        NOT NULL,
note        VARCHAR(MAX)    NOT NULL,
entrydate   DATETIME        NOT NULL
FOREIGN KEY (useroid) REFERENCES users(object_ID))

/*+
TABLE::tablename=notes::database=BIT276/285_database::description=stores text notes.;;
FIELD::fieldname=object_ID :: description=unique id number for an object within the database. ;;
FIELD::fieldname=useroid :: description=a unique id for a user in the database. ;;
FIELD::fieldname=note:: description=any notes that the user may store for future reference.;;
FIELD::fieldname=entrydate::description=the date that the user has uploaded the note into the database.
*/

--DROP TABLE analytics

CREATE TABLE analytics -- this early and i'm blanking on what datatype should be used for the measurement_number
(object_ID          CHAR(23)        NOT NULL PRIMARY KEY,
useroid             CHAR(23)        NOT NULL,
measure             CHAR(23)        NOT NULL,
measurement_text    VARCHAR(50)     NULL,
--measurement_number  ??????????      NULL,
description         VARCHAR(MAX)    NULL,
entrydate           DATETIME        NOT NULL
FOREIGN KEY (useroid) REFERENCES users(object_ID)
FOREIGN KEY (measure) REFERENCES measure(object_ID))

/*+
TABLE::tablename=notes::database=BIT276/285_database::description=stores user metrics in text or number form.;;
FIELD::fieldname=object_ID :: description=unique id number for an object within the database. ;;
FIELD::fieldname=useroid :: description=a unique id for a user in the database. ;;
FIELD::fieldname=measure:: description=this is a foreign key that represents what is being measured.;;
FIELD::fieldname=measure_text:: description=this field is used if the measurement was a text measurement.;;
FIELD::fieldname=measure_number:: description=this field is used if the measurement was a number measurement.;;
FIELD::fieldname=entrydate::description=the date the measure was done.
*/
