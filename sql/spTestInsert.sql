
CREATE PROC spTestInsert
	@description		varchar(5000),
	@success			bit,
	@entryDate			datetime
AS

	INSERT INTO tests (description, success, entryDate)
		VALUES (@description, @success, @entrydate)