USE [B123_dbimplementation]
GO

/****** Object:  StoredProcedure [dbo].[SP_removeAllTableConstraints]    Script Date: 03/08/2012 11:54:58 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[SP_removeAllTableConstraints] (@database VARCHAR(255), @table VARCHAR(255))
AS

DECLARE @sql nvarchar(255)
WHILE EXISTS(
    SELECT
    *
    FROM
    INFORMATION_SCHEMA.TABLE_CONSTRAINTS
    WHERE
    constraint_catalog = @database and table_name = @table)

    BEGIN
        SELECT
        @sql = 'ALTER TABLE ' + @table + ' DROP CONSTRAINT ' + CONSTRAINT_NAME
        FROM
        INFORMATION_SCHEMA.TABLE_CONSTRAINTS
        WHERE
        constraint_catalog = @database and
        table_name = @table
        EXEC    sp_executesql @sql
   END
