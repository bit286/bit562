insert into PROJECTFILES (Object_ID,Project,Source,Destination,Name,Description,Category)
Values
( 'qwert-qwert-qwezz-qaswe', 'BIT561',
 'c://xampp/htdocs/BIT561/php/reader.php',
 'c://xampp/htdocs/BIT561/doc/reader.html',
 'Controller for autodocumentation application.',
 'Reader looks in the projectfiles table and finds the source code filenames that are to be 
 included in the automatic documentation application.  Once it has file names, it 
 controls the conversion from source code files to browser visible HTML files.',
 'php' ),
 
 ( 'rtuie-iewoq-ckiet-citoe', 'BIT561',
 'c://xampp/htdocs/BIT561/php/tableMap.php',
 'c://xampp/htdocs/BIT561/doc/tableMap.html',
 'Map browser field names to database columns.',
 'Moving data to and from the database requires a one-to-one map between the fields on 
 the browser data collection form and the table column names.  A single tableMap record 
 connects one browser field to one database column.',
 'php' ),
 
  ( 'rtxxe-iewoq-ckiet-citoe', 'BIT561',
 'c://xampp/htdocs/BIT561/php/tableMapManager.php',
 'c://xampp/htdocs/BIT561/doc/tableMapManager.html',
 'Locate all tableMaps for a form.',
 'If the browser name for a data field does not match the database column name,
 there needs to be a record in the tablemaps table which connects the two 
 non-matching names.  The tableMapManager can read that table and assemble 
 the desired tableMap array.',
 'php' ),
 
  ( 'rtuie-iewmm-ckiet-citoe', 'BIT561',
 'c://xampp/htdocs/BIT561/sql/MSSQL.txt',
 'c://xampp/htdocs/BIT561/doc/MSSQL.html',
 'SQL creating a populating basic system tables.',
 'Some tables are required to get the middtle tier datapipes operational. 
 Those tables are: tablemaps, masterid, and test.  In addtion some other
 basic tables are projectfiles, backlogs, and sprint.  MSSQL creates and 
 prepopulates these tables.',
 'sql' ),
 
( 'xxxxx-iewoq-ckiet-citoe', 'BIT561',
 'c://xampp/htdocs/BIT561/css/system.css',
 'c://xampp/htdocs/BIT561/doc/systemCSS.html',
 'Style sheet controlling autodoc appearances.',
 'A single style sheet which dictates the appearance of the software 
 generated HTML within the autodoc system.',
 'css' );

insert into masterid ( object_ID, tableName, authoroid )
values
( 'qwert-qwert-qwezz-qaswe', 'projectfiles', 'bitxx-bitxx-bitxx-bitxx' ),
( 'rtuie-iewoq-ckiet-citoe', 'projectfiles', 'bitxx-bitxx-bitxx-bitxx' ),
( 'rtxxe-iewoq-ckiet-citoe', 'projectfiles', 'bitxx-bitxx-bitxx-bitxx' ),
( 'rtuie-iewmm-ckiet-citoe', 'projectfiles', 'bitxx-bitxx-bitxx-bitxx' ),
( 'xxxxx-iewoq-ckiet-citoe', 'projectfiles', 'bitxx-bitxx-bitxx-bitxx' );