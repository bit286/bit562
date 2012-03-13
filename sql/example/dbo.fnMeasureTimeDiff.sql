/*

Returns time difference of time in nanoseconds

 */
USE [B123_dbimplementation]
GO

/****** Object:  UserDefinedFunction [dbo].[fnMeasureTimeDiff]    Script Date: 03/08/2012 23:41:32 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER FUNCTION [dbo].[fnMeasureTimeDiff] (@startDateTime DATETIME, @endDateTime DATETIME)
RETURNS INT
BEGIN
    DECLARE @nanosecs INT
    SET @nanosecs = DATEDIFF(NANOSECOND
        ,CAST(@startDateTime AS TIME(7))
        ,CAST(@endDateTime AS TIME(7)))
    RETURN @nanosecs
END

