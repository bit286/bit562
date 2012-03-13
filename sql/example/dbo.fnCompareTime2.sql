USE [B123_dbimplementation]
GO

/****** Object:  UserDefinedFunction [dbo].[fnCompareTime2]    Script Date: 03/08/2012 23:30:07 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER FUNCTION [dbo].[fnCompareTime2]
(@startDate             DATETIME
    ,@endDate           DATETIME)
RETURNS INT

BEGIN
    DECLARE @startTime  TIME(7)
    DECLARE @endTime    TIME(7)
    DECLARE @micros INT

    SET @startTime = CAST(@startDate AS TIME(7))
    SET @endTime = CAST(@endTime AS TIME(7))
    SET @micros = DATEDIFF(MICROSECOND, @startTime, @endTime)
    RETURN @micros
END
