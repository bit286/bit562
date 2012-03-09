IF OBJECT_ID ('sp_TestUsers') is not null
	DROP PROC sp_TestUsers
	
GO

CREATE PROC sp_TestUsers

AS

EXEC sp_tableExists 'users', 'sp_TestUsers'
EXEC sp_TestRows 'users', 0