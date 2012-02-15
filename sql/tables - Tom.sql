
--DROP TABLE security_question


CREATE TABLE security_question
(object_id      char(23)        NOT NULL PRIMARY KEY,
question		varchar(100)    NOT NULL)

/*+ TABLE::tablename=security_question::database=B123_dbimplementation::description=Stores the different security questions that the user can select for password recovery.;;
    FIELD::fieldname=object_ID::description=Unique identifyer for each security question.;;
    FIELD::fieldname=question::description=The security question that can be selected for use by the user.
*/


--DROP TABLE access_lvl

CREATE TABLE access_lvl
(object_id        int			NOT NULL PRIMARY KEY,
description       varchar(255)  NOT NULL)

/*+ TABLE::tablename=acess_lvl::database=B123_dbimplementation::description=Stores information on the different levels of access that can be granted to users.;;
    FIELD::fieldname=ObjectID::description=Access level and primary key identifyer for the acess_lvl table.;;
    FIELD::fieldname=description::description=Description of the level of access.
*/




--DROP TABLE users

CREATE TABLE users
(object_ID      char(23)        NOT NULL PRIMARY KEY,
user_name		varchar(50)		NOT NULL,
first_name      varchar(50)		NOT NULL,
last_name		varchar(50)		NOT NULL,
email			varchar(100)	NOT NULL,
urloid			char(23)		NULL,
password		varchar(50)		NOT NULL,
questionoid		char(23)		NOT NULL,
security_answer	varchar(100)	NOT NULL,
accessoid		int		NOT NULL,
entrydate		datetime		NOT NULL,
FOREIGN KEY	(urloid) REFERENCES urls(object_ID),
FOREIGN KEY (questionoid) REFERENCES security_question(object_ID),
FOREIGN KEY (accessoid) REFERENCES access_lvl(object_ID))

/*+ TABLE::tablename=users::database=B123_dbimplementation::description=Information about the authorized users of the database.;;
    FIELD::fieldname=object_ID::description=Unique identifyer for each user of the database.;;
    FIELD::fieldname=first_name::description=The first name of the user.;;
    FIELD::fieldname=last_name::description=The last name of the user.;;
    FIELD::fieldname=email::description=The email address of the user.;;
    FIELD::fieldname=urloid::description=Unique identifyer of the user's URL in the urls table.;;
    FIELD::fieldname=password::description=The password of the user.;;
    FIELD::fieldname=questionoid::description=The unique identifyer in the security_question table for the security question selected by the user.;;
    FIELD::fieldname=security_answer::description=The answer to the security question that was selected by the user.;;
    FIELD::fieldname=accessoid::description=The unique identifyer in the access_lvl table that corresponds to the access level granted to the user.;;
    FIELD::fieldname=entrydate::description=Date/time the entry was stored in the database.
*/


--DROP TABLE file_types


CREATE TABLE file_types
(object_id       char(23)        NOT NULL PRIMARY KEY,
file_type        varchar(20)     NOT NULL)


/*+ TABLE::tablename=file_types::database=B123_dbimplementation::description=The different types of files that can be stored in the database.;;
    FIELD::fieldname=object_id::description=Unique identifyer for each type of file.;;
    FIELD::fieldname=file_type::description=Named descriptor of each file type.
*/


--DROP TABLE files


CREATE TABLE files
(object_id		char(23)        NOT NULL PRIMARY KEY,
useroid			char(23)		NOT NULL,
file_path       varchar(255)    NOT NULL,
description     varchar(1000)   NOT NULL,
typeoid			char(23)		NOT NULL,
entrydate		datetime		NOT NULL,
FOREIGN KEY (useroid) REFERENCES users(object_id),
FOREIGN KEY (typeoid) REFERENCES file_types(object_id))

/*+ TABLE::tablename=files::database=B123_dbimplementation::description=Information on the specific files stored by users.;;
    FIELD::fieldname=object_id::description=Unique identifyer for each file referenced in the database.;;
    FIELD::fieldname=useroid::description=Unique identifyer of the user that owns the file.;;
    FIELD::fieldname=file_path::description=Path on the server to the location of the file.;;
    FIELD::fieldname=description::description=Description of the file.;;
    FIELD::fieldname=typeoid::description=Identifyer of the file type.;;
    FIELD::fieldname=entrydate::description=Date/time the entry was stored in the database.
*/


--DROP TABLE languages


CREATE TABLE languages
(object_id		char(23)        NOT NULL PRIMARY KEY,
language		varchar(20)     NOT NULL)

/*+ TABLE::tablename=language::database=B123_dbimplementation::description=Different programming/coding languages used by the users of the database.;;
    FIELD::fieldname=object_id::description=Unique identifyer of each language.;;
    FIELD::fieldname=language::description=Name of the programming/coding language.
*/

--DROP TABLE code_snippets


CREATE TABLE code_snippets
(object_id      char(23)        NOT NULL PRIMARY KEY,
useroid			char(23)		NOT NULL,
code			varchar(5000)   NOT NULL,
languageoid     char(23)        NOT NULL,
fileoid			char(23)		NULL,
noteoid			char(23)		NULL,
description		varchar(2000)	NOT NULL,
keywords		varchar(255)	NOT NULL,
entrydate		Datetime		NOT NULL
FOREIGN KEY (useroid) REFERENCES users(object_id),
FOREIGN KEY (languageoid) REFERENCES languages(object_id),
FOREIGN KEY (fileoid) REFERENCES files(object_id))
FOREIGN KEY (noteoid) REFERENCES notes(object_id))


/*+ TABLE::tablename=code_snippets::database=B123_dbimplementation::description=Stores various code snippets for use as reference or dynamic database driven applications.;;
    FIELD::fieldname=object_id::description=Unique descriptor of each snippet of code.;;
    FIELD::fieldname=useroid::description=Unique user identifyer for the owner of the snippet of code;;
    FIELD::fieldname=code::description=The actual code that is being stored.;;
    FIELD::fieldname=languageoid::description=Identifyer that ID's the programming/coding language that the code is written in.;;
    FIELD::fieldname=fileoid::description=Unique identifyer of the file (if applicable) that the code is stored in.;;
    FIELD::fieldname=noteoid::description=Identifyer linking to any notes that may be related to the code snippet.;;
    FIELD::fieldname=description::description=Description of the code and it's uses.;;
    FIELD::fieldname=keywords::description=Keywords that can be used to aid in searching for the particular code snippet.;;
    FIELD::fieldname=entrydate::description=Date/time the entry was stored in the database.       
*/
