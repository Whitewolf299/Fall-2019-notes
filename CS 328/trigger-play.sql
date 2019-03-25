/*
CS 328 - HW3 - problem 1
Sylvan Brander
3/15/19
*/

set serveroutput on
start movies-create.sql 
start movies-pop.sql

spool trigger-play-out.txt

CREATE TRIGGER approve_rental
ON rental
FOR INSERT 
AS
IF INSERT(y)
	BEGIN 
		IF(1.5 > 	select client_credit_rtg
					FROM client c, rental r
					where c.client_num = r.client_num)
	BEGIN
	
	PRINT 'Sorry your credit rating is too low we will no longer rent to you'
	
	END
	ELSE
	BEGIN
	INSERT 
	END

commit;