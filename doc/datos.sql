#course
INSERT INTO course (id,name,description) VALUES (1,'INTRO-1','Introduccion a la programacion');
INSERT INTO course (id,name,description) VALUES (2,'JAVA-2','Java avanzado');
# User
INSERT INTO user (id,username,email,password,enabled) VALUES (1,'rarce','rarce@uaa.edu.py','7c4a8d09ca3762af61e59520943dc26494f8941b',1);
INSERT INTO user (id,username,email,password,enabled) VALUES (1,'salcaraz','salcaraz@uaa.edu.py','7c4a8d09ca3762af61e59520943dc26494f8941b',1);
# User-Course
INSERT INTO user_course (user_id,course_id,is_prof) VALUES (1,1,1);
INSERT INTO user_course (user_id,course_id,is_prof) VALUES (1,2,0);
INSERT INTO user_course (user_id,course_id,is_prof) VALUES (2,2,1);
INSERT INTO user_course (user_id,course_id,is_prof) VALUES (2,1,0);
# File
INSERT INTO file (id,filename,date,description,path) VALUES(1,'datos.sql','0000-00-00','files/1-a28db39a730d5c28764c0aaa64e8089ee757e6c9');
INSERT INTO file (id,filename,date,description,path) VALUES(2,'filepush.sql','0000-00-00','files/2-42bd5bbffd8ebdbe39c735e0261e7055acdc9458');
# User_File
INSERT INTO user_file (user_id,file_id) VALUES (1,1);
INSERT INTO user_file (user_id,file_id) VALUES (1,1);
#File_course
INSERT INTO file_course (user_id,file_id) VALUES (2,2);
INSERT INTO file_course (user_id,file_id) VALUES (1,1);

