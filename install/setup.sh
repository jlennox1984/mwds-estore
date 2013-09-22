#!/bin/bash
#ESTORE ERP SETUP SCRIPT
#BY J Moncrieff
ARGS=1
E_BADARGS=85
if [ $1 ]
 then

	echo $1
 	PATHSC=$1/webapp
else
 	echo "no path selected"
	 echo "Please enter your  path->"
        read PATHSC


fi

jomsetup()
{
echo "Path->" $PATHSC
echo "Jommla Setup"
	sed -e "s|ABSPATH|$PATHSC|" -e "s|DBNAME|$DBNAME|" -e "s|DBPASS|$DBPASS|" -e "s|SITENAME|$SITENAME|" -e "s|DBUSER|$DBUSER|"  -e"s|EMAIL_SITE|$EMAIL|" -e "s|LIVESITE|$SITE|" configuration.php > $PATHSC/configuration.php
	echo "Main configuration OK"
	sed -e "s|SERCURE_URL|$SURL/webapp/|" administrator/components/com_virtuemart/virtuemart.cfg.php > $PATHSC/administrator/components/com_virtuemart/virtuemart.cfg.php
	sed -e "s|DBUSER|$DBUSER|" -e "s|DBNAME|$DBNAME|" -e "s|DBPASS|$DBPASS|" -e "s|ABSPATH|$PATHSC|" -e "s|LIVESITE|$SITE|" internal/configuration.php.tmpl  > $PATHSC/internal/configuration.php
echo "Joomla setup Complete"
}

erpsetup()
{
#Create config file for erp
	echo "ERP Setup"
	sed -e "s|DBUSER|$DBUSER|" -e "s|DBPASS|$DBPASS|" internal/webERP/config.php > $PATHSC/internal/webERP/config.php


#Create Company Profile
	cp -r  $PATHSC/internal/webERP/companies/mobs/  $PATHSC/internal/webERP/companies/$DBNAME
	
##Create login page
	sed -e "s|DBNAME|$DBNAME|" internal/webERP/includes/Login.php > $PATHSC/internal/webERP/includes/Login.php
##Create estore.conf.php
	sed  -e "s|LIVESITE|$SITE|" -e "s|ABSPATH|$PATHSC|"  internal/webERP/estore.conf.php > $PATHSC/internal/webERP/estore.conf.php
#############################################################################################################
echo "ERP Setup Complete"


}

vtsetup()
{
echo "Vtiger Setup"

#Create Vtiger Config file


	sed -e "s|DBUSER|$DBUSER|" -e "s|DBPASS|$DBPASS|" -e "s|DBNAME|$DBNAME|" -e "s|LIVESITE|$SITE/internal/vtiger_crm/|" internal/vtiger_crm/config.php > $PATHSC/internal/vtiger_crm/config.php

echo "Vtiger Setup Complete"

}

dbsetup()
{
sed -e "s|LIVESITE|$SITE|" -e "s|LIVESITE1|$SITE|" sql/ERP_MWDS.sql > /tmp/ERP_MWDS.sql
echo "DB USER=>"$DBUSER
echo "DB Name=>"$DBNAME
echo  "Createing DB................."
cat << EOF| mysql -u$DBUSER -p$DBPASS 
                    CREATE DATABASE $DBNAME
EOF

echo  "Importing DATABASE"
mysql -u$DBUSER -p$DBPASS $DBNAME < /tmp/ERP_MWDS.sql

echo "Configuring DB"

cat <<EOF| mysql -u$DBUSER -p$DBPASS $DBNAME

 UPDATE config SET confvalue='companies/$DBNAME/' WHERE confname='part_pics_dir'

EOF

}

init()
{
echo "#=======================================#"
echo "#-----ESTORE ERP SETUP SCRIPT-----------#"
echo "#=======================================#"

echo "Please enter you stores email"
read EMAIL
echo "please enter yours database Name-->"
read DBNAME
echo "please enter your Database User Name-->"
read DBUSER
echo "please enter your Database Password-->"
read DBPASS
echo "Please Enter the name of the site"
read SITENAME

echo "Please enter the URL To you site-->"
read SITE
echo "Please enter Your Secure URL->"
read SURL
	echo $PATHSC
jomsetup
erpsetup
vtsetup
dbsetup
infodisplay

	
}
infodisplay()
	{
	echo "#==================================#"
	echo "#-------Site configuration---------#"
	echo "# Database Name->$DBNAME           #"
	echo "# Database User->$DBUSER		 #"
	echo "# Database Password-> 		 #"     
	echo "# Path->$PATHSC                    #"
	echo "# url->$SITE 			 #"
	echo "#==================================#"

	}




init
