USE [B123_dbimplementation]
GO

/****** Object:  StoredProcedure [dbo].[sp_tableExists]    Script Date: 03/08/2012 12:03:16 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER PROC [dbo].[sp_tableExists]
@tableName VARCHAR(50),
@location VARCHAR(50)
AS

DECLARE @success VARCHAR(10), @message VARCHAR(5000)

IF OBJECT_ID(@tablename) IS NOT NULL
    BEGIN
        SET @success = 'true'
        SET @message = @tableName + ' exists'
    END
ELSE
    BEGIN
        SET @success = 'false'
        SET @message = @tableName + ' does not exist'
    END

    INSERT INTO ##testResults
    (success
        ,msg
        ,location
        ,tablename)
    VALUES
    (@success
        ,@message
        ,@location
        ,@tableName)
