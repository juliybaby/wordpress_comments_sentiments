# Wordpress Plugins Comments Sentimental Text Analysis

Inspiration
Wordpress is used by over one billion of people. Some used it to create blogs, publish Articles, create posts etc. They also exist over 60,000 wordpress plugins serving various needs like security plugins, E-commerce plugins, social Networks plugins, business plugins etc.
We created this Wordpress plugins to help us Analyze and visualize users/clients sentiments for every comments made on each posts, blogs, articles etc published on Wordpress.

You have site Visitors, users or Clients visiting and commenting on your wordpress published Posts, Articles, blogs etc. it is time to analyze their Comments using Expert.ai Sentiments and opinion mining API

Comments Sentimental Text Analytics for Wordpress Plugins
An interactive WordPress Plugins for analyzing and visualizing Sentimental Analysis on every WordPress Comments on a published Posts to determine:

1.) All the Characters, Entities and Keyphrases in a given Wordpress Comments/Text submitted by a Wordpress User on each Published Wordpress Posts.

2.) Wordpress Users Emotions like if the User is Sad or Happy or Satisfied via his Comments on each Published Wordpress Posts.

3.) Users Comments intents about certain Wordpress Posts. Eg Checking Users Comments Reaction for Positivity or Negativity or Neutrality on each Published Wordpress Posts

4.) Monitors Wordpress Users Statistical Comments Analysis over time to know The Wordpress Posts that is leading in the Wordpress Comments.

How it Works
Wordpress Admin Log into the Wordpress Admin section to create and Published a Post. Eg http://your-wordpress-site.com/wordpress_app/wp-admin/

The Visiting Wordpress Users/Clients after reading the Published Wordpress Posts Comments on it.

The Wordpress Admin login into the Wordpress Admin section, Click on the Plugin (Comments Sentimental Text Analytics for Wordpress Plugin) to View and Analyze all the comments submitted by various Wordpress visiting Users/Clients on every published Posts Sentimentally to determine the above 4 aforementioned Functions

How we Built it
Building any Wordpress Plugin requires the Wordpress developer to know the right Wordpress Hooks, Filter and Functions to Apply. Here I used wordpress Hooks and Filter for Comments to capture every users Comments on Wordpress published Posts, Blogs, Articles etc and then pass it to Expert.ai Sentiments and Opinion Mining API for Comments Sentimental Analysis.

Finally, the app is built with Sentiments and Opinion Mining API, Wordpress, php, mysql, Bootstrap, Ajax, Jquery etc.
 
 
How to Run the App Locally.

1.)Install xampp Server and ensure that php and mysql is running.

2.) Download wordpress from Wordpress Site and install it. At the time of writing, am using the latest version of wordpress 5.7.2
https://wordpress.org/download/


3.) Copy comment_text_analysis project folder and Navigate to wordpress plugin sections and paste/unzip it there. Eg.
C:\xampp\htdocs\wordpress_app\wp-content\plugins\comment_text_analysis

4.) Edit comment_text_analysis.php and comments_analyzed.php to reflect Expert.ai API credentials where appropriates.


5.) Login into Your Wordpress Admin Section to Install/Activate the Plugin.  Click on Plugin and select comment_text_analysis plugin and activate it. Once Activated,
you will see comment_text_analysis plugin at bottom left of the Wordpress Admin Panel.

 http://localhost/wordpress_app/wp-admin/



6.) Start Creating Posts, Articles or Blogs from your Wordpress admin Sections if you have not done so.

7.) Tell your site Visitors, Users etc to visit your Wordpress Posts, Blogs etc to read and Comment on it by visiting your wordpress site
Eg. http://localhost/wordpress_app or http://your-site.com/wordpress_app

8.) Each Cooments for any Published Wordpress Post is captured by Wordpress Hooks, Filter and Functions for further Sentimental analysis by Expert.ai API.

9.) The Site Admin can Login any time, then click on comment_text_analysis plugin at bottom left of the Wordpress Admin Panel to 
View and Analyze all the comments submitted by various Wordpress visiting Users/Clients on every published Posts Sentimentally 

