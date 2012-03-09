/*+
--syntax:
    COMMAND::name=value::name=value:: ...name=value;;
*/

USE BIT561;

CREATE TABLE backlogs
(objectID       CHAR(23)      NOT NULL PRIMARY KEY,
project         VARCHAR(50)   NOT NULL,
taskname        VARCHAR(255)  NOT NULL,
taskdescription VARCHAR(3000) NOT NULL,
role            VARCHAR(50)   NOT NULL)

/*+   
    TABLE::tablename=BackLog::database=BIT_276::description=information about BackLog.;;
    FIELD::fieldname=ObjectID::description=Name in ObjectID.;;
    FIELD::fieldname=Project::description=The Project name in system.;;
    FIELD::fieldname=TaskName::description=Name of the TaskName.;;
    FIELD::fieldname=TaskDescription::description= Name and Description of TaskDescription.;;
    FIELD::fieldname=Role::description=Description of Role.;;
       
*/

CREATE TABLE projectfiles
(object_ID       CHAR(23)      NOT NULL PRIMARY KEY,
project          VARCHAR(50)   NOT NULL,
source           VARCHAR(1000) NOT NULL,
destination      VARCHAR(1000) NOT NULL,
name             VARCHAR(255)  NOT NULL,
description      VARCHAR(5000) NOT NULL,
entryDate        ROWVERSION    NOT NULL)

/*+   
    TABLE::tablename=Project_Files::database=BIT_276::description=information about ProjectFiles;;
    FIELD::fieldname=ObjectID::description=Name in ObjectID.;;
    FIELD::fieldname=Project::description=The Name of Project in system.;;
    FIELD::fieldname=Source::description=Source of Project.;;
    FIELD::fieldname=Destination::description= Destination of the Source.;;
    FIELD::fieldname=Name::description=Description of Name.;;
    FIELD::fieldname=Description::description=Description of the project.;;
    FIELD::fieldname=EntryDate::description=Projects EntryDate.;;
        
*/

CREATE TABLE test
(test_id          INT            NOT NULL IDENTITY,
description       VARCHAR(3000)  NOT NULL,
success           VARCHAR(50)    NOT NULL,
entryDate         ROWVERSION     NOT NULL)

/*+   
    TABLE::tablename=Test::database=BIT_276::description=information about Test;;
    FIELD::fieldname=TestID::description=Name Of the Test ID.;;
    FIELD::fieldname=Description::description=Description of the Project .;;
    FIELD::Filename=Success::description=Success of the Test,;;
    FIELD::fieldname=EntryDate::description=Projects EntryDate.;;
        
*/

CREATE TABLE sprint_time_cost
(object_ID         INT            NOT NULL PRIMARY KEY,
estimatedtime      SMALLDATETIME  NOT NULL,
actualtime         SMALLDATETIME  NOT NULL,
estimatedcost      MONEY          NOT NULL,
actualcost         MONEY          NOT NULL,
status             MONEY          NOT NULL,
entrydate          ROWVERSION     NOT NULL)
    
  /*+   
    TABLE::tablename=Sprint_Time_Cost::database=BIT_276::description=information about Sprint time and cost;;
    FIELD::fieldname=ObjectID::description=Name in ObjectID.;;
    FIELD::fieldname=EstimatedTime::description=Estimated Time of the Cost .;;
    FIELD::fieldname=ActualTime::description=The Actual Time of the project.;;
    FIELD::fieldname=EstimatedCost::description= Estimated Cost of the project.;;
    FIELD::fieldname=ActualCost::description=Actual Cost of the Object.;;
    FIELD::fieldname=Status::description=Status of the Sprint.;;
    FIELD::fieldname=EntryDate::description=Projects Entry Date.;;       
*/    
   
CREATE INDEX IX_backlog_project
    ON backlogs (project ASC)

ALTER TABLE projectfiles
    ADD estimatedcost TEXT NULL
/*+
FIELD::fieldname=EstimatedCost::description=EstimatedCost of the Project.;;
*/
   
ALTER TABLE sprint_time_cost
    ALTER COLUMN estimatedtime VARCHAR(50)

/*+
FIELD::fieldname=EstimatedTime::description=Estimated time of the project.;;
 */
