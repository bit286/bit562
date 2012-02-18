/*

Author:       Tim Finnell
Date:         Thu Feb  9 02:06:16 PST 2012
Last Updated: Fri Feb 17 03:38:30 PST 2012

Create Script for URLs, Analytics, and Notes

*/

IF OBJECT_ID('urls') IS NOT NULL
    DROP TABLE urls

CREATE TABLE urls
(object_ID  CHAR(23)        NOT NULL PRIMARY KEY,
useroid     CHAR(23)        NOT NULL,
url         VARCHAR(255)    NOT NULL,
description VARCHAR(1000)   NULL,
entrydate   DATETIME        NOT NULL,
FOREIGN KEY (useroid) REFERENCES users(object_ID))

/*+
TABLE::tablename=urls::database=BIT276/285_database ::description= description=stores URLs and description of each url .;;
FIELD::fieldname=Object_ID :: description=unique id number for an object within the database. ;;
FIELD::fieldname=useroid::description=a unique id linking to the user who has entered this URL.;;
FIELD::fieldname=url::description=the URL that the user has put into the database.;;
FIELD::fieldname=description::description=the description of the URL provided.;;
FIELD::fieldname=entrydate::description=the date that the user has uploaded the URL into the database.
*/

IF OBJECT_ID('notes') IS NOT NULL
    DROP TABLE notes

CREATE TABLE notes
(object_ID  CHAR(23)        NOT NULL PRIMARY KEY,
useroid     CHAR(23)        NOT NULL,
note        VARCHAR(MAX)    NOT NULL,
entrydate   DATETIME        NOT NULL,
FOREIGN KEY (useroid) REFERENCES users(object_ID))

/*+
TABLE::tablename=notes::database=BIT276/285_database::description=stores text notes.;;
FIELD::fieldname=object_ID :: description=unique id number for an object within the database. ;;
FIELD::fieldname=useroid :: description=a unique id for a user in the database. ;;
FIELD::fieldname=note:: description=any notes that the user may store for future reference.;;
FIELD::fieldname=entrydate::description=the date that the user has uploaded the note into the database.
*/

IF OBJECT_ID('analytics') IS NOT NULL
    DROP TABLE analytics

CREATE TABLE analytics
(object_ID          CHAR(23)        NOT NULL PRIMARY KEY,
useroid             CHAR(23)        NOT NULL,
measure             VARCHAR(50)     NOT NULL,
measurement_text    VARCHAR(50)     NULL,
measurement_number  INT             NULL,
description         VARCHAR(MAX)    NULL,
entrydate           DATETIME        NOT NULL,
FOREIGN KEY (useroid) REFERENCES users(object_ID))

/*+
TABLE::tablename=notes::database=BIT276/285_database::description=stores user metrics in text or number form.;;
FIELD::fieldname=object_ID :: description=unique id number for an object within the database. ;;
FIELD::fieldname=useroid :: description=a unique id for a user in the database. ;;
FIELD::fieldname=measure:: description=this string tells what is being measured.;;
FIELD::fieldname=measure_text:: description=this field is used if the measurement was a text measurement.;;
FIELD::fieldname=measure_number:: description=this field is used if the measurement was a number measurement.;;
FIELD::fieldname=entrydate::description=the date the measure was done.
*/
