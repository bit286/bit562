USE [B123_dbimplementation]
GO

/****** Object:  StoredProcedure [dbo].[sp_TestRunner]    Script Date: 03/08/2012 12:30:34 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER PROC [dbo].[sp_TestRunner]
@successOfTest  VARCHAR(10) OUTPUT

AS

IF OBJECT_ID ('tempdb..##testResults') IS NOT NULL
    DROP TABLE ##testResults

    CREATE TABLE ##testResults (
        id              INT           NOT NULL IDENTITY
        ,PRIMARY KEY (id)
        ,success        VARCHAR(10)   NOT NULL
        ,msg            VARCHAR(5000) NOT NULL
        ,location       VARCHAR(100)
        ,tableName      VARCHAR(50))

    DECLARE @errorCount INT

    --A section for executing the stored procedure tests

    EXEC sp_TestProjectFiles
    EXEC sp_TestUsers

    SELECT @errorCount = COUNT(*) FROM ##testResults
    WHERE success = 'false'

    IF @errorCount = 0
        SET @successOfTest = 'true'
    ELSE
        SET @successOfTest = 'false'
