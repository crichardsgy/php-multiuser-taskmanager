<div id="top"></div>

<!-- PROJECT LOGO -->
<br />

<!-- GETTING STARTED -->
## Getting Started

A simple Xampp installation should be sufficient. However the tomsik68 Docker image for Xampp was utilized to develop the project.

### Prerequisites

NOTE: An internet connection is required to load crucial libraries such as Bootstrap and Chartjs.

Upon installing Xampp, navigate to the phpMyAdmin web interface and create a new database called 'taskmanager'.

OR

Use the SQL interactive shell bundled with Xampp.
* MySQL
  ```sql
  CREATE DATABASE taskmanager;
  ```

### Installation While Importing The SQL Dump

1. Copy the project folder to your HTDocs or www folder (do not open the web application before importing the SQL dump). 

2. Import the SQL dump into the taskmanager database (Either through phpMyAdmin or the interactive shell).

3. Navigate to the index.php page in your browser and log in with the credentials in the usage section.

### Installation Without Importing The SQL Dump

1. Copy the project folder to your HTDocs or www folder. 

2. Navigate to the index.php page in your browser to prepare the program for first use (this will run the initialization script which will create the relevant tables and create a default admin user with username and password 'admin'). See models/Database.php for troubleshooting.


<p align="right">(<a href="#top">back to top</a>)</p>


<!-- USAGE EXAMPLES -->
## Usage

NOTE: An internet connection is required to load crucial libraries such as Bootstrap and Chartjs.

Upon launch (after importing the SQL dump) the credenials in the below section can be used to log in via the index.html screen. From here, other accounts can be created and the main features of the application can be accessed.

OR

Upon first launch (without importing the SQL dump) a default admin account with the username and password "admin" will be created (kindly change accordingly). From here, other accounts can be created and the main features of the application can be accessed.

This application comprises of two views, the ADMIN user view and the NORMAL user view.

Admin users are able to:
* Manage tasks (i.e create, edit, delete, and change the status (i.e Complete or Incomplete) tasks) (Note: The delete button may be sent off the screen by the responsive table, scroll right to see it).
* Assign tasks to users
* View all tasks and their respective assignments
* Search for tasks via the name of who they're assigned to
* View the task completion graph dashboard
* Manage users (i.e create, edit, delete, and change the roles of users)

Normal users are able to:
* View tasks assigned to them
* Change the status of tasks (i.e Complete or Incomplete)

### Notable Credentials From The SQL Dump (Username -- Password):

Admin Accounts:
* testadmin1 -- admin
* admin -- 333

Normal Accounts:
* seconduser -- 333
* testman -- 333
* Jacob -- 333
* Alexone -- 333
* DoctorStrange -- 333
* colmchris -- 333
* JamesTKirk -- 333
* JeanLuc -- 333


<p align="right">(<a href="#top">back to top</a>)</p>


<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

References to resources that were useful to the development of this project.

* [How to create a filter table with JavaScript](https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_filter_table)
* [Toggle between hiding and showing an element with JavaScript](https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_toggle_hide_show)
* [How to Create A Bar Chart With Chart.js](https://www.w3schools.com/js/tryit.asp?filename=tryai_chartjs_bars_colors_more)
* [ChartJS-PieChart](https://github.com/WebDevSHORTS/ChartJS-PieChart/blob/master/js/script.js)
* [How To Create A Login System In PHP For Beginners | Procedural MySQLi | PHP Tutorial](https://www.youtube.com/watch?v=gCo6JqGMi30)
* [Build A Login System in PHP With MVC & PDO | Includes Forgotten Password](https://www.youtube.com/watch?v=lSVGLzGBEe0)
* [Buttons - Bootstrap](https://getbootstrap.com/docs/4.0/components/buttons/)
* [Best README Template](https://github.com/othneildrew/Best-README-Template/blob/master/README.md)

<p align="right">(<a href="#top">back to top</a>)</p>


