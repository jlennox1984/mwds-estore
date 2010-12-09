Install Notes For Mahsie VERP  (GPL) Mahsie 2007
Release Date 10/2007
To Install Mahsie's Shopping cart . It is Recommended that you will be running it on a Linux or a Unix base Server. With Apache and Mysql PHP and SSH Access.

______________________________
1 Unpack verp_version.tar.gz i.e tar -zxvf verp_version.tar.gz
2. Create a new directoy in the web server content directoy ie mkdir home/apache/htdocs/verp this path  may be diffennt depanding on server configuration.
6 . upload the content of the tar ball to the directory  you just created.
4 . Now you have to run a sql  dump to create the datebase 
a. type mysql -p  then type in you password this will bring you to prompt like this mysql> 
type CREATE DATABASTE verp  then \q

b. mysql -p  verp  < verp_#version#.sql

5. now you have to  configure the CRM and the ERP Modules of Mahsie VERP
A. Configure the erp Module
cd /home/apache/htdocs/verp/webERP edit config.php the most importent values are thoes values 



$host = 'localhost';

//The type of db server being used - currently only postgres or mysql
$dbType = 'mysql';
//$dbType = 'postgres';
//$dbType = 'mysql';

// sql user & password
$dbuser = 'root';
$dbpassword = '';

then create a directory with the name of the database name in the company directory (mkdir company/verp)


then edit include/login.php edit the company Variable <input type="hidden" name="CompanyNameField" value="verp">
													  ^name of dbase ie verp
                                                                                                                  
___________________________________________________________________________________________________________________________
B.
     go to the crm module directory 
         cd cd /home/apache/htdocs/verp/vtiger_crm  edit the  config.php   file 


 edit the Following Vailables

$dbconfig['db_host_name'] = 	'localhost:3306'; 	->Database server  on most configuration you can this alone
$dbconfig['db_user_name'] = 	'root';       		-> Database  username
$dbconfig['db_password'] = 		'';   		->Database Password
$dbconfig['db_name'] = 			'';    		->Database Name ie. verp
$dbconfig['db_type'] = 'mysql'; 			->Leave alone

 A couple lines blow this the two more Varibles to change

$site_URL = 'https/192.168.0.78/vtiger_crm'; 		->url of the  crm Module 

$root_directory = '/var/www/vtiger_crm/';  		-> Absolute  Path of crm Module
 

__________________________________________________________________________________
6 Permissions ***** IMPORTANT******************************************************
 Found Out what user is runing apache to do this type on most server this can  be determined  by this command  ps -aux |grep httpd which will give a out put like this
apache    4738  0.0  4.7  50540 24272 ?        S    Aug07   1:09 /usr/sbin/httpd
apache    4739  0.0  3.2  42940 16792 ?        S    Aug07   0:49 /usr/sbin/httpd
apache    4740  0.0  3.6  49428 18792 ?        S    Aug07   0:59 /usr/sbin/httpd
apache    4741  0.0  4.2  49328 21960 ?        S    Aug07   0:58 /usr/sbin/httpd
apache    4742  0.0  4.5  49396 23276 ?        S    Aug07   1:04 /usr/sbin/httpd
apache   23102  0.0  3.7  47156 19140 ?        S    Aug08   1:14 /usr/sbin/httpd
apache   23105  0.0  3.1  43924 16016 ?        S    Aug08   0:34 /usr/sbin/httpd
apache   23116  0.0  4.2  49376 22128 ?        S    Aug08   0:54 /usr/sbin/httpd
apache   23117  0.0  3.5  49408 18104 ?        S    Aug08   1:12 /usr/sbin/httpd
apache   23198  0.0  4.7  50412 24472 ?        S    Aug08   1:16 /usr/sbin/httpd

^^^^^ username
 you have change onwer ship of the verp directory on the server you can  do this by issuing this command 
chown -R apache:nobody  /home/apache/htdocs/verp   this may take a copule of seconds to Process
	 ^user name
 Your are Ready to log in
ERP
__________
to Login to the ERP Module Point your Browser to http://YOURSEVERNAME/verp/webERP

Username:admin
Password:demo
_____________________
CRM
to Login to the ERP Module Point your Browser to http://YOURSEVERNAME/verp/vtiger_crm

Username:admin
Password:mahsie



