CREATE TRIGGER entrydateUpdate
	ON test
	AFTER INSERT, UPDATE
AS
	UPDATE test
	SET entryDate = cast(GETDATE() as DATETIME)
	WHERE test_id IN (SELECT test_id FROM Inserted)
