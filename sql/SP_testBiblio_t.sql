IF OBJECT_ID ('sp_TestBiblio') IS NOT NULL
    DROP PROC sp_TestUsers

GO

CREATE PROC sp_TestBiblio
    AS
    EXEC sp_tableExists 'bibliography', 'sp_TestBiblio'
    EXEC sp_TestRows 'bibliography', 0
