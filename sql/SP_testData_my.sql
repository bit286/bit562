DELIMITER $$
CREATE PROCEDURE BIT561.SP_insertTestData(descrip VARCHAR(1000), succ BOOLEAN)
BEGIN
    INSERT INTO test (description, success, entrydate)
        VALUES (descrip, succ, NOW());
END$$
DELIMITER;
