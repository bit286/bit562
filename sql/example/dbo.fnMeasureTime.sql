/*

Returns time difference of time in microseconds

 */
USE [B123_dbimplementation]
GO

/****** Object:  UserDefinedFunction [dbo].[fnMeasureTime]    Script Date: 03/08/2012 23:38:33 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER FUNCTION [dbo].[fnMeasureTime]
(@startTime             TIME(7))
RETURNS INT

BEGIN
    DECLARE @micros             INT
    SET @micros = DATEDIFF(MICROSECOND
        ,@startTime
        ,CAST(GETDATE() AS TIME(7)))
    RETURN @micros
END
