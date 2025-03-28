create database thuctapphp3;
create table users(
	userId int primary key auto_increment,
    username varchar(100) not null unique,
    fullname varchar(100) not null,
    password varchar(100) not null ,
    email varchar(100) not null unique,
    birthDate date,
    status varchar(100),
    categoryUser varchar(100) not null,
    department varchar(100) not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
create table letters(
	letterId int primary key auto_increment,
    userId int,
	title varchar(100),
    content varchar(1000),
    approver int,
    typesOfApplication varchar(100),
    approvalDate date,
    startDate date,
    endDate date,
    status varchar(100),
    attachment varchar(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    constraint fk_users foreign key (userId) references users(userId)
);


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddLetter`(
    IN p_userId int,
	IN p_title varchar(100),
    IN p_content varchar(1000),
    IN p_approver int,
    IN p_typesOfApplication varchar(100),
    IN p_startDate date,
    IN p_endDate date,
    IN p_status varchar(100),
    IN p_attachment varchar(500)
)
BEGIN 
	INSERT INTO letters (userId, title, content, approver, typesOfApplication, startDate, endDate, status, attachment) 
    VALUES (p_userId, p_title, p_content, p_approver, p_typesOfApplication, p_startDate, p_endDate, p_status, p_attachment);
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddUser`(
	IN p_username varchar(100),
    IN p_fullname varchar(100),
    IN p_password varchar(100),
    IN p_email varchar(100),
    IN p_birthDate date,
    IN p_categoryUser varchar(100),
    IN p_department varchar(100)
)
BEGIN
	INSERT INTO users(username, fullname, password, email, birthDate, categoryUser, department) 
    VALUES (p_username, p_fullname, p_password, p_email, p_birthDate, p_categoryUser, p_department);
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ApprovalLetter`(
    IN p_letterId INT
)
BEGIN
	DECLARE letter_exists INT DEFAULT 0;
    DECLARE exit handler for SQLEXCEPTION
    BEGIN
    	ROLLBACK;
    END;
    
    START TRANSACTION;
    SELECT COUNT(*) INTO letter_exists FROM letters WHERE letterId = p_letterId;
    
    IF letter_exists > 0 THEN 
    	UPDATE letters
        SET status = 'Đã duyệt',
        	approvalDate = CURRENT_DATE()
        WHERE letterId = p_letterId;
        COMMIT;
    ELSE
    	ROLLBACK;
    END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CancelLetter`(
    IN p_letterId INT
)
BEGIN
    DECLARE letter_exists INT DEFAULT 0;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;
    
    START TRANSACTION;
    SELECT COUNT(*) INTO letter_exists FROM letters WHERE letterId = p_letterId;
    
    IF letter_exists > 0 THEN 
        UPDATE letters
        SET status = 'Đã hủy',
            approvalDate = CURRENT_DATE()
        WHERE letterId = p_letterId;
        COMMIT;
    ELSE
        ROLLBACK;
    END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteUser`(
	IN p_userId INT
)
BEGIN
	DELETE FROM letters WHERE userId = p_userId;
	DELETE FROM users WHERE userId = p_userId;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindUserByEmail`(
	IN p_email varchar(255)
)
BEGIN
	Select * from users where email = p_email;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindUserByUsername`(
	IN p_username varchar(255)
)
BEGIN
	Select * from users where username = p_username;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetLetterById`(
	IN p_letterId int
)
BEGIN 
	select letterId, userId, title, content, approver, typesOfApplication, approvalDate, startDate, endDate, status, attachment from letters where letterId = p_letterId;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetLetterForDashboard`(
)
begin
	SELECT letterId, letters.userId, u.username, title, content, approver, typesOfApplication, approvalDate, startDate, endDate, status, attachment, letters.created_at
	FROM letters 
	INNER JOIN users u ON letters.userId = u.userId  order by created_at ASC limit 30 ;
end$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetLetters`(
    IN p_offset INT,
    IN p_limit INT,
    IN p_sort VARCHAR(50),
    IN p_order VARCHAR(10),
    IN p_search VARCHAR(255)
)
BEGIN
    SET @query = CONCAT(
        'SELECT letterId, letters.userId, u.username, title, content, approver, typesOfApplication, approvalDate, startDate, endDate, letters.status, attachment, letters.created_at
        FROM letters 
        INNER JOIN users u ON letters.userId = u.userId 
        WHERE title LIKE ? OR typesOfApplication LIKE ? OR letters.status LIKE ? OR u.username LIKE ? 
        ORDER BY ', 
        IF(p_sort IN ('letterId', 'userId', 'username', 'title', 'approvalDate', 'startDate', 'endDate', 'letters.status'), 
		IF(p_sort = 'userId', 'letters.userId', p_sort), 'letterId'), 
        ' ', 
        IF(p_order IN ('ASC', 'DESC'), p_order, 'ASC'), 
        ' LIMIT ?, ?'
    );
    
    SET @search_param = CONCAT('%', p_search, '%');

    PREPARE stmt FROM @query;
    EXECUTE stmt USING @search_param, @search_param, @search_param, @search_param, p_offset, p_limit;

    SET @count_query = '
        SELECT COUNT(*) as total 
        FROM letters 
        INNER JOIN users u ON letters.userId = u.userId 
        WHERE title LIKE ? OR typesOfApplication LIKE ? OR letters.status LIKE ? OR u.username LIKE ?';
    PREPARE count_stmt FROM @count_query;
    EXECUTE count_stmt USING @search_param, @search_param, @search_param, @search_param;

    DEALLOCATE PREPARE stmt;
    DEALLOCATE PREPARE count_stmt;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserByDepartment`(
	IN p_department INT
)
BEGIN
	SELECT * from users where department = p_department;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserById`(
	IN p_userId INT
)
BEGIN
	SELECT * from users Where userId = p_userId;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUsers`(
    IN p_offset INT,
    IN p_limit INT,
    IN p_sort VARCHAR(50),
    IN p_order VARCHAR(10),
    IN p_search VARCHAR(255)
)
BEGIN
    SET @query = CONCAT('SELECT userId, username, fullname, password, email, birthDate, categoryUser, department, created_at FROM users WHERE username LIKE ? OR userId LIKE ? ORDER BY ', p_sort, ' ', p_order, ' LIMIT ?, ?');
    
    SET @search_param = CONCAT('%', p_search, '%');
    
    PREPARE stmt FROM @query;
    EXECUTE stmt USING @search_param, @search_param, p_offset, p_limit;
    
    -- Get total count
    SELECT COUNT(*) as total FROM users WHERE username LIKE CONCAT('%', p_search, '%') OR userId LIKE CONCAT('%', p_search, '%');
    
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUser`(
	IN p_userId INT,
    IN p_username VARCHAR(100),
    IN p_fullname VARCHAR(100),
    IN P_password VARCHAR(100),
    IN p_email VARCHAR(100),
    IN P_birthDate DATE,
    IN p_categoryUser VARCHAR(100),
    IN p_department VARCHAR(100)
)
BEGIN
	declare user_exists INT default 0;
    declare duplicate_username int default 0;
    declare duplicate_email int default 0;
    start transaction;
    select count(*) into user_exists from users where userId = p_userId;
    if user_exists = 0 then rollback;
	else
		select count(*) into duplicate_username from users where username = p_username and userId != p_userId;
        select count(*) into duplicate_email from users where email = p_email and userId != p_userId;
        if duplicate_username > 0 then rollback;
		elseif duplicate_email > 0 then rollback;
		else
			update users
            set username = p_username,
				fullname = p_fullname,
                password = p_password,
                email = p_email,
                birthDate = p_birthDate,
                categoryUser = p_categoryUser,
                department = p_department
			where userId = p_userId;
            commit;
		end if;
	end if;
END$$
DELIMITER ;

