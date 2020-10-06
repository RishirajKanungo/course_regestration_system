-- set foreign keys to 0 before we create tables
SET FOREIGN_KEY_CHECKS=0;

-- drop all tables if they exist
DROP TABLE IF EXISTS users; -- same as user for ads and account for reg
DROP TABLE IF EXISTS priorDegrees; 
DROP TABLE IF EXISTS tests;
DROP TABLE IF EXISTS app;
DROP TABLE IF EXISTS ratings;
DROP TABLE IF EXISTS history;
DROP TABLE IF EXISTS recommenders;
DROP TABLE IF EXISTS letters;
DROP TABLE IF EXISTS uploads;

drop table if exists student;
drop table if exists alumni;
drop table if exists faculty;
drop table if exists grad_secretary;
drop table if exists courses;
drop table if exists transcript;
drop table if exists form1;
drop table if exists prereq;
drop table if exists section;
drop table if exists room;

-- create tables 
CREATE TABLE users ( -- same as user for ads and account for reg
    `UID` int NOT NULL AUTO_INCREMENT, 
    `username` varchar(20) NOT NULL,
    `password` varchar(40) NOT NULL,
    `fname` varchar(50) NOT NULL,
    `minit` char(1),
    `lname` varchar(50) NOT NULL,
    `ssn` char(9) NOT NULL,
/*
for typeUser: 
0 - applicant 
1 - faculty reviewer
2 - chair
3 - grad sec
4 - system admin
5 - student
6 - faculty
7 - registrar
8 - alumni
*/
    `typeUser` int(1) NOT NULL,
    `address` varchar(100) NOT NULL, 
    `email` varchar(62) NOT NULL,
    `dob` date, 
    PRIMARY KEY (UID)
);

create table student(
    `uid` int,
    `degree` varchar(30),
    `gpa` decimal(3,2),
    `advisor` int,
    `gradapp` int,
    `form1status` int,
    `major` varchar(32), 
    `admit_year` varchar(32),
    primary key (uid),
    foreign key (advisor) references faculty(uid)
);

create table alumni(
    `uid` int,
    `degree`varchar(30),
    `gpa` decimal(3,2),
    `gradyear` int,
    primary key (uid)
);

create table faculty(
    `uid` int,
    `advisee` int,
    primary key (uid),
    foreign key (advisee) references student(uid)
);

create table grad_secretary(
    `uid` int,
    primary key (uid)
);

create table courses(
    `uid` int auto_increment not null, 
    `dept` varchar(4),
    `cno` int, 
    `title` varchar(50),
    `credits` int,
    `p1dept` varchar(4),
    `p1cno` int,
    `p1uid` int,
    `p2uid` int,
    `p2dept` varchar(4),
    `p2cno` int,
    primary key (uid),
    foreign key (p1uid) references courses(uid),
    foreign key (p2uid) references courses(uid)
);

create table room (
        `uid` int auto_increment not null,
        `location` varchar(255),
        `capacity` int,
        primary key (uid)
);

create table section (
	`uid` int auto_increment not null,
	`section_num` int(4),
	`semester` varchar(10),
	`year` varchar(4),
	`f_id` int,
	`class_day` varchar(10),
	`start_time` varchar(10), 
	`end_time` varchar(5),
	`c_id` int,
	`room` int,
	primary key (uid),
	foreign key (c_id) references courses(uid),
	foreign key (room) references room(uid),
	foreign key (f_id) references faculty(uid)
);

create table transcript(
    `uid` int,
    `dept` varchar(4),
    `cno` int,
    `grade` varchar(2) check (grade in ("A", "A-", "B+", "B", "B-", "C+", "C", "F", "IP", null)),
    `sec_id` int,
    `inform1` bool,
    `status` varchar(15) check (status in ("Web Registered", "Advising Hold", null)),
    primary key (uid, dept, cno),
    foreign key (uid) references student(uid),
    foreign key (sec_id) references section(uid)
);

create table prereq (
	`c_id` int not null,
	`prereq_id` int,
	primary key (c_id,prereq_id),
	foreign key (c_id) references courses(uid),
	foreign key (prereq_id) references courses(uid)
);

create table form1(
    `uid` int,
    `dept` varchar(4),
    `cno` int,
    primary key (uid, dept, cno)
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
    `UID` int NOT NULL AUTO_INCREMENT,
    `decisionStatus` varchar(20),
    `submissionStatus` varchar(20),
    `recStatus` varchar (20),
    `transcriptStatus` varchar(20),
    `degree` varchar (3),
    `appDate` varchar (12),
    `interests` varchar (100),
    `advisor` varchar (40),
    `recLetter` TEXT,  
    `recEmail` varchar(62), 
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
    -- `coursess` varchar (100),
    -- `reason` char(1),
    `company` varchar(81),
    `avgRec` float(2),
    -- `generic` char(1),
    -- `credible` char(1),
    `degree` varchar (3),
    `appDate` varchar (12),
    `interests` varchar (100),
    `advisor` varchar (40),
    `recLetter` BLOB,  
    `recEmail` varchar(62), 
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

-- set foreign key checks before we insert data
SET FOREIGN_KEY_CHECKS=1;

-- Insert Registrar
INSERT INTO `users` VALUES (09090908, 'registrar', 'pass', 'Regis', '', 'Star', 123454321, 7, 'Star Street, Idaho', 'register@hotmail.com', NULL);

-- Insert Sys Admin
INSERT INTO `users` VALUES (11111112, 'sysAdmin', '$y$God!!', 'System', 'G', 'Admin', 222222222, 4, 'Joe M Street, Utah', 'sysAdminFake@gmail.com', NULL);

-- Insert Applicants
INSERT INTO `users` VALUES (55555555, 'johnnyL', 'phpStorm!', 'John', '', 'Lennon', 111111111, 0, '616 23rd St NW, Washington DC', 'johnnyL@yahoo.com', NULL);

INSERT INTO `users` VALUES (16666667, 'ringo', 'ringoLoveSQL', 'Ringo', '', 'Starr', 222111111, 0, '123 21st St NW, Washington DC', 'ringoS@gmail.com', NULL);

INSERT INTO `users` VALUES (00001234, 'louis', 'arm', 'Louis', '', 'Armstrong', 555111111, 0, 'Loser Street, Michigan', 'armstrong@hotmail.com', NULL);

INSERT INTO `history` (UID, decisionStatus, degree, appDate) 
VALUES (00001234, 'Reject', 'MS', 2017);

INSERT INTO `users` VALUES (00001235, 'franklinA', 'pass', 'Franklin', '', 'Aretha', 666111111, 0, '777 44th St NE, Washington DC', 'fretha@hotmail.com', NULL);

INSERT INTO `users` VALUES (00001236, 'santanaC', 'pass', 'Santana', '', 'Carlos', 777111111, 0, '427 10th St SE, Washington DC', 'santacl@gmail.com', NULL);

-- Insert Application
INSERT INTO `app` VALUES (55555555, 'Pending', 'Submitted', 'Received', 'Received', 'MS', 'Fall 2020', 'Cloud computing', '', 'good student', 'rishi@gwu.edu', 'Undergrad research');
INSERT INTO `app` VALUES (16666667, 'Pending', 'Submitted', 'Not Recieved', 'Received', 'MS', 'Fall 2020', 'Machine Learning', '', '', 'sreya@gwu.edu', 'Internship');


-- Insert into tests
INSERT INTO `tests` VALUES (55555555, 130, 130, 260, '08/06/2005', '250', '11/06/2005', 200, 'Biology', '12/30/2006', 150, 'Mathematics', '02/13/2002', 200, 'Physics', '02/13/2002');  


-- Insert into priorDegrees
INSERT INTO `priorDegrees` VALUES (55555555, 'BS', 'Georgetown University', 3.75, 'Computer Science', 2017, 'MS', 'UMass', 3.2, 'Math', 2019);


-- Insert Reviewers
-- INSERT INTO `users` VALUES (11113333, 'bhagahari', 'CedarLogic', 'Bhagirath', '', 'Narahari', 999999999, 1, 'SEH 2nd floor, Washington DC', 'narahari@aol.com', NULL);
-- INSERT INTO `users` VALUES (11114444, 'WoodH', 'weakPassword#', 'Shelly', '', 'Heller', 333333333, 1, '1234 fake Avenue, Washington DC', 'heller@yahoo.com', NULL);
-- INSERT INTO `users` VALUES (11117777, 'twood', 'pass', 'Tim', '', 'Wood', 001000101, 1, '6402 25th Street, Washington DC', 'timewood@gwu.edu', NULL);

-- Insert Grad Sec
INSERT INTO `users` VALUES (11115555, 'pabloBolt', 'arduino$#!', 'Pablo', '', 'Frank-Bolton', 444444444, 3, '4567 idk Street NW, California', 'pablo@gmail.com', NULL);

-- Insert Chair
INSERT INTO `users` VALUES (11116666, 'rob', 'pless', 'Robert', '', 'Pless', 101010101, 2, '640 24th Street, Washington DC', 'robertpless@gwu.edu', NULL);





-- Insert Faculty
insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (11113333, "bnarahari", "pass", 6, "Bhagirath", "Narahari", 11113333, "145 California Walkway", "bnarahari@gwu.com");

insert into faculty(uid)
values (11113333);

insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (11114444, 'WoodH', "pass", 6, "Shelly", "Heller", 12343342, "1234 fake Avenue, Washington DC", "heller@yahoo.com");


insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (11117778, "heller", "pass", 6, "Dr", "Heller", 11117778, "SEH 4th Floor", "heller@gwu.com");

insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (11117779, "timW", "pass", 6, "Tim", "Wood", 11117778, "SEH 4th Floor", "timforrest@gwu.com");

insert into faculty(uid) 
values (11117778), (11117779);

insert into faculty(uid) 
values (11114444);

insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (11117777, 'twood', 'pass', 6, 'Tim', 'Wood', 001000101, '6402 25th Street, Washington DC', 'timewood@gwu.edu');

insert into faculty(uid) 
values (11117777);

insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (11119999, "gabe", "parmer", 6, "Gabe", "Parmer", 11117777, "SEH 4th Floor", "parmer@gwu.com");

insert into faculty(uid)
values (11119999);

insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (1118888, "sarah", "morin", 6, "Sarah", "Morin", 11118888, "SEH 4th Floor", "morin@gwu.com");

insert into faculty(uid) 
values (1118888);

insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (11234567, "hchoi", "pass", 6, "Hyeong-Ah", "Choi", 321321321, "992 Utah Drive", "hchoi@gwu.edu");

insert into faculty(uid)
values (11234567);

insert into users(uid, username, password, typeUser, fname, lname, ssn, address, email)
values (11444777, "kdeems", "pass", 6, "Kevin", "Deems", 561321321, "992 Boston Drive", "kdeems@gwu.edu");

insert into faculty(uid)
values (11444777);

-- Insert Students
INSERT INTO `users` VALUES (88888888, 'bholiday', 'pass', 'Billie', '', 'Holiday', 123412341, 5, '199 Fake Drive, Seattle', 'bholiday@hotmail.com', NULL);
INSERT INTO `student` VALUES (88888888, 'MS', NULL, 1118888, NULL, 0, 'Computer Science', '2018');

INSERT INTO `users` VALUES (99999999, 'dkrall', 'pass', 'Diana', '', 'Krall', 123232341, 5, '209 Real Drive, Chicago', 'dkrall@hotmail.com', NULL);
INSERT INTO `student` VALUES (99999999, 'MS', NULL, 11119999, NULL, 0, 'Computer Science', '2019');

INSERT INTO `users` VALUES (23456789, 'efitz', 'pass', 'Ella', '', 'Fitzgerald', 993232341, 5, '990 Fall Road, Utah', 'efitz@hotmail.com', NULL);
INSERT INTO `student` VALUES (23456789, 'PhD', NULL, 11113333, NULL, 0, 'Computer Science', '2019');

INSERT INTO `users` VALUES (87654321, 'ecass', 'pass', 'Eva', '', 'Cassidy', 773432341, 5, '1990 Spring Road, Texas', 'ecass@hotmail.com', NULL);
INSERT INTO `student` VALUES (87654321, 'MS', NULL, 11114444, NULL, 0, 'Computer Science', '2017');

INSERT INTO `users` VALUES (45678901, 'jhendrix', 'pass', 'Jimi', '', 'Hendrix', 763632341, 5, '1990 Summer Road, California', 'jhen@hotmail.com', NULL);
INSERT INTO `student` VALUES (45678901, 'MS', NULL, 11117777, NULL, 0, 'Computer Science', '2017');

INSERT INTO `users` VALUES (14444444, 'mpaul', 'pass', 'Paul', '', 'McCartney', 863631341, 5, '1990 Hot Road, California', 'mpaul@hotmail.com', NULL);
INSERT INTO `student` VALUES (14444444, 'MS', NULL, 11113333, NULL, 0, 'Computer Science', '2017');

INSERT INTO `users` VALUES (16666666, 'gharrison', 'pass', 'Geroge', '', 'Harrison', 333631341, 5, '90 Circular Drive, Florida', 'garrison@hotmail.com', NULL);
INSERT INTO `student` VALUES (16666666, 'MS', NULL, 11117777, NULL, 0, 'Computer Science', '2016');

INSERT INTO `users` VALUES (12345678, 'snicks', 'pass', 'Stevie', '', 'Nicks', 443631331, 5, '90 Degree Fields, Florida', 'snicks@hotmail.com', NULL);
INSERT INTO `student` VALUES (12345678, 'PhD', NULL, 1118888, NULL, 0, 'Computer Science', '2017');

-- Insert Alumni
INSERT INTO `users` VALUES (77777777, 'eclapton', 'pass', 'Eric', '', 'Clapton', 883691331, 8, '2000 Waterpond Fields, Florida', 'eclapton@hotmail.com', NULL);
INSERT INTO `student` VALUES (77777777, 'MS', NULL, NULL, NULL, 0, 'Computer Science', '2010');
INSERT INTO `alumni` VALUES (77777777, 'MS', NULL, 2014);

INSERT INTO `users` VALUES (34567890, 'kcobain', 'pass', 'Kurt', '', 'Cobain', 983691001, 8, '2000 Lakeside Fields, Cleveland', 'kcobain@hotmail.com', NULL);
INSERT INTO `student` VALUES (34567890, 'PhD', NULL, 11119999, NULL, 0, 'Computer Science', '2011');
INSERT INTO `alumni` VALUES (34567890, 'PhD', NULL, 2015);


-- Insert Courses
insert into courses(uid, cno, dept, title, credits)
values (1, 6221, "CSCI", "SW Paradigms", 3);

insert into courses(uid, cno, dept, title, credits)
values (2, 6461, "CSCI", "Computer Architecture", 3);

insert into courses(uid, cno, dept, title, credits)
values (3, 6212, "CSCI", "Algorithms", 3);

insert into courses(uid, cno, dept, title, credits)
values (4, 6220, "CSCI", "Machine Learning", 3);

insert into courses(uid, cno, dept, title, credits)
values (5, 6232, "CSCI", "Networks 1", 3);

insert into courses(uid, cno, dept, title, credits)
values (6, 6233, "CSCI", "Networks 2", 3);

insert into prereq(c_id, prereq_id) 
values (6, 5);

insert into courses(uid, cno, dept, title, credits)
values (7, 6241, "CSCI", "Database 1", 3);

insert into courses(uid, cno, dept, title, credits)
values (8, 6242, "CSCI", "Database 2", 3);

insert into prereq(c_id, prereq_id)
values (8, 7);

insert into courses(uid, cno, dept, title, credits)
values (9, 6246, "CSCI", "Compilers", 3);

insert into prereq(c_id, prereq_id) 
values (9, 2);

insert into prereq(c_id, prereq_id)
values (9, 3);

insert into courses(uid, cno, dept, title, credits)
values (10, 6260, "CSCI", "Multimedia", 3);

insert into courses(uid, cno, dept, title, credits)
values (11, 6251, "CSCI", "Cloud Computing", 3);

insert into prereq(c_id, prereq_id) 
values (11, 2);

insert into courses(uid, cno, dept, title, credits)
values (12, 6254, "CSCI", "SW Engineering", 3);

insert into prereq(c_id, prereq_id) 
values (12, 1);

insert into courses(uid, cno, dept, title, credits)
values (13, 6262, "CSCI", "Graphics 1", 3);

insert into courses(uid, cno, dept, title, credits)
values (14, 6283, "CSCI", "Security 1", 3);

insert into prereq(c_id, prereq_id) 
values (14, 3);

insert into courses(uid, cno, dept, title, credits)
values (15, 6284, "CSCI", "Cryptography", 3);

insert into prereq(c_id, prereq_id) 
values (15, 3);

insert into courses(uid, cno, dept, title, credits)
values (16, 6286, "CSCI", "Network Security", 3);

insert into prereq(c_id, prereq_id) 
values (16, 14);

insert into prereq(c_id, prereq_id)
values (16, 5);

insert into courses(uid, cno, dept, title, credits)
values (17, 6325, "CSCI", "Algorithms 2", 3);

insert into prereq(c_id, prereq_id) 
values (17, 3);

insert into courses(uid, cno, dept, title, credits)
values (18, 6339, "CSCI", "Embedded Systems", 3);

insert into prereq(c_id, prereq_id) 
values (18, 2);

insert into prereq(c_id, prereq_id)
values (18, 3);

insert into courses(uid, cno, dept, title, credits)
values (19, 6384, "CSCI", "Cryptography 2", 3);

insert into prereq(c_id, prereq_id) 
values (19, 15);

insert into courses(uid, cno, dept, title, credits)
values (20, 6241, "ECE", "Communication Theory", 3);

insert into courses(uid, cno, dept, title, credits)
values (21, 6242, "ECE", "Information Theory", 2);

insert into courses(uid, cno, dept, title, credits)
values (22, 210, "MATH", "Logic", 2);

-- Insert Sections
-- SW Paradigms
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id, f_id) 
values (1, 1, "Spring", "2020", "M", "15:00", "17:30", 1, 11234567);
-- Arch
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id, f_id) 
values (2, 1, "Spring", "2020", "T", "15:00", "17:30", 2, 11113333);
-- Algo
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id, f_id) 
values (3, 1, "Spring", "2020", "W", "15:00", "17:30", 3, 11234567);
-- Network 1
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id, f_id) 
values (4, 1, "Spring", "2020", "M", "18:00", "20:30", 5, 11234567);
-- Network 2
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id, f_id) 
values (5, 1, "Spring", "2020", "T", "18:00", "20:30", 6, 11117777);
-- DB 1
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id, f_id) 
values (6, 1, "Spring", "2020", "W", "18:00", "20:30", 7, 11444777);
-- DB 2
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id, f_id) 
values (7, 1, "Spring", "2020", "R", "18:00", "20:30", 8, 11117777);
-- Compilers
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (8, 1, "Spring", "2020", "T", "15:00", "17:30", 9);
-- Cloud Computing
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (9, 1, "Spring", "2020", "M", "18:00", "20:30", 11);
-- SW Eng
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (10, 1, "Spring", "2020", "M", "15:30", "18:00", 12);
-- Multimedia
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (11, 1, "Spring", "2020", "R", "18:00", "20:30", 10);
-- Graphics 1
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (12, 1, "Spring", "2020", "W", "18:00", "20:30", 13);
-- Security 1
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (13, 1, "Spring", "2020", "T", "18:00", "20:30", 14);
-- Crypto
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (14, 1, "Spring", "2020", "M", "18:00", "20:30", 15);
-- NW Security
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (15, 1, "Spring", "2020", "W", "18:00", "20:30", 16);
-- Crypto 2
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (16, 1, "Spring", "2020", "W", "15:00", "17:30", 19);
-- Comm Theory
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (17, 1, "Spring", "2020", "M", "18:00", "20:30", 20);
-- Info Theory
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (18, 1, "Spring", "2020", "T", "18:00", "20:30", 21);
-- Logic
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (19, 1, "Spring", "2020", "W", "18:00", "20:30", 22);
-- Embedded Sys
insert into section(uid, section_num, semester, year, class_day, start_time, end_time, c_id) 
values (20, 1, "Spring", "2020", "R", "16:00", "18:30", 18);

-- students
INSERT INTO `users` VALUES (99999999, 'kall', 'pass', 'Krall', '', 'Diana', 123412311, 5, '199 Fake Drive, Seattle', 'bkrall@hotmail.com', NULL);
INSERT INTO `student` VALUES (99999999, 'MS', NULL, 11117777, NULL, 0, 'Computer Science', '2019');

INSERT INTO `users` VALUES (23456789, 'Ella', 'pass', 'Fitzgerald', '', 'Diana', 123414311, 5, '199 Fake Drive, Seattle', 'ella@hotmail.com', NULL);
INSERT INTO `student` VALUES (23456789, 'PhD', NULL, 11113333, NULL, 0, 'Computer Science', '2019');


INSERT INTO `users` VALUES (87654321, 'Eva123', 'pass', 'Cassidy', '', 'Eva', 123415311, 5, '199 Fake Drive, Seattle', 'eva@hotmail.com', NULL);
INSERT INTO `student` VALUES (87654321, 'MS', NULL, 11117778, NULL, 0, 'Computer Science', '2017');
insert into transcript(sec_id, uid, cno, grade, dept, status , inform1) values 
(2, 87654321, 6221, "A", "CSCI", "Completed", true),
(2, 87654321, 6212, "A", "CSCI", "Completed", true),
(2, 87654321, 6461, "A", "CSCI", "Completed", true),
(2, 87654321, 6232, "A", "CSCI", "Completed", true),
(2, 87654321, 6233, "A", "CSCI", "Completed", true),
(2, 87654321, 6284, "A", "CSCI", "Completed", true),
(2, 87654321, 6286, "A", "CSCI", "Completed", true),
(2, 87654321, 6241, "C", "CSCI", "Completed", true),
(2, 87654321, 6246, "C", "CSCI", "Completed", true),
(2, 87654321, 6262, "C", "CSCI", "Completed", true);
insert into form1(uid, cno, dept) values 
(87654321, 6221, "CSCI"),
(87654321, 6212, "CSCI"),
(87654321, 6461, "CSCI"),
(87654321, 6232, "CSCI"),
(87654321, 6233, "CSCI"),
(87654321, 6284, "CSCI"),
(87654321, 6286, "CSCI"),
(87654321, 6241, "CSCI"),
(87654321, 6246, "CSCI"),
(87654321, 6262, "CSCI");


INSERT INTO `users` VALUES (45678901, 'JimiH', 'pass', 'Hendrix', '', 'Jimi', 123416311, 5, '199 Fake Drive, Seattle', 'jhendrix@hotmail.com', NULL);
INSERT INTO `student` VALUES (45678901, 'MS', NULL, 11117779, NULL, 0, 'Computer Science', '2017');
insert into transcript(sec_id, uid, cno, grade, dept, status) values 
(2, 45678901, 6221, "A", "CSCI", "Completed"),
(2, 45678901, 6212, "A", "CSCI", "Completed"),
(2, 45678901, 6461, "A", "CSCI", "Completed"),
(2, 45678901, 6232, "A", "CSCI", "Completed"),
(2, 45678901, 6233, "A", "CSCI", "Completed"),
(2, 45678901, 6284, "A", "CSCI", "Completed"),
(2, 45678901, 6286, "A", "CSCI", "Completed"),
(2, 45678901, 6241, "A", "CSCI", "Completed"),
(2, 45678901, 6241, "B", "ECE", "Completed"),
(2, 45678901, 6242, "B", "ECE", "Completed"),
(2, 45678901, 6210, "B", "MATH", "Completed");

INSERT INTO `users` VALUES (1444444, 'paulM', 'pass', 'McCartney', '', 'Paul', 123417311, 5, '199 Fake Drive, Seattle', 'pMaul@hotmail.com', NULL);
INSERT INTO `student` VALUES (1444444, 'MS', NULL, 11113333, NULL, 0, 'Computer Science', '2017');
insert into transcript(sec_id, uid, cno, grade, dept, status , inform1) values 
(2, 1444444, 6221, "A", "CSCI", "Completed", true),
(2, 1444444, 6212, "A", "CSCI", "Completed", true),
(2, 1444444, 6461, "A", "CSCI", "Completed", true),
(2, 1444444, 6232, "A", "CSCI", "Completed", true),
(2, 1444444, 6233, "A", "CSCI", "Completed", true),
(2, 1444444, 6241, "B", "CSCI", "Completed", true),
(2, 1444444, 6246, "B", "CSCI", "Completed", true),
(2, 1444444, 6262, "B", "CSCI", "Completed", true),
(2, 1444444, 6283, "B", "CSCI", "Completed", true),
(2, 1444444, 6242, "B", "CSCI", "Completed", true);
insert into form1(uid, cno, dept) values 
(1444444, 6221, "CSCI"),
(1444444, 6212, "CSCI"),
(1444444, 6461, "CSCI"),
(1444444, 6232, "CSCI"),
(1444444, 6233, "CSCI"),
(1444444, 6241, "CSCI"),
(1444444, 6246, "CSCI"),
(1444444, 6262, "CSCI"),
(1444444, 6283, "CSCI"),
(1444444, 6242, "CSCI");


INSERT INTO `users` VALUES (16666666, 'HarryG', 'pass', 'Harrison', '', 'George', 123517311, 5, '199 Fake Drive, Seattle', 'harryG@hotmail.com', NULL);
INSERT INTO `student` VALUES (16666666, 'MS', NULL, 11117779, NULL, 0, 'Computer Science', '2016');
insert into transcript(sec_id, uid, cno, grade, dept, status) values 
(2, 16666666, 6242, "C", "ECE", "Completed"),
(2, 16666666, 6221, "B", "CSCI", "Completed"),
(2, 16666666, 6461, "B", "CSCI", "Completed"),
(2, 16666666, 6212, "B", "CSCI", "Completed"),
(2, 16666666, 6232, "B", "CSCI", "Completed"),
(2, 16666666, 6233, "B", "CSCI", "Completed"),
(2, 16666666, 6241, "B", "CSCI", "Completed"),
(2, 16666666, 6242, "B", "CSCI", "Completed"),
(2, 16666666, 6283, "B", "CSCI", "Completed"),
(2, 16666666, 6284, "B", "CSCI", "Completed");


INSERT INTO `users` VALUES (12345678, 'nickS', 'pass', 'Nicks', '', 'Stevie', 123517621, 5, '199 Fake Drive, Seattle', 'nickG@hotmail.com', NULL);
INSERT INTO `student` VALUES (12345678, 'PhD', NULL, 1118888, NULL, 0, 'Computer Science', '2017');
insert into transcript(sec_id, uid, cno, grade, dept, status , inform1) values 
(2, 12345678, 6221, "A", "CSCI", "Completed", true),
(2, 12345678, 6212, "A", "CSCI", "Completed", true),
(2, 12345678, 6461, "A", "CSCI", "Completed", true),
(2, 12345678, 6232, "A", "CSCI", "Completed", true),
(2, 12345678, 6233, "A", "CSCI", "Completed", true),
(2, 12345678, 6284, "A", "CSCI", "Completed", true),
(2, 12345678, 6286, "A", "CSCI", "Completed", true),
(2, 12345678, 6241, "B", "CSCI", "Completed", true),
(2, 12345678, 6246, "B", "CSCI", "Completed", true),
(2, 12345678, 6262, "B", "CSCI", "Completed", true),
(2, 12345678, 6283, "B", "CSCI", "Completed", true),
(2, 12345678, 6242, "B", "CSCI", "Completed", true);








-- Insert Transcript
insert into transcript(sec_id, uid, cno, grade, dept, status)
values (2, 88888888, 2, "IP", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (3, 88888888, 3, "IP", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (1, 87654321, 1, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (3, 87654321, 3, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (2, 87654321, 2, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (4, 87654321, 5, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (5, 87654321, 6, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (14, 87654321, 15, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (15, 87654321, 16, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (6, 87654321, 7, "C", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (8, 87654321, 9, "C", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (12, 87654321, 13, "C", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (1, 45678901, 1, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (3, 45678901, 3, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (2, 45678901, 2, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (4, 45678901, 5, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (5, 45678901, 6, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (14, 45678901, 15, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (15, 45678901, 16, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (6, 45678901, 7, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (17, 45678901, 20, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (18, 45678901, 21, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (19, 45678901, 22, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (1, 14444444, 1, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (3, 14444444, 3, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (2, 14444444, 2, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (4, 14444444, 5, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (5, 14444444, 6, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (6, 14444444, 7, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (8, 14444444, 9, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (12, 14444444, 13, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (13, 14444444, 14, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (7, 14444444, 8, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (18, 16666666, 21, "C", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (1, 16666666, 1, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (2, 16666666, 2, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (3, 16666666, 3, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (4, 16666666, 5, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (5, 16666666, 6, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (6, 16666666, 7, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (7, 16666666, 8, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (13, 16666666, 14, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (14, 16666666, 15, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (1, 12345678, 1, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (2, 12345678, 2, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (3, 12345678, 3, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (4, 12345678, 5, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (5, 12345678, 6, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (14, 12345678, 15, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (15, 12345678, 16, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (6, 12345678, 7, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (8, 12345678, 9, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (12, 12345678, 13, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (13, 12345678, 14, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (7, 12345678, 8, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (1, 77777777, 1, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (2, 77777777, 2, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (3, 77777777, 3, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (4, 77777777, 5, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (5, 77777777, 6, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (6, 77777777, 7, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (7, 77777777, 8, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (13, 77777777, 14, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (14, 77777777, 15, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (15, 77777777, 16, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (1, 34567890, 1, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (2, 34567890, 2, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (3, 34567890, 3, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (4, 34567890, 5, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (5, 34567890, 6, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (6, 34567890, 7, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (13, 34567890, 14, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (14, 34567890, 15, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (15, 34567890, 16, "A", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (7, 34567890, 8, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (9, 34567890, 11, "B", "CSCI", "Web Registered");

insert into transcript(sec_id, uid, cno, grade, dept, status)
values (10, 34567890, 12, "B", "CSCI", "Web Registered");
