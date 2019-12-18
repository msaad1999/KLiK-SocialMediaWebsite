<p align="center">
  <img src="_git%20assets/cover.png" width="600" align="center"/>
</p>

> KLiK is a PHP based Information Pool System (or simply a Social Media Website), consisting of a complete Login/Registration system, User Profile system, Chat room, Forum system and Blog/Polls/Event Management System.


# Table of Contents

* [Installation](#installation)
  * [Requirements](#requirements)
  * [Installation Steps](#installation-steps)
  * [Getting Started](#getting-started)
* [Features](#Features)
* [Components](#Components)
  * [Languages](#Languages)
  * [Development Environment](#Development-Environment)
  * [Database](#database)
  * [DBMS](#DBMS)
  * [API](#api)
  * [Frameworks and Libraries](#Frameworks-and-Libraries)
  * [Techniques](#techniques)
  * [External PLugins](#external-plugins)
* [Details](#details)
* [Application Files](#application-files)
* [Future Improvements](#future-improvements)
* [The Team](#the-team)



## Installation

#### Requirements
* PHP
* Apache server
* MySQL Database
* SQL
* phpMyAdmin

> All of these requirements can be completed at once by simply installing a server stack like `Wamp` or `Xampp` etc.

#### Installation Steps
1. Import the `klik_database.sql` file in the `includes` folder into phpMyAdmin. There is no need for any change in the .sql file. This will create the database required for the application to function.

2. Edit the `dbh.inc.php` file in the `includes` folder to create the database connection. Change the password and username to the ones being used within current installation of `phpMyAdmin`. There is no need to change anything else.

```php
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "examplePassword";
$dBName = "klik_database";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3307);

if (!$conn)
{
    die("Connection failed: ". mysqli_connect_error());
}
```
> The port number does not need to be changed under normal circumstances, but if you are running into a problem or the server stack is installed on another port, feel free to change it, but do so carefully.

3. Edit the `email-server.php` file in the `includes` folder and change the variables accordingly:

  * `$SMTPuser` : email address on `gmail`
  * `$SMTPpwd` : email address password
  * `SMTPtitle` : hypothetical company's name
  * `Domain` : Domain of the website, like localhost on local server or if on live domain, something like www.hypotheticalwebsite.com

```php
$SMTPuser = 'klik.official.website@gmail.com';   
$SMTPpwd = 'some-example-password';
$SMTPtitle = "KLiK inc.";
$Domain = 'localhost';
```
> This step is mainly for setting up an email account to enable the `contact` and `password reset system`, all of which require mailing.

> In the current stage of the application, only `Gmail` accounts are supported.


#### Getting started
The database file already contains a lot of sample data and users. Most users in the database have the same password as their usernames except for a few. It is not possible to signup as an administrator through the application, since we decided that it was an exploitable weakness. Therefore, you will have to create an account and manually go to the `users` table in the database to change the userLevel of that account to `1` from `0`.
> 0 Level means a normal user and Level 1 means admin

A simple way to access all sample accounts without deleting them and hence losing all the sample data is to manually change their `email` from within phpMyAdmin to a valid email address. Then attempt login with that account using a wrong password, and use the provided `forgot password? link` to reset the accounts password. The account email can be safely changed again to anything trivial later on.


## Features

* [Application Dashboard](#application-Dashboard)
* [Login/Registration and User Authentication](#Login-Registration-and-User-Authentication)
* [User Profile System](#user-profile-system)
* [Inbox/Chat room](#chatroom-inbox)
* [Forum system](#management-systems)
* [Blog Management system](#management-systems)
* [Poll/Voting Management system](#management-systems)
* [Events Management System](#management-systems)
* [Security](#security)


## Components

#### Languages
```
PHP 5.6.40
SQL 14.0
JavaScript ES 6
HTML5
CSS3
```

#### Development Environment
```
WampServer Stack 3.0.6
Windows 10
```

#### Database
```
MySQL Database 8.0.13
```

#### DBMS
```
phpMyAdmin 4.8.3
```

#### API
```
MySQLi APIs
```

#### Frameworks and Libraries
```
JQuery v3.3.1
BootStrap v4.2.1
```

#### Techniques
```
AJAX
```

#### External Plugins
```
[PHPMailer 6.0.6](https://github.com/PHPMailer/PHPMailer)
```
> This was used for creating a `mail server` on `Windows localhost`, since unlike in Linux, there isnt one already installed in windows. This plugin was used for the sending and receiving of emails on localhost, and is not needed on a live domain

## Details

> Details of important Features of the Application

### Application Dashboard

<p align='center'>
  <img src="_git%20assets/dashboard.png" width="500" align="center"/>
</p>

The Dashboard provides a central interface to most features of the application. The `User profile card` on the upper left corner of the screen provides a profile summary, as well as a link to the profile and the profile-editing page. The creator button on the upper right corner provides a prominent link to the Team page, which showcases the `KLiK Creators`.

The 4 tab interface in the center provides access to `latest`, or most recently created `Forums`, `Blogs`, `Polls` and `Events`. The components show the individual characteristics of the respective elements, like total `upvotes` for a forum, `likes` for a blog, `votes` for a poll and `days remaining` for events. There are 2 more buttons, which go to the `KLiK Forums` (the central interface for the Forums) and the `KLiK Hub` (The central interface for the Blog, Poll and Event Management System).


### Management Systems

<p align="center">
  <img src="_git%20assets/management.png" width="600" align="center"/>
</p>

* `Forum System`:
  * Forum creation
  * Replying / posting messages in a forum
  * Forum categories
  * Admin's ability to create forum categories
  * upvote/ downvote system on forum replies (no repetition of voting etc possible)
  * ability to delete your own forum replies (admin can delete any)

* `Blog Management System`:
  * Blog creation
  * Choosing optional Blog cover image (there is a default image)
  * `Like` system on blogs (users can either like the blog or remove their like)
  * Deleting own blogs (admin can remove any)

* `Event Management System`:
  * Event Creation System
  * Choosing optional Event cover image (there is a default image)
  * Event Headline
  * Event Information (optional)
  * Setting Event Date
  * Real-Time countdown on Event page
  * Automatic marking as complete on passing event Date

* `Poll Management System`:
  * Poll Creation
  * Voting on poll
  * Changing / viewing current vote
  * Locked / Open polls (vote cannot be changed in locked polls)
  * Viewing Results [total users voting, no. of users voting for each option]
  * Separate page to view each poll option along with each and every user who had voted for it



### Login/Registration and User Authentication

<p>
  <img src="_git%20assets/login.png" width="400" align="right"/>
</p>

KLiK supports a complete login/registration and User Profile system. On startup, the application shows options for logging in, signing up or contacting the website admin via email. Each user can make a unique username which cannot be changed later. The user `passwords` are `hashed` before storing in database so even admins do not have access to the original passwords as well. Additional User information include `Full Name`, `email`, `Profile Image`, `Profile Headline`, `Gender` and `Bio`.

There is also a secure `Password Recovery System` which enables user to reset their passwords in a secure way. The app generates temporary encrypted token-links with a certain expiry time which when used by user prompts to change the password. Since that also requires current password, the process is secure and has lesser chances of exploitation.

The app uses several authentication methods for signing up and logging in. It checks for `empty fields`, `wrong username`, `wrong password`, `SQL errors`, `server errors` and in case of signing up, `corrupted image` or `wrong image type` errors

### User Profile System

<p>
  <img src="_git%20assets/profile.png" width="350" align="left"/>
</p>

KLiK has a complete `User profile system`. Each user is assigned a profile on signing up, with which the user can create Forums, Blogs, Events etc and interact with the app's features. The user's full name, headline and bio, as well as profile image are optional, meaning that anyone can signup without setting those. In that case, the user will be assigned a default user image and the headline, bio and full name will be empty.

The `user profile` can be accessed through the option in the settings menu on the navigation bar, or more simply, by clicking the user image on the user profile card, which is present on the top left corner of the app screen on most pages. The profile page shows the basic User information like username, full name, gender, headline and bio. Apart from that, it shows the different `Forums` and `Blogs` the User has created along with the `Polls` he/she has participated in. If in case the user has not done any of that or is new, the page shows a cute little bongo cat with a 'such empty' caption to remind you that you need to be more active :)

There is also a `Profile Editing System` which allows the User to edit his profile information. It can be accessed through the respective option in the settings menu in the navigation bar or by simply clicking the pencil icon next to the user profile image on the profile card. The system allows the user to change most of his information except for the username, which cannot be changed. All fields already have the current information, so the user does not have to type everything all over again if he only wishes to slightly edit the current information. The password can also be changed, however, only by providing the current password to retain a more secure interface.

### ChatRoom / Inbox

<p align="center">
  <img src="_git%20assets/inbox.png" width="600" align="center"/>
</p>

KLiK also has a chatbox, which uses `PHP` & `AJAX` for real-time chatting with other users. The section on the left is a list of all the users currently on the website, while the right chat screen is for displaying the ingoing and outgoing messages. A user can access a chat with a certain user by clicking on him/her in the users list, which will retrieve all the chat messages from the database. The ingoing and outgoing messages are styled differently in order to maintain readability. Chatting is done in real-time, without the need to refresh the page continuously.

**Possible Improvements**:
* `optimization`: All messages of a chat are retrieved at once, and this can cause delays if the chat is big. This can be fixed by implementing incremental load of messages to load only the messages being displayed on-screen.
* `user search`: A search feature can be implemented in the user list to directly search for a particular user, thus saving time.

### Security

* `Password hashing` before storing in database.
* Password Reset done through individually created `encrypted tokens` sent via email as a form of a link. The tokens have a certain expiry date after which they cannot be used.
* Filtering of information obtained from `$_GET` and `$_POST` methods to prevent `header injection`.
* Implementation of `MySQLi Prepared Statements` for **advanced** database security.

  **Example:**
```php
$sql = "select uidUsers from users where uidUsers=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $userName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
       }
```




## Application Files

> A list of all main Application Features and their respective front-end and back-end files.

|&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Feature &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;|Front-end Files| Back-end Files |
| ----------- | -- | -- |
|Dashboard| `index.php (Main Dashboard)`, `Forum.php`, `Hub.php`| N/A|
|Forum System| `categories.php`, `create-category`, `topics.php`, `create-topic.php`, `posts.php` |`create-category.inc.php`, `create-topic.inc.php`, `delete-category.php`, `delete-forum.php`, `delete-post.php`|
|Blog System| `blog-page.php`, `blogs.php`, `create-blog`| `blog-vote.inc.php`, `create-blog.inc.php`|
|Event System| `event-page.php`, `events.php`, `create-event.php`| `create-event.inc.php`|
|Poll System| `poll.php`, `polls.php`, `poll-voters.php`|`create-poll.inc.php`, `delete-poll.inc.php`, `poll.class.php`, `post-vote.inc.php`|
|Chat Room| `message.php`|`post_message_ajax.php`, `get_message_ajax.php`, `script.js`|
|Signup/ Login| `signup.php`, `login.php`| `signup.inc.php`, `login.inc.php`, `logout.inc.php`|
|Profile System| `profile.php`, `edit-profile.php` | `profileUpdate.inc.php`|
|Password Reset| `reset-pwd.php`, `create-new-pwd.php`|`reset-request.inc.php`|`reset-password.inc.php`|
|Image Upload| N/A| `upload.inc.php`|
|Creator Showcase| `team.php`, `KLiK_anas-imran.php`, `KLiK_anas-kamal.php`, `KLiK_saad.php`, `KLiK_ubaid.php`| N/A|
|Finding Users| `users-view.php`|N/A|

> **Note:** The GUI files are in the `root directory`, and the `backend files` are present in the `includes` folder. Similarly, all CSS and JS files are present in their prespective `css` & `js` directories. Only the Creator files in the `_KLiK Creators folder` have their own css files. The main HTML structuring files are the `HTML-head.php` and `HTML-footer.php`, which also reside in the includes folder


## Future Improvements
* Optimization (in components like chat room)
* Integration of advanced frameworks like `Laravel`
* Implementing `Vue.js` for chat room.
* Continuous Bug fixes and improvements

> If you liked my work, please show support by starring the repository! It means a lot to me, and is all im asking for.

## The Team

A huge thanks to the wonderful team without which this entire project would not have been possible. Check out our profiles and star our repos! :)

<img src="_git%20assets/me.png" width="150"/> | <img src="_git%20assets/kamal.png" width="150"/> | <img src="_git%20assets/ubaid.png" width="150"/> | <img src="_git%20assets/ait.png" width="150"/>
---|---|---|---
[msaad1999](https://github.com/msaad1999) | [skamal16](https://github.com/skamal16) | [UbaidAsim](https://github.com/aitasadduq) | [aitasadduq](https://github.com/aitasadduq)
