-- set foreign keys to 0 before we create tables
SET FOREIGN_KEY_CHECKS=0;

-- drop all tables if they exist
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS priorDegrees; 
DROP TABLE IF EXISTS tests;
DROP TABLE IF EXISTS app;
DROP TABLE IF EXISTS ratings;
DROP TABLE IF EXISTS history;
DROP TABLE IF EXISTS recommenders;
DROP TABLE IF EXISTS letters;
DROP TABLE IF EXISTS uploads;

-- create tables 
CREATE TABLE users (
    `UID` int NOT NULL AUTO_INCREMENT,
    `username` varchar(20) NOT NULL,
    `password` varchar(40) NOT NULL,
    `fname` varchar(50) NOT NULL,
    `minit` char(1),
    `lname` varchar(50) NOT NULL,
    `ssn` char(9) NOT NULL,
    `typeUser` int(1) NOT NULL,
    `address` varchar(100) NOT NULL,
    `email` varchar(62) NOT NULL,
    PRIMARY KEY (UID)
);

CREATE TABLE priorDegrees (
    `UID` int (8) NOT NULL,
    `BtypeDegree` char(2), 
    `Buniversity` varchar(81),
    `BGPA` char(4),
    `Bmajor` varchar(32),
    `ByearDegree` int (4),
    `MtypeDegree` varchar(3), 
    `Muniversity` varchar(81),
    `MGPA` char(4),
    `Mmajor` varchar(32),
    `MyearDegree` int (4),
    FOREIGN KEY (UID) references users(UID)
);

CREATE TABLE tests (
    `UID` int (8) NOT NULL,
    `quantitative` int(3),
    `verbal` int(3),
    `total` int(3),
    `GREdate` varchar(10),
    `TOEFLscore`varchar(3),
    `TOEFLdate` varchar(10),
    `subjectScore` int(3),
    `subject` varchar(21),
    `subjectDate` varchar(10),
    `subjectScore2` int(3),
    `subject2` varchar(21),
    `subjectDate2` varchar(10),
    `subjectScore3` int(3),
    `subject3` varchar(21),
    `subjectDate3` varchar(10),
    FOREIGN KEY (UID) references users(UID)
);

CREATE TABLE app (
    `UID` int (8) NOT NULL,
    `decisionStatus` varchar(20),
    `submissionStatus` varchar(20),
    `recStatus` varchar (20),
    `transcriptStatus` varchar(20),
    `degree` varchar (3),
    `appDate` varchar (12),
    `interests` varchar (100),
    `advisor` varchar (40),
    -- `recLetter` BLOB,  
    -- `letterID` int AUTO_INCREMENT
    -- `recEmail` varchar(62), 
    `workExperience` varchar(255),
    FOREIGN KEY (UID) references users(UID)
);

CREATE TABLE ratings (
    `UID` int (8) NOT NULL,
    `appDate` varchar(12) NOT NULL DEFAULT -1,
    `reviewerUID` int NOT NULL,
    `GASrating` int (1),
    `comments` varchar (100),
    `courses` varchar (100),
    `reason` char(1),
    `recRating` int(1),
    `generic` char(1),
    `credible` char(1),
    FOREIGN KEY (UID) references users(UID)
);

CREATE TABLE history (
    `UID` int (8) NOT NULL,
    `appID` int NOT NULL AUTO_INCREMENT,
    `decisionStatus` varchar(20),
    `avgGAS` float(2),
    -- `comments` varchar (100),
    -- `courses` varchar (100),
    -- `reason` char(1),
    `company` varchar(81),
    `avgRec` float(2),
    -- `generic` char(1),
    -- `credible` char(1),
    `degree` varchar (3),
    `appDate` varchar (12),
    `interests` varchar (100),
    `advisor` varchar (40),
    -- `recLetter` BLOB,  
    -- `recEmail` varchar(62), 
    `workExperience` varchar(255),
    `BtypeDegree` char(2), 
    `Buniversity` varchar(81),
    `BGPA` char(4),
    `Bmajor` varchar(32),
    `ByearDegree` int (4),
    `MtypeDegree` varchar(3), 
    `Muniversity` varchar(81),
    `MGPA` char(4),
    `Mmajor` varchar(32),
    `MyearDegree` int (4),
    `quantitative` int(3),
    `verbal` int(3),
    `subjectScore` int(3),
    `subject` varchar(21),
    `subjectScore2` int(3),
    `subject2` varchar(21),
    `subjectDate2` varchar(10),
    `subjectScore3` int(3),
    `subject3` varchar(21),
    `subjectDate3` varchar(10),
    `total` int(3),
    `GREdate` varchar(10),
    `subjectDate` varchar(10),
    `TOEFLscore`varchar(3),
    `TOEFLdate` varchar(10),
    PRIMARY KEY (appID),
    FOREIGN KEY (UID) references users(UID)
);

CREATE TABLE recommenders (
    `email` varchar (62) NOT NULL,
    `title` varchar(20),
    `fname` varchar(50), 
    `minit` char(1),
    `lname` varchar(50),
    `password` varchar(40),
    `company` varchar(81),
    PRIMARY KEY (email) 
);

CREATE TABLE `uploads` (
    `UID` int (8) NOT NULL,
    `fileName` varchar(255), 
    `recEmail` varchar(62), 
    `recStatus` varchar (20),
 FOREIGN KEY (UID) references users(UID)
); 

-- CREATE TABLE `letters` (
--     `UID` int (8) NOT NULL,
--     `recLetter` BLOB, 
--     FOREIGN KEY (UID) references users(UID)
-- );

-- set foreign key checks before we insert data
SET FOREIGN_KEY_CHECKS=1;

-- Insert recommender 
INSERT INTO `recommenders` VALUES ('meadowsc@gwu.edu', 'Dr.', 'Roxana', '', 'Leontie', '$QLinjection!', 'George Washington University');

-- Insert Sys Admin
INSERT INTO `users` VALUES (11111112, 'sysAdmin', '$y$God!!', 'System', 'G', 'Admin', 222222222, 4, 'Joe M Street, Utah', 'sysAdminFake@gmail.com');

-- Insert Applicants
INSERT INTO `users` VALUES (55555555, 'johnnyL', 'phpStorm!', 'John', '', 'Lennon', 111111111, 0, '616 23rd St NW, Washington DC', 'johnnyL@yahoo.com');
INSERT INTO `users` VALUES (66666666, 'ringo', 'ringoLoveSQL', 'Ringo', '', 'Starr', 222111111, 0, '123 21st St NW, Washington DC', 'ringoS@gmail.com');

-- Insert Application
INSERT INTO `app` VALUES (55555555, 'Pending', 'Submitted', 'Not Received', 'Not Received', 'PhD', 'Fall 2020', 'Cloud computing', '', 'Undergrad research');


-- Insert into tests
INSERT INTO `tests` VALUES (55555555, 130, 130, 260, '08/06/2005', '250', '11/06/2005', 200, 'Biology', '12/30/2006', 150, 'Mathematics', '02/13/2002', 200, 'Physics', '02/13/2002');  


-- Insert into priorDegrees
INSERT INTO `priorDegrees` VALUES (55555555, 'BS', 'Georgetown University', 3.75, 'Computer Science', 2017, 'MS', 'UMass', 3.2, 'Math', 2019);


-- Insert Reviewers
INSERT INTO `users` VALUES (11113333, 'bhagahari', 'CedarLogic', 'Bhagirath', '', 'Narahari', 999999999, 1, 'SEH 2nd floor, Washington DC', 'narahari@aol.com');
INSERT INTO `users` VALUES (11114444, 'WoodH', 'weakPassword#', 'Heller', '', 'Wood', 333333333, 1, '1234 fake Avenue, Washington DC', 'heller@yahoo.com');
INSERT INTO `users` VALUES (11115555, 'pabloBolt', 'arduino$#!', 'Pablo', '', 'Frank-Bolton', 444444444, 3, '4567 idk Street NW, California', 'pablo@gmail.com');
INSERT INTO `users` VALUES (11116666, 'wood.Tim', 'openNet$!', 'Timothy', '', 'Wood', 101010101, 2, '640 24th Street, Washington DC', 'wood@gwu.edu');
