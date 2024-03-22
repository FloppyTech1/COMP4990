## File Descriptions

**common_functions.php**: Old Common PHP functions, including SELECT,
INSERT, UPDATE, and DELETE queries.

**config.php**: Old Configuration settings during initial setup of the
system, this includes phpdotenv setup, retrival of .env content, and
connection to the database and data warehouse sytem.

**db_functions.php**: Old Database-related PHP functions.

**dw_functions.php**: Old Data Warehouse-related PHP functions,
including performing ETL.

**vendor**: Directory for third-party libraries, this is created from
the setup of phpdotenv.

**.env**: Environment configuration file, contains login credentials of
the database and data warehouse sytem

**400.shtml**: Custom error page for HTTP status code 400 (Bad Request).

**401.shtml**: Custom error page for HTTP status code 401
(Unauthorized).

**403.shtml**: Custom error page for HTTP status code 403 (Forbidden).

**404.shtml**: Custom error page for HTTP status code 404 (Not Found).

**500.shtml**: Custom error page for HTTP status code 500 (Internal
Server Error).

**composer.json**: Composer configuration file.

**composer.lock**: Composer lock file.

**composer.phar**: Composer executable file.

**composer-install.php**: Composer installation script – might remove
this before submission.

**ReadMe.txt**: Source code information file.

**about_us.php:** This page is an about section for the hospital.

**admin_dashboard.php:** This page is the dashboard for administrators
where they have full access over the system.

**analytics.php:** This page is for administrators where they can view
analytics of the two hospital capmuses.

**appointments.php**: This page is for patient’s to view their current
and past appointments.

**billing.php**: This page is for patient’s to view their paid and
unpaid bills.

**contact_us.php:** This page contains contact information for the
hospital.

**db1_insert.txt**: Insert (in SQL format) data for source Database 1
(Windsor Campus).

**db2_insert.txt**: Insert (in SQL format) data for source Database 2
(London Campus).

**db_create.txt**: Create (in SQL format) for source Database 1 & 2
Schema (Windsor & London Campus).

**dw_create.txt**: Create (in SQL format) for Data Warehouse.

**dw_insert.txt**: Insert (in SQL format) data for Data Warehouse.

**employee_dashboard.php**: This page is the dashboard for doctors and
includes important information about their current patients and tasks.

**faq.php:** This page contains answers to frequently asked questions.

**forgot_password.php**: This page is used by users to reset their
passwords.

**index.css**: This CSS file contains styles for the index page.

**index.php**: This page is the landing page where users can login to
the software.

**logo.jpg**: This is the hospital logo.

**new.css**: This CSS file contains new styles for some pages.

**old.css**: This CSS file contains old styles for some pages.

**patient_dashboard.php**: This page is the dashboard for patients and
includes important information about their upcoming appointments and
treatments.

**prescriptions.php**: This page is where patients can view more
information about their active and past prescriptions.

**services.php:** This page contains information about the services the
hospitals offer.

**styleadmin.css:** This CSS file contains styles for the admin
dashboard and other admin pages.

**treatments.php**: This page is where patients can view more
information about their active and past treatments.

**view_appointments.php**: This page is where doctors can view their
current and upcoming appointments, as well as their past appointments.
They can also create appointments.

**view_patients.php**: This page is where doctors can view their current
and past patients.

**view_treatments.php**: This page is where doctors can view treatments
they are currently administering. They can also assign a prescription to
a patient.

## Installation Guides 

<u>Prerequisite:</u>

1.  A computer running Windows, MacOS, or any Linux distribution\*

2.  A good internet connection

3.  Global Protect: A virtual private network (VPN) client, to securely
    access the university CS Server \[11\]

    1.  Use the cited link to download, install, and set up the Global
        Protect VPN service on your machine.

4.  FileZilla: Install and configure FileZilla, to facilitate file
    transfer operations between your local machine and the CS Server.
    \[12\]

    1.  FileZilla Setup: (For Windows) Download and install FileZilla
        from the cited link. Follow the instructions of the installer.

    2.  After installation, sign in with the following credentials:

        1.  Host: \*.myweb.cs.uwindsor.ca (replace \* with your UWin ID)

        2.  Username: UWin ID

        3.  Password: UWin ID password (the login for UWinsite and your
            Microsoft services)

        4.  Port: 22

Check the following site for more details on the installations and
guides for web applications \[13\]

*Note: The specific requirements may vary depending on the software or
tools being installed. Ensure to review the individual setup
instructions for any additional prerequisites.*

<u>Instructions:</u>

1.  Download all necessary files from the GitHub page at
    <https://github.com/FloppyTech1/COMP4990>

    1.  After downloading all the files, extract the zip file (if not
        done so)

2.  Enable Global Protect (must!)

3.  Access the MyWeb web application at:
    <https://www.myweb.cs.uwindsor.ca/> and login using your
    credentials.

    1.  If you are not be able to login using your UWin ID credential,
        you might need to authenticate your account at:
        [https://auth.cs.uwindsor.ca](https://can01.safelinks.protection.outlook.com/?url=https%3A%2F%2Fauth.cs.uwindsor.ca%2F&data=05%7C02%7Cnguyen43%40uwindsor.ca%7C63804c16d4014d94a03c08dc15dfa12e%7C12f933b33d614b199a4d689021de8cc9%7C0%7C0%7C638409297419459147%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C3000%7C%7C%7C&sdata=2LNZwYs42iBvulx8sjQ3Umi%2F48W43XuoXWnxfi9ARIo%3D&reserved=0).
        If after authentication, it still isn’t working, contact your
        issue with <accounts@cs.uwindsor.ca>

    2.  If you don’t see a domain on the “domain” section top of the
        page, head to the Account Manager, Domain Setup and Add New.
        Here you can create your own domain name to access the webpage.

    3.  For database creation, head to Account Manager, Databases,
        Create, choose a name for the database (for the purpose of this
        project, create one for the database and the data warehouse). If
        wanted, choose Advanced Mode to create custom Username and
        Password. Afterward, record the database details, including the
        DB Name, DB User, and Password. You will need this to be able to
        access the database and data warehouse. Create as many databases
        as you need, this will represent the database sources.

    <!-- -->

    4.  Next, from the main dashboard, go to Account Manager, Extra
        Features. Setup phpMyAdmin by clicking on phpMyAdmin in the
        subsection. The site should automatically log in to phpMyAdmin
        of the domain chosen. Here, the user can choose to import or run
        SQL immediately using the offered function of phpMyAdmin. There
        should be the 3 databases on the left-hand side of the dashboard
        – one for database 1, database 2, and the other one for the data
        warehouse that the user has created. For uninterrupted approach,
        choose the desired database, click on the SQL option on top, and
        copy everything in the db_create.txt and dw_create.txt
        respectively (remember to remove the “Enable foreign key
        checks”. Click go. There should be no errors show up and all
        tables should be available after a quick browser refresh.

        1.  Optional: Installing Composer for self-hosting or fresh
            setup. The user can choose to setup from
            <https://getcomposer.org/download/> for local server or
            within the Extra Features of DirectAdmin, run
            composerinstall for the university server.

4.  Check if your domain works, the default configured domain name is
    [uwinid.myweb.cs.uwindsor.ca](https://uwin365-my.sharepoint.com/personal/nguyen43_uwindsor_ca/Documents/uwinid.myweb.cs.uwindsor.ca)
    exist (replace uwinid with your UWinID).

5.  Configure connection details into the .env file. There should be 2
    different credentials included. This is where all the database and
    data warehouse connections are set. All the files have reference to
    this .env file. The setup of Composer is for the .env file to work
    flawlessly on the server. See config.php file for more details about
    how to include .env file.

6.  Upload “necessary” files to the MyWeb

    1.  If using the included files, after downloading and extraction,
        open FileZilla, connect to the MyWeb server (in the prerequisite
        section). On the right section (remote site), bottom left box,
        scroll down to see public_html. Copy pastes all files into here.
        Check if it is working by going to the domain created there
        should be the login page created for the user to login, if not,
        create an account.

    2.  Import your own information to populate your database/data
        warehouse. The user can use phpMyAdmin to upload SQL code or
        import SQL files directly, refer to 3.4. For database instances,
        import using phpMyAdmin the file db1_insert.txt and
        db2_insert.txt into their respective database.

7.  Login credentials

    1.  If imported using the included file. Refer to the User Manual
        for login credentials. More credentials can be seen inside the
        downloaded file (db1_insert.txt and db2_insert.txt).

    2.  Creating password for User should comply with the “Best
        practices for passphrases and password” \[14\] by the Canadian
        Centre for Cyber Security

## User Manual

<u>Login Page</u>: This is the index page of the software. Users can
login as three different roles (Admin, Doctor, Patient) and into two
different campuses (Windsor, London). Below is login information for
both campuses for each role.

**For Patient:**

*Patient Dashboard:* A patient’s dashboard provides them with their
current appointments, treatments, unpaid bills, and active
prescriptions.

*Navigation and Functionality (Patient):* A patient has access to 5
different pages (Home, Appointments, Treatments, Prescriptions,
Billing). Aside from the dashboard, a patient can filter through his/her
information by using a search bar or a date filter. These can both be
found at the top of each page (excluding the dashboard).
