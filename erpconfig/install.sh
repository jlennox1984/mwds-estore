#!/bin/sh
#ESTORE ERP SETUP SCRIPT
#BY J Moncrieff

echo "Download Weberp"

init()
{
echo "#=======================================#"
echo "#-----ESTORE ERP DOWNLOAD--------------#"
echo "#Please Note  you will requre subversion#"
echo "#=======================================#"

echo "do you want to download  weberp to--> "$PWD"/mwds-estore yes/no"  
 read SELECTPATH
 case $SELECTPATH in
	yes|YES|Y|y) exec mkdir $PWD/mwds-estore
	echo "created $PWD/mwds-estore"
	SETPATH=$PWD/mwds-estore	
	;;
	
	no|NO|n|N) 
	echo "please enter your temp  path-->"
	read SETPATH
	mkdir  -p $SETPATH;;
esac
install
}
install()
{


	echo "please enter your path(WEBPATH) to the webserver ie /var/www/web1/weberp"
	read WEBPATH;

		
 cd $SETPATH
	svn co http://devel2.mwds.ca/svn/eshop/ .
	
	mkdir $WEBPATH	
	mv truck/*  $WEBPATH/
	
	cd erpconfig
	exec sh setup.sh


	 
}

init
