#!/bin/sh
#ESTORE ERP SETUP SCRIPT
#BY J Moncrieff


jomsetup()
{
	sed -e "s|ABSPATH|$PATHSC|" -e "s|DBNAME|$DBNAME|" -e "s|DBPASS|$DBPASS|" -e "s|SITENAME|$SITENAME|" -e "s|DBUSER|$DBUSER|"  -e "s|LIVESITE|$SITE|" configuration.php > $PATHSC/configuration.php

	sed -e "s|SERCURE_URL|$SURL|" administrator/components/com_virtuemart/virtuemart.cfg.php > $PATHSC/administrator/components/com_virtuemart/virtuemart.cfg.php
}
erpsetup()
{
#Create config file for erp

	sed -e "s|DBUSER|$DBUSER|" -e "s|DBPASS|$DBPASS|" internal/webERP/config.php > $PATHSC/internal/webERP/config.php

#Create Company Profile
	cp -r  $PATHSC/internal/webERP/companies/verp_demo/  $PATHSC/internal/webERP/companies/$DBNAME

##Create login page
	sed -e "s|DBNAME|$DBNAME|" internal/webERP/includes/Login.php > $PATHSC/internal/webERP/includes/Login.php
##Create estore.conf.php
	sed  -e "s|LIVESITE|$SITE|" -e "s|ABSPATH|$PATHSC|"  internal/webERP/estore.conf.php > $PATHSC/internal/webERP/estore.conf.php
#############################################################################################################



}

vtsetup()
{


#Create Vtiger Config file


	sed -e "s|DBUSER|$DBUSER|" -e "s|DBPASS|$DBPASS|" -e "s|DBNAME|$DBNAME|" -e "s|LIVESITE|$SITE/internal/vtiger_crm/|" internal/vtiger_crm/config.php > $PATHSC/internal/vtiger_crm/config.php

}

dbsetup()
{

echo " Please excute this command  to init the database mysql -u -p$DBPASS $DBNAME < $PWD/../sql/ERP_MWDS.sql"
}

init()
{
echo "#=======================================#"
echo "#-----ESTORE ERP SETUP SCRIPT-----------#"
echo "#=======================================#"
echo "please enter yours database Name-->"
read DBNAME
echo "please enter your Database User Name-->"
read DBUSER
echo "please enter your Database Password-->"
read DBPASS
echo "Please Enter the name of the site"
read $SITENAME

echo "Please enter the URL To you site-->"
read SITE
 if [-d $1]; then
	$1=$PATHSC	
	else
	echo "Please enter your  path->"
        read PATHSC

	fi
echo "Please enter Your Secure URL->"
read SURL
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
