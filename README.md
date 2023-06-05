# Wonde API using CI4
A project that uses Codeigniter 4 and uses the Wonde API with an example school.

Codeigniter 4 docs: https://codeigniter.com/user_guide/intro/index.html

This project has an interface which allows us to view the teachers that are within a school, their timetable for the week and their students.

This is built in Codeigniter 4, which has an in built server we can use, so no need for docker to run this project.


# This is how the interface should look once set up is complete:

![Screenshot 2023-06-05 at 15 02 01](https://github.com/niall-decisiontime/wonde-api/assets/55992683/1a6e395a-c686-4523-ac09-257c9decd268)


# Steps to set up project

1. Copy this repository code to your machine. 
2.  Via the command line, cd into the directory where this project sits and run the spark command to get the localhost running. My folder structure is Projects > used_car_listings, so I will run the commands:
- `cd Projects`
- `cd wonde`
- `php spark serve`
3. You should now be able to access the site via: http://localhost:8080/
4. When you go to this URL you will see a list of teachers within the school


# Functionality

1. Select a teacher to see their classes and lessons for the week - the rows are clickable


<img width="1440" alt="Screenshot 2023-06-05 at 15 06 12" src="https://github.com/niall-decisiontime/wonde-api/assets/55992683/74aefcc5-e003-4213-82c2-4464761e41eb">


2. You will be directed to a screen that shows the timetable of the teachers classes, ordered by start time in ascending order.


<img width="1440" alt="Screenshot 2023-06-05 at 15 06 31" src="https://github.com/niall-decisiontime/wonde-api/assets/55992683/1fa0d603-195b-42e8-ae5f-7c8b67b6a3ae">


3. If you click on a lesson, you will be directed to the screen that shows all the students in the class


<img width="1440" alt="Screenshot 2023-06-05 at 15 07 25" src="https://github.com/niall-decisiontime/wonde-api/assets/55992683/b8ab8a90-2120-48df-b743-aa427d1014ab">


4. If you then click on a student, a modal will appear with their contact details: 


<img width="1440" alt="Screenshot 2023-06-05 at 15 09 13" src="https://github.com/niall-decisiontime/wonde-api/assets/55992683/2520c442-0494-4eaf-a29e-77bf9f62127e">
