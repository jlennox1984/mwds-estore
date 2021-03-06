<?php

include('include/database/PearDatabase.php');
include('include/utils.php');

class DataMigration 
{
  var $oldconn;
  var $newconn;       

  function setupDBConnections()
  {
		  
    require_once('migrator_connection.php');
    require_once('config.php');

    echo '<br> the mysql host name of the 4.0.1 db is '.$mysql_host_name_old;
    echo '<br> the mysql port number of the 4.0.1 db is '.$mysql_port_old;
    echo '<br> the mysql username of the 4.0.1 db is '.$mysql_username_old;
    echo '<br> the mysql password of the 4.0.1 db is '.$mysql_password_old;
    
    
    $this->oldconn = new PearDatabase("mysql",$mysql_host_name_old.":".$mysql_port_old,"vtigercrm_4_0_1_bkp",$mysql_username_old,$mysql_password_old);

    $this->oldconn->connect();
   
    //$this->newconn = new PearDatabase("mysql",$dbconfig['db_host_name'],"vtigercrm4",$dbconfig['db_user_name'],$dbconfig['db_password']);
    //$this->newconn->connect();
	  
  }


  function preliminarySteps()
  {

echo '------------------------------------- test print -------------------------';
    echo '<br>+++++++++++++++++++++++++++++++++++++<br>';
    echo '<br><br>';
    echo '<br><font color=red><b>++PRELIMINARY STEPS FOR DATA MIGRATION INITIATED++</b></font><br>';
    echo '<br><br>';
    echo '<br>+++++++++++++++++++++++++++++++++++<br>';

    echo '<br><font color=green><b>set time limit to 600</b></font><br>';
    set_time_limit(0);
    ini_set("display_errors",'0');

  }

  function makechanges()
  {

    //table creation starts

    $sql90="drop table sefaqrel";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

//custom Action
$sql90 = "CREATE TABLE `customaction` (
  `cvid` int(19) default NULL,
  `subject` varchar(250) NOT NULL default '',
  `module` varchar(50) NOT NULL default '',
  `content` longtext,
  KEY `customaction_IDX0` (`cvid`)
) TYPE=InnoDB";
echo '<br> '.$sql90 .' <br> ';
$this->oldconn->query($sql90);


//convertleadmapping

$sql90="CREATE TABLE `convertleadmapping` (
         `cfmid` int(19) NOT NULL auto_increment,
   `leadfid` int(19) NOT NULL default '0',
  `accountfid` int(19) default NULL,
  `contactfid` int(19) default NULL,
  `potentialfid` int(19) default NULL,
  PRIMARY KEY  (`cfmid`)
) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    

    $sql90="CREATE TABLE `CustomerDetails` (
	  `customerid` int(19) NOT NULL default '0',
	    `portal` char(3) default NULL,
	      `support_start_date` date default NULL,
	        `support_end_date` date default NULL,
		  PRIMARY KEY  (`customerid`),
		    CONSTRAINT `fk_CustomerDetails` FOREIGN KEY (`customerid`) REFERENCES `contactdetails` (`contactid`) ON DELETE CASCADE
	    ) TYPE=InnoDB";
	    
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    $sql90="CREATE TABLE `PortalInfo` (
	  `id` int(11) NOT NULL default '0',
	    `user_name` varchar(50) default NULL,
	      `user_password` varchar(30) default NULL,
	        `type` varchar(5) default NULL,
		  `last_login_time` datetime NOT NULL default '0000-00-00 00:00:00',
		    `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
		      `logout_time` datetime NOT NULL default '0000-00-00 00:00:00',
		        `isactive` int(1) default NULL,
			  PRIMARY KEY  (`id`),
			    CONSTRAINT `fk_PortalInfo` FOREIGN KEY (`id`) REFERENCES `contactdetails` (`contactid`) ON DELETE CASCADE
		    ) TYPE=InnoDB";
	    
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    $sql90="CREATE TABLE `activity_reminder` (
	  `activity_id` int(11) NOT NULL default '0',
	    `reminder_time` int(11) NOT NULL default '0',
	      `reminder_sent` int(2) NOT NULL default '0',
	        `recurringid` int(19) NOT NULL default '0'
	) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `carrier` (
	  `carrierid` int(19) NOT NULL auto_increment,
	    `carrier` varchar(200) NOT NULL default '',
	      `sortorderid` int(19) NOT NULL default '0',
	        `presence` int(1) NOT NULL default '1',
		  PRIMARY KEY  (`carrierid`),
		    UNIQUE KEY `carrier_UK0` (`carrier`)
	    ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    /* 
    $sql90=" CREATE TABLE `currency_info` (
	  `currency_name` varchar(100) NOT NULL default '',
	    `currency_code` varchar(100) default NULL,
	      `currency_symbol` varchar(30) default NULL,
	        PRIMARY KEY  (`currency_name`)
	) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
    */


    $sql90="CREATE TABLE `customview` (
	  `cvid` int(19) NOT NULL default '0',
	    `viewname` varchar(100) NOT NULL default '',
	      `setdefault` int(1) default '0',
	        `setmetrics` int(1) default '0',
		  `entitytype` varchar(100) NOT NULL default '',
		    PRIMARY KEY  (`cvid`)
	    ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    $sql90="CREATE TABLE `customview_seq` (
		  `id` int(11) NOT NULL default '0'
	  ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `cvadvfilter` (
	  `cvid` int(19) default NULL,
	    `columnindex` int(11) NOT NULL default '0',
	      `columnname` varchar(250) default '',
	        `comparator` varchar(10) default '',
		  `value` varchar(200) default '',
		    KEY `cvadvfilter_IDX0` (`cvid`),
		      CONSTRAINT `cvadvfilter_FK1` FOREIGN KEY (`cvid`) REFERENCES `customview` (`cvid`) ON DELETE CASCADE
	      ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `cvcolumnlist` (
	  `cvid` int(19) default NULL,
	    `columnindex` int(11) NOT NULL default '0',
	      `columnname` varchar(250) default '',
	        KEY `cvcolumnlist_IDX0` (`cvid`),
		  CONSTRAINT `cvcolumnlist_FK1` FOREIGN KEY (`cvid`) REFERENCES `customview` (`cvid`) ON DELETE CASCADE
	  ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `cvstdfilter` (
	  `cvid` int(19) default NULL,
	    `columnname` varchar(250) default '',
	      `stdfilter` varchar(250) default '',
	        `startdate` date default '0000-00-00',
		  `enddate` date default '0000-00-00',
		    KEY `cvstdfilter_IDX0` (`cvid`),
		      CONSTRAINT `cvstdfilter_FK1` FOREIGN KEY (`cvid`) REFERENCES `customview` (`cvid`) ON DELETE CASCADE
	      ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `glacct` (
	  `glacctid` int(19) NOT NULL auto_increment,
	    `glacct` varchar(200) NOT NULL default '',
	      `sortorderid` int(19) NOT NULL default '0',
	        `presence` int(1) NOT NULL default '1',
		  PRIMARY KEY  (`glacctid`),
		    UNIQUE KEY `GlAcct_UK0` (`glacct`)
	    ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    $sql90="CREATE TABLE `invoice` (
	  `invoiceid` int(19) NOT NULL default '0',
	    `subject` varchar(100) default NULL,
	      `salesorderid` int(19) default NULL,
	        `customerno` varchar(100) default NULL,
		  `notes` varchar(100) default NULL,
		    `invoicedate` date default NULL,
		      `duedate` date default NULL,
		        `invoiceterms` varchar(100) default NULL,
			  `type` varchar(100) default NULL,
			    `salestax` decimal(11,3) default NULL,
			      `adjustment` decimal(11,3) default NULL,
			        `salescommission` decimal(11,3) default NULL,
				  `exciseduty` decimal(11,3) default NULL,
				    `subtotal` decimal(11,3) default NULL,
				      `total` decimal(11,3) default NULL,
				        `shipping` varchar(100) default NULL,
					  `accountid` int(19) default NULL,
					    `terms_conditions` longtext,
					      `purchaseorder` varchar(200) default NULL,
					        `invoicestatus` varchar(200) default NULL,
					         PRIMARY KEY  (`invoiceid`),
						  CONSTRAINT `fk_Invoice1` FOREIGN KEY (`invoiceid`) REFERENCES `crmentity` (`crmid`) ON DELETE CASCADE
					  ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `invoicebillads` (
	  `invoicebilladdressid` int(19) NOT NULL default '0',
	    `bill_city` varchar(30) default NULL,
	      `bill_code` varchar(30) default NULL,
	        `bill_country` varchar(30) default NULL,
		  `bill_state` varchar(30) default NULL,
		    `bill_street` varchar(250) default NULL,
		      PRIMARY KEY  (`invoicebilladdressid`),
		        CONSTRAINT `fk_InvoiceBillAds` FOREIGN KEY (`invoicebilladdressid`) REFERENCES `invoice` (`invoiceid`) ON DELETE CASCADE
		) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `invoicecf` (
	  `invoiceid` int(19) NOT NULL default '0',
	    PRIMARY KEY  (`invoiceid`),
	      CONSTRAINT `fk_InvoiceCF` FOREIGN KEY (`invoiceid`) REFERENCES `invoice` (`invoiceid`) ON DELETE CASCADE
      ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `invoiceproductrel` (
	  `invoiceid` int(19) NOT NULL default '0',
	    `productid` int(19) NOT NULL default '0',
	      `quantity` int(19) default NULL,
	        `listprice` decimal(11,3) default NULL,
		  PRIMARY KEY  (`invoiceid`,`productid`),
		    KEY `InvoiceProductRel_IDX1` (`productid`),
		      CONSTRAINT `fk_InvoiceProductRel2` FOREIGN KEY (`productid`) REFERENCES `products` (`productid`) ON DELETE CASCADE,
		        CONSTRAINT `fk_InvoiceProductRel` FOREIGN KEY (`invoiceid`) REFERENCES `invoice` (`invoiceid`) ON DELETE CASCADE
		) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

						
	
	
    $sql90=" CREATE TABLE `invoiceshipads` (
		  `invoiceshipaddressid` int(19) NOT NULL default '0',
		    `ship_city` varchar(30) default NULL,
		      `ship_code` varchar(30) default NULL,
		        `ship_country` varchar(30) default NULL,
			  `ship_state` varchar(30) default NULL,
			    `ship_street` varchar(250) default NULL,
			      PRIMARY KEY  (`invoiceshipaddressid`),
			        CONSTRAINT `fk_InvoiceShipAds` FOREIGN KEY (`invoiceshipaddressid`) REFERENCES `invoice` (`invoiceid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





	
	
    $sql90="CREATE TABLE `mail_accounts` (
		  `account_id` int(11) NOT NULL default '0',
		    `user_id` int(11) NOT NULL default '0',
		      `display_name` varchar(50) default NULL,
		        `mail_id` varchar(50) default NULL,
			  `account_name` varchar(50) default NULL,
			    `mail_protocol` varchar(20) default NULL,
			      `mail_username` varchar(50) NOT NULL default '',
			        `mail_password` varchar(20) NOT NULL default '',
				  `mail_servername` varchar(50) default NULL,
				    `status` varchar(10) default NULL,
				      `set_default` int(2) default NULL,
				        PRIMARY KEY  (`account_id`)
				) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





	
	
    $sql90="CREATE TABLE `organizationdetails` (
		  `organizationame` varchar(60) default NULL,
		    `address` varchar(150) default NULL,
		      `city` varchar(100) default NULL,
		        `state` varchar(100) default NULL,
			  `country` varchar(100) default NULL,
			    `code` varchar(30) default NULL,
			      `phone` varchar(30) default NULL,
			        `fax` varchar(30) default NULL,
				  `website` varchar(50) default NULL,
				    `logoname` varchar(50) default NULL,
				      `logo` longtext
			      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);



	
    $sql90="CREATE TABLE `purchaseorder` (
		  `purchaseorderid` int(19) NOT NULL default '0',
		    `subject` varchar(100) default NULL,
		      `quoteid` int(19) default NULL,
		        `vendorid` int(19) default NULL,
			  `requisition_no` varchar(100) default NULL,
			    `tracking_no` varchar(100) default NULL,
			      `contactid` int(19) default NULL,
			        `duedate` date default NULL,
				  `carrier` varchar(100) default NULL,
				    `type` varchar(100) default NULL,
				      `salestax` decimal(11,3) default NULL,
				        `adjustment` decimal(11,3) default NULL,
					  `salescommission` decimal(11,3) default NULL,
					    `exciseduty` decimal(11,3) default NULL,
					      `total` decimal(11,3) default NULL,
					        `subtotal` decimal(11,3) default NULL,
						  `terms_conditions` longtext,
						    `postatus` varchar(200) default NULL,	
						     PRIMARY KEY  (`purchaseorderid`),
						      CONSTRAINT `fk_PO1` FOREIGN KEY (`purchaseorderid`) REFERENCES `crmentity` (`crmid`) ON DELETE CASCADE
					      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    $sql90="CREATE TABLE `purchaseordercf` (
		  `purchaseorderid` int(19) NOT NULL default '0',
		    PRIMARY KEY  (`purchaseorderid`),
		      CONSTRAINT `fk_PoCF` FOREIGN KEY (`purchaseorderid`) REFERENCES `purchaseorder` (`purchaseorderid`) ON DELETE CASCADE
	      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    $sql90="CREATE TABLE `quotes` (
		  `quoteid` int(19) NOT NULL default '0',
		    `subject` varchar(100) default NULL,
		      `potentialid` int(19) default NULL,
		        `quotestage` varchar(200) default NULL,
			  `validtill` date default NULL,
			    `team` varchar(200) default NULL,
			      `contactid` int(19) default NULL,
			        `currency` varchar(100) default NULL,
				  `subtotal` decimal(11,3) default NULL,
				    `carrier` varchar(100) default NULL,
				      `shipping` varchar(100) default NULL,
				        `inventorymanager` int(19) default NULL,
					  `type` varchar(100) default NULL,
					    `tax` decimal(11,3) default NULL,
					      `adjustment` decimal(11,3) default NULL,
					        `total` decimal(11,3) default NULL,
						  `accountid` int(19) default NULL,
						    `terms_conditions` longtext,
						      PRIMARY KEY  (`quoteid`),
						        CONSTRAINT `fk_Quotes1` FOREIGN KEY (`quoteid`) REFERENCES `crmentity` (`crmid`) ON DELETE CASCADE
						) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


	
    $sql90="CREATE TABLE `quotesbillads` (
		  `quotebilladdressid` int(19) NOT NULL default '0',
		    `bill_city` varchar(30) default NULL,
		      `bill_code` varchar(30) default NULL,
		        `bill_country` varchar(30) default NULL,
			  `bill_state` varchar(30) default NULL,
			    `bill_street` varchar(250) default NULL,
			      PRIMARY KEY  (`quotebilladdressid`),
			        CONSTRAINT `fk_QuotesBillAds` FOREIGN KEY (`quotebilladdressid`) REFERENCES `quotes` (`quoteid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


	
    $sql90="CREATE TABLE `quotescf` (
		  `quoteid` int(19) NOT NULL default '0',
		    PRIMARY KEY  (`quoteid`),
		      CONSTRAINT `fk_QuotesCF` FOREIGN KEY (`quoteid`) REFERENCES `quotes` (`quoteid`) ON DELETE CASCADE
	      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);




	
	
    $sql90="CREATE TABLE `pobillads` (
		  `pobilladdressid` int(19) NOT NULL default '0',
		    `bill_city` varchar(30) default NULL,
		      `bill_code` varchar(30) default NULL,
		        `bill_country` varchar(30) default NULL,
			  `bill_state` varchar(30) default NULL,
			    `bill_street` varchar(250) default NULL,
			      PRIMARY KEY  (`pobilladdressid`),
			        CONSTRAINT `fk_PoBillAds` FOREIGN KEY (`pobilladdressid`) REFERENCES `purchaseorder` (`purchaseorderid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





	
	
    $sql90="CREATE TABLE `poproductrel` (
		  `purchaseorderid` int(19) NOT NULL default '0',
		    `productid` int(19) NOT NULL default '0',
		      `quantity` int(19) default NULL,
		        `listprice` decimal(11,3) default NULL,
			  PRIMARY KEY  (`purchaseorderid`,`productid`),
			    KEY `PoProductRel_IDX1` (`productid`),
			      CONSTRAINT `fk_PoProductRel2` FOREIGN KEY (`productid`) REFERENCES `products` (`productid`) ON DELETE CASCADE,
			        CONSTRAINT `fk_PoProductRel` FOREIGN KEY (`purchaseorderid`) REFERENCES `purchaseorder` (`purchaseorderid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);




					
	
	
    $sql90="CREATE TABLE `poshipads` (
		  `poshipaddressid` int(19) NOT NULL default '0',
		    `ship_city` varchar(30) default NULL,
		      `ship_code` varchar(30) default NULL,
		        `ship_country` varchar(30) default NULL,
			  `ship_state` varchar(30) default NULL,
			    `ship_street` varchar(250) default NULL,
			      PRIMARY KEY  (`poshipaddressid`),
			        CONSTRAINT `fk_PoShipAds` FOREIGN KEY (`poshipaddressid`) REFERENCES `purchaseorder` (`purchaseorderid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





	
	
    $sql90="CREATE TABLE `pricebook` (
		  `pricebookid` int(19) NOT NULL default '0',
		    `bookname` varchar(100) default NULL,
		      `active` int(1) default NULL,
		        `description` longtext,
			  PRIMARY KEY  (`pricebookid`),
			    CONSTRAINT `fk_PriceBook` FOREIGN KEY (`pricebookid`) REFERENCES `crmentity` (`crmid`) ON DELETE CASCADE
		    ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





	
	
    $sql90="CREATE TABLE `pricebookcf` (
		  `pricebookid` int(19) NOT NULL default '0',
		    PRIMARY KEY  (`pricebookid`),
		      CONSTRAINT `fk_PriceBookCF` FOREIGN KEY (`pricebookid`) REFERENCES `pricebook` (`pricebookid`) ON DELETE CASCADE
	      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





	
	
    $sql90="CREATE TABLE `pricebookproductrel` (
		  `pricebookid` int(19) NOT NULL default '0',
		    `productid` int(19) NOT NULL default '0',
		      `listprice` decimal(11,3) default NULL,
		        PRIMARY KEY  (`pricebookid`,`productid`),
			  KEY `PriceBookProductRel_IDX0` (`pricebookid`),
			    KEY `PriceBookProductRel_IDX1` (`productid`),
			      CONSTRAINT `fk_PriceBookProductRel2` FOREIGN KEY (`productid`) REFERENCES `products` (`productid`) ON DELETE CASCADE,
			        CONSTRAINT `fk_PriceBookProductRel` FOREIGN KEY (`pricebookid`) REFERENCES `pricebook` (`pricebookid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





	
	
    $sql90="CREATE TABLE `productimage` (
		  `productid` int(19) default NULL,
		    `imagename` varchar(150) default NULL,
		      `product_img` longtext
	      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





	
	
    $sql90="CREATE TABLE `quotesproductrel` (
		  `quoteid` int(19) NOT NULL default '0',
		    `productid` int(19) NOT NULL default '0',
		      `quantity` int(19) default NULL,
		        `listprice` decimal(11,3) default NULL,
			  PRIMARY KEY  (`quoteid`,`productid`),
			    KEY `QuotesProductRel_IDX0` (`quoteid`),
			      KEY `QuotesProductRel_IDX1` (`productid`),
			        CONSTRAINT `fk_QuotesProductRel2` FOREIGN KEY (`productid`) REFERENCES `products` (`productid`) ON DELETE CASCADE,
				  CONSTRAINT `fk_QuotesProductRel` FOREIGN KEY (`quoteid`) REFERENCES `quotes` (`quoteid`) ON DELETE CASCADE
			  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


	
    $sql90="CREATE TABLE `quotesshipads` (
		  `quoteshipaddressid` int(19) NOT NULL default '0',
		    `ship_city` varchar(30) default NULL,
		      `ship_code` varchar(30) default NULL,
		        `ship_country` varchar(30) default NULL,
			  `ship_state` varchar(30) default NULL,
			    `ship_street` varchar(250) default NULL,
			      PRIMARY KEY  (`quoteshipaddressid`),
			        CONSTRAINT `fk_QuotesShipAds` FOREIGN KEY (`quoteshipaddressid`) REFERENCES `quotes` (`quoteid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


	
    $sql90="CREATE TABLE `quotestage` (
		  `quotestageid` int(19) NOT NULL auto_increment,
		    `quotestage` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`quotestageid`),
			    UNIQUE KEY `quotestage_UK0` (`quotestage`)
		    ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);





    $sql90="CREATE TABLE `salesorder` (
		  `salesorderid` int(19) NOT NULL default '0',
		    `subject` varchar(100) default NULL,
		      `potentialid` int(19) default NULL,
		        `customerno` varchar(100) default NULL,
			  `quoteid` int(19) default NULL,
			    `vendorterms` varchar(100) default NULL,
			      `contactid` int(19) default NULL,
			        `vendorid` int(19) default NULL,
				  `duedate` date default NULL,
				    `carrier` varchar(100) default NULL,
				      `pending` varchar(200) default NULL,
				        `type` varchar(100) default NULL,
					  `salestax` decimal(11,3) default NULL,
					    `adjustment` decimal(11,3) default NULL,
					      `salescommission` decimal(11,3) default NULL,
					        `exciseduty` decimal(11,3) default NULL,
						  `total` decimal(11,3) default NULL,
						    `subtotal` decimal(11,3) default NULL,
						      `accountid` int(19) default NULL,
						        `terms_conditions` longtext,
							  `purchaseorder` varchar(200) default NULL,
							    `sostatus` varchar(200) default NULL,	
							     PRIMARY KEY  (`salesorderid`),
							      CONSTRAINT `fk_SO1` FOREIGN KEY (`salesorderid`) REFERENCES `crmentity` (`crmid`) ON DELETE CASCADE
						      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
	

    $sql90="CREATE TABLE `salesordercf` (
		  `salesorderid` int(19) NOT NULL default '0',
		    PRIMARY KEY  (`salesorderid`),
		      CONSTRAINT `fk_SoCF` FOREIGN KEY (`salesorderid`) REFERENCES `salesorder` (`salesorderid`) ON DELETE CASCADE
	      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);




    $sql90="CREATE TABLE `selectquery` (
		  `queryid` int(19) NOT NULL default '0',
		    `startindex` int(19) default '0',
		      `numofobjects` int(19) default '0',
		        PRIMARY KEY  (`queryid`)
		) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);






    $sql90=" CREATE TABLE `selectquery_seq` (
		  `id` int(11) NOT NULL default '0'
	  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);






    $sql90="CREATE TABLE `selectcolumn` (
		  `queryid` int(19) default NULL,
		    `columnindex` int(11) NOT NULL default '0',
		      `columnname` varchar(250) default '',
		        KEY `selectcolumn_IDX0` (`queryid`),
			  CONSTRAINT `selectcolumn_FK1` FOREIGN KEY (`queryid`) REFERENCES `selectquery` (`queryid`) ON DELETE CASCADE
		  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);






    $sql90="CREATE TABLE `sobillads` (
		  `sobilladdressid` int(19) NOT NULL default '0',
		    `bill_city` varchar(30) default NULL,
		      `bill_code` varchar(30) default NULL,
		        `bill_country` varchar(30) default NULL,
			  `bill_state` varchar(30) default NULL,
			    `bill_street` varchar(250) default NULL,
			      PRIMARY KEY  (`sobilladdressid`),
			        CONSTRAINT `fk_SoBillAds` FOREIGN KEY (`sobilladdressid`) REFERENCES `salesorder` (`salesorderid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);






    $sql90="CREATE TABLE `soproductrel` (
		  `salesorderid` int(19) NOT NULL default '0',
		    `productid` int(19) NOT NULL default '0',
		      `quantity` int(19) default NULL,
		        `listprice` decimal(11,3) default NULL,
			  PRIMARY KEY  (`salesorderid`,`productid`),
			    KEY `SoProductRel_IDX0` (`salesorderid`),
			      KEY `SoProductRel_IDX1` (`productid`),
			        CONSTRAINT `fk_SoProductRel2` FOREIGN KEY (`productid`) REFERENCES `products` (`productid`) ON DELETE CASCADE,
				  CONSTRAINT `fk_SoProductRel` FOREIGN KEY (`salesorderid`) REFERENCES `salesorder` (`salesorderid`) ON DELETE CASCADE
			  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);






    $sql90="CREATE TABLE `soshipads` (
		  `soshipaddressid` int(19) NOT NULL default '0',
		    `ship_city` varchar(30) default NULL,
		      `ship_code` varchar(30) default NULL,
		        `ship_country` varchar(30) default NULL,
			  `ship_state` varchar(30) default NULL,
			    `ship_street` varchar(250) default NULL,
			      PRIMARY KEY  (`soshipaddressid`),
			        CONSTRAINT `fk_SoShipAds` FOREIGN KEY (`soshipaddressid`) REFERENCES `salesorder` (`salesorderid`) ON DELETE CASCADE
			) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);








    	
    $sql90="CREATE TABLE `recurringtype` (
		  `recurringeventid` int(19) NOT NULL auto_increment,
		    `recurringtype` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`recurringeventid`)
		  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);



	
    $sql90="CREATE TABLE `recurringevents` (
		  `recurringid` int(19) NOT NULL auto_increment,
		    `activityid` int(19) NOT NULL default '0',
		      `recurringdate` date default NULL,
		        `recurringtype` varchar(30) default NULL,
			  PRIMARY KEY  (`recurringid`)
		  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

	

    $sql90="CREATE TABLE `reportfolder` (
		  `folderid` int(19) NOT NULL auto_increment,
		    `foldername` varchar(100) NOT NULL default '',
		      `description` varchar(250) default '',
		        `state` varchar(50) default 'SAVED',
			  PRIMARY KEY  (`folderid`)
		  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
	

    	
    $sql90="CREATE TABLE `report` (
		  `reportid` int(19) NOT NULL default '0',
		    `folderid` int(19) NOT NULL default '0',
		      `reportname` varchar(100) default '',
		        `description` varchar(250) default '',
			  `reporttype` varchar(50) default '',
			    `queryid` int(19) NOT NULL default '0',
			      `state` varchar(50) default 'SAVED',
			        `customizable` int(1) default '1',
				  `category` int(11) default '1',
				    PRIMARY KEY  (`reportid`),
				      KEY `report_IDX0` (`queryid`),
				        KEY `report_IDX1` (`folderid`),
					  CONSTRAINT `report_FK2` FOREIGN KEY (`folderid`) REFERENCES `reportfolder` (`folderid`) ON DELETE CASCADE,
					    CONSTRAINT `report_FK1` FOREIGN KEY (`queryid`) REFERENCES `selectquery` (`queryid`) ON DELETE CASCADE
				    ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    $sql90="CREATE TABLE `reportdatefilter` (
		  `datefilterid` int(19) NOT NULL default '0',
		    `datecolumnname` varchar(250) default '',
		      `datefilter` varchar(250) default '',
		        `startdate` date default '0000-00-00',
			  `enddate` date default '0000-00-00',
			    KEY `reportdatefilter_IDX0` (`datefilterid`),
			      CONSTRAINT `reportdatefilter_FK1` FOREIGN KEY (`datefilterid`) REFERENCES `report` (`reportid`) ON DELETE CASCADE
		      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `reportmodules` (
		  `reportmodulesid` int(19) NOT NULL default '0',
		    `primarymodule` varchar(50) NOT NULL default '',
		      `secondarymodules` varchar(250) default '',
		        PRIMARY KEY  (`reportmodulesid`),
			  KEY `reportmodules_IDX0` (`reportmodulesid`),
			    CONSTRAINT `reportmodules_FK1` FOREIGN KEY (`reportmodulesid`) REFERENCES `report` (`reportid`) ON DELETE CASCADE
		    ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
	

    $sql90="CREATE TABLE `reportsortcol` (
		  `sortcolid` int(19) NOT NULL default '0',
		    `reportid` int(19) NOT NULL default '0',
		      `columnname` varchar(250) default '',
		        `sortorder` varchar(250) default 'Asc',
			  KEY `reportsortcol_IDX0` (`reportid`),
			    CONSTRAINT `reportsortcol_FK1` FOREIGN KEY (`reportid`) REFERENCES `report` (`reportid`) ON DELETE CASCADE
		    ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
	

    $sql90="CREATE TABLE `reportsummary` (
		  `reportsummaryid` int(19) NOT NULL default '0',
		    `summarytype` int(19) NOT NULL default '0',
		      `columnname` varchar(250) default '',
		        KEY `reportsummary_IDX0` (`reportsummaryid`),
			  CONSTRAINT `reportsummary_FK1` FOREIGN KEY (`reportsummaryid`) REFERENCES `report` (`reportid`) ON DELETE CASCADE
		  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
	



	
    $sql90="CREATE TABLE `relatedlists` (
		  `relation_id` int(19) NOT NULL default '0',
		    `tabid` int(10) default NULL,
		      `related_tabid` int(10) default NULL,
		        `name` varchar(100) default NULL,
			  `sequence` int(10) default NULL,
			    `label` varchar(100) default NULL,
			      `presence` int(10) NOT NULL default '0',
			        PRIMARY KEY  (`relation_id`),
				  KEY `idx_profile2tab` (`relation_id`)
			  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


	
    $sql90="CREATE TABLE `relcriteria` (
		  `queryid` int(19) default NULL,
		    `columnindex` int(11) NOT NULL default '0',
		      `columnname` varchar(250) default '',
		        `comparator` varchar(10) default '',
			  `value` varchar(200) default '',
			    KEY `relcriteria_IDX0` (`queryid`),
			      CONSTRAINT `relcriteria_FK1` FOREIGN KEY (`queryid`) REFERENCES `selectquery` (`queryid`) ON DELETE CASCADE
		      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

	/*
    $sql90="CREATE TABLE `revenuetype` (
		  `revenuetypeid` int(19) NOT NULL auto_increment,
		    `revenuetype` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`revenuetypeid`),
			    UNIQUE KEY `RevenueType_UK0` (`revenuetype`)
		    ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
    */ 
	

    $sql90="CREATE TABLE `rss` (
		  `rssid` int(19) NOT NULL default '0',
		    `rssurl` varchar(200) NOT NULL default '',
		      `rsstitle` varchar(200) default NULL,
		        `rsstype` int(10) default '0',
			  `starred` int(1) default '0',
			    `rsscategory` varchar(100) default '',
			      PRIMARY KEY  (`rssid`)
		      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
	

    $sql90="CREATE TABLE `rsscategory` (
		  `rsscategoryid` int(19) NOT NULL auto_increment,
		    `rsscategory` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`rsscategoryid`),
			    UNIQUE KEY `RssCategory_UK0` (`rsscategory`)
		    ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
	


    $sql90="CREATE TABLE `taxclass` (
		  `taxclassid` int(19) NOT NULL auto_increment,
		    `taxclass` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`taxclassid`)
		  ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    




    $sql90="CREATE TABLE `usageunit` (
		  `usageunitid` int(19) NOT NULL auto_increment,
		    `usageunit` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`usageunitid`),
			    UNIQUE KEY `UsageUnit_UK0` (`usageunit`)
		    ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);




    $sql90="CREATE TABLE `vendor` (
		  `vendorid` int(19) NOT NULL default '0',
		    `company_name` varchar(100) default NULL,
		      `vendorname` varchar(100) default NULL,
		        `phone` varchar(100) default NULL,
			  `email` varchar(100) default NULL,
			    `website` varchar(100) default NULL,
			      `glacct` varchar(50) default NULL,
			        `category` varchar(50) default NULL,
				  `street` longtext,
				    `city` varchar(30) default NULL,
				      `state` varchar(30) default NULL,
				        `postalcode` varchar(100) default NULL,
					  `country` varchar(100) default NULL,
					    `description` longtext,
					      PRIMARY KEY  (`vendorid`),
					        CONSTRAINT `fk_Vendor` FOREIGN KEY (`vendorid`) REFERENCES `crmentity` (`crmid`) ON DELETE CASCADE
					) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);




    $sql90="CREATE TABLE `vendorcf` (
		  `vendorid` int(19) NOT NULL default '0',
		    PRIMARY KEY  (`vendorid`),
		      CONSTRAINT `fk_VendorCF` FOREIGN KEY (`vendorid`) REFERENCES `vendor` (`vendorid`) ON DELETE CASCADE
	      ) TYPE=InnoDB";
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

    $sql90="CREATE TABLE `inventorynotification` (
	  `notificationid` int(19) NOT NULL auto_increment,
	    `notificationname` varchar(200) default NULL,
	      `notificationsubject` varchar(200) default NULL,
	        `notificationbody` longtext,
		  `label` varchar(50) default NULL,
		    PRIMARY KEY  (`notificationid`)
	    ) TYPE=InnoDB";

    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);
	

    //Create Table TicketComments
    $sql90 = "CREATE TABLE `ticketcomments` (
		`commentid` int(19) NOT NULL auto_increment,
		`ticketid` int(19) default NULL,
		`comments` longtext,
		`ownerid` int(19) NOT NULL default '0',
		`ownertype` varchar(10) default NULL,
		`createdtime` datetime NOT NULL default '0000-00-00 00:00:00',
		PRIMARY KEY  (`commentid`),
		KEY `ticketcomments_IDX0` (`ticketid`),
		CONSTRAINT `fk_ticketcommentsCF` FOREIGN KEY (`ticketid`) REFERENCES `troubletickets` (`ticketid`) ON DELETE CASCADE
	) TYPE=InnoDB";
	
    echo '<br> '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    //Create Table ticketseverities
    $sql91 = "CREATE TABLE `ticketseverities` (
		`ticketseverities_id` int(19) NOT NULL auto_increment,
		`ticketseverities` varchar(100) default NULL,
		`SORTORDERID` int(19) NOT NULL default '0',
		`PRESENCE` int(1) NOT NULL default '0',
		PRIMARY KEY  (`ticketseverities_id`)
	) TYPE=InnoDB  ";
    echo '<br> '.$sql91 .' <br> ';
    $this->oldconn->query($sql91);

    //Create Table faqstatus
    $sql92 = "CREATE TABLE `faqstatus` (
		`faqstatus_id` int(19) NOT NULL auto_increment,
		`faqstatus` varchar(60) default NULL,
		`SORTORDERID` int(19) NOT NULL default '0',
		`PRESENCE` int(1) NOT NULL default '1',
		PRIMARY KEY  (`faqstatus_id`)
	) TYPE=InnoDB  ";

    echo '<br> '.$sql92 .' <br> ';
    $this->oldconn->query($sql92);

    //Create Table faqcomments
    $sql93 = "CREATE TABLE `faqcomments` (
		`commentid` int(19) NOT NULL auto_increment,
		`faqid` int(19) default NULL,
		`comments` longtext,
		`createdtime` datetime NOT NULL default '0000-00-00 00:00:00',
		PRIMARY KEY  (`commentid`),
		KEY `faqcomments_IDX0` (`faqid`),
		CONSTRAINT `fk_faqcommentsCF` FOREIGN KEY (`faqid`) REFERENCES `faq` (`id`) ON DELETE CASCADE
	) TYPE=InnoDB  ";

    echo '<br> '.$sql93 .' <br> ';
    $this->oldconn->query($sql93);

    //Create Table vendorcontactrel
    $sql94 = "CREATE TABLE `vendorcontactrel` (
		`vendorid` int(19) NOT NULL default '0',
		`contactid` int(19) NOT NULL default '0',
		PRIMARY KEY  (`vendorid`,`contactid`),
		KEY `VendorContactRel_IDX0` (`vendorid`),
		KEY `VendorContactRel_IDX1` (`contactid`),
		CONSTRAINT `fk_VendorContactRel` FOREIGN KEY (`contactid`) REFERENCES `contactdetails` (`contactid`) ON DELETE CASCADE
	) TYPE=InnoDB  ";
	
    echo '<br> '.$sql94 .' <br> ';
    $this->oldconn->query($sql94);


	$sql90="CREATE TABLE `postatus` (
		  `postatusid` int(19) NOT NULL auto_increment,
		    `postatus` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`postatusid`),
			    UNIQUE KEY `postatus_UK0` (`postatus`)
		    ) TYPE=InnoDB";
    echo '<br> DON '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

	$sql90="CREATE TABLE `sostatus` (
		  `sostatusid` int(19) NOT NULL auto_increment,
		    `sostatus` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`sostatusid`),
			    UNIQUE KEY `sostatus_UK0` (`sostatus`)
		    ) TYPE=InnoDB";
    echo '<br> DON '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);

	$sql90="CREATE TABLE `invoicestatus` (
		  `invoicestatusid` int(19) NOT NULL auto_increment,
		    `invoicestatus` varchar(200) NOT NULL default '',
		      `sortorderid` int(19) NOT NULL default '0',
		        `presence` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`invoicestatusid`),
			    UNIQUE KEY `invoicestatus_UK0` (`invoicestatus`)
		    ) TYPE=InnoDB";
    echo '<br> DON '.$sql90 .' <br> ';
    $this->oldconn->query($sql90);


    //table creation ends







	  
    //Changes to User table
    $sql1 = "ALTER TABLE users add column signature VARCHAR(50)";
    echo '<br> '.$sql1 .' <br> ';
    $this->oldconn->query($sql1);

    //Changes to Products Table
    $sql51 = "ALTER TABLE products add column sales_start_date date";
    echo '<br> '.$sql51 .' <br> ';
    $this->oldconn->query($sql51);

    $sql52 = "ALTER TABLE products add column sales_end_date date";
    echo '<br> '.$sql52 .' <br> ';
    $this->oldconn->query($sql52);

    $sql53 = "ALTER TABLE products add column usageunit VARCHAR(200)";
    echo '<br> '.$sql53 .' <br> ';
    $this->oldconn->query($sql53);

    $sql54 = "ALTER TABLE products add column handler int(11)";
    echo '<br> '.$sql54 .' <br> ';
    $this->oldconn->query($sql54);

    $sql55 = "ALTER TABLE products add column serialno VARCHAR(200)";
    echo '<br> '.$sql55 .' <br> ';
    $this->oldconn->query($sql55);

    $sql56 = "ALTER TABLE products add column contactid int(11)";
    echo '<br> '.$sql56 .' <br> ';
    $this->oldconn->query($sql56);

   /*	
    $sql57 = "ALTER TABLE products add column currency VARCHAR(200)";
    echo '<br> '.$sql57 .' <br> ';
    $this->oldconn->query($sql57);
*/

    $sql58 = "ALTER TABLE products add column reorderlevel int(11)";
    echo '<br> '.$sql58 .' <br> ';
    $this->oldconn->query($sql58);

    $sql59 = "ALTER TABLE products add column website VARCHAR(100)";
    echo '<br> '.$sql59 .' <br> ';
    $this->oldconn->query($sql59);

    $sql60 = "ALTER TABLE products add column taxclass VARCHAR(200)";
    echo '<br> '.$sql60 .' <br> ';
    $this->oldconn->query($sql60);

    $sql61 = "ALTER TABLE products add column mfr_part_no VARCHAR(200)";
    echo '<br> '.$sql61 .' <br> ';
    $this->oldconn->query($sql61);

    $sql62 = "ALTER TABLE products add column qtyinstock int(11)";
    echo '<br> '.$sql62 .' <br> ';
    $this->oldconn->query($sql62);

    $sql63 = "ALTER TABLE products add column glacct VARCHAR(200)";
    echo '<br> '.$sql63 .' <br> ';
    $this->oldconn->query($sql63);

    $sql64 = "ALTER TABLE products add column vendor_id int(11)";
    echo '<br> '.$sql64 .' <br> ';
    $this->oldconn->query($sql64);

	
    $sql65 = "ALTER TABLE products drop column purchase_date";
    echo '<br> '.$sql65 .' <br> ';
    $res65 = $this->oldconn->query($sql65);

    //Added by Don
    $sql66 = "ALTER TABLE products add column imagename VARCHAR(150)";
    echo '<br> '.$sql66 .' <br> ';
    $this->oldconn->query($sql66);

    //Chages in Contact Details Table Don	
    $sql67 = "ALTER TABLE contactdetails change column emailoptout emailoptout char(3) default 0";
    echo '<br> '.$sql67 .' <br> ';
    $this->oldconn->query($sql67);	 		

    //Changes to troubletickets table
    $sql7 = "ALTER TABLE troubletickets change contact_id parent_id VARCHAR(100)";
    echo '<br> '.$sql7 .' <br> ';
    $res7 = $this->oldconn->query($sql7);


    $sql71 = "ALTER TABLE troubletickets add column product_id VARCHAR(100)";
    echo '<br> '.$sql71 .' <br> ';
    $this->oldconn->query($sql71);


    $sql72 = "ALTER TABLE troubletickets add column severity VARCHAR(150)";
    echo '<br> '.$sql72 .' <br> ';
    $this->oldconn->query($sql72);


    $sql73 = "ALTER TABLE troubletickets add column solution LONGTEXT";
    echo '<br> '.$sql73 .' <br> ';
    $this->oldconn->query($sql73);



    //Changes to faq table
    $sql74 = "ALTER TABLE faq add column product_id VARCHAR(100)";
    echo '<br> '.$sql74 .' <br> ';
    $res74 = $this->oldconn->query($sql74);


    $sql75 = "ALTER TABLE faq add column status VARCHAR(100)";
    echo '<br> '.$sql75 .' <br> ';
    $res75 = $this->oldconn->query($sql75);


    //Changes to notificationscheduler table
    $sql76 = "ALTER TABLE notificationscheduler add label  VARCHAR(50)";
    echo '<br> '.$sql76 .' <br> ';
    $res76 = $this->oldconn->query($sql76);


    $sql77 = "ALTER TABLE notificationscheduler drop column description";
    echo '<br> '.$sql77 .' <br> ';
    $res77 = $this->oldconn->query($sql77);





    //entries in the tab table for the new tabs

    $sql100="INSERT INTO tab VALUES (18,'Vendor',2,15,'Vendor','','',1)";
    echo '<br> '.$sql100 .' <br> ';
    $res100 = $this->oldconn->query($sql100);
        
    $sql101="INSERT INTO tab VALUES (19,'PriceBook',2,16,'PriceBook','','',1)";
    echo '<br> '.$sql101 .' <br> ';
    $res101 = $this->oldconn->query($sql101);

    $sql102="INSERT INTO tab VALUES (20,'Quotes',0,17,'Quotes','','',1)";
    echo '<br> '.$sql102 .' <br> ';
    $res102 = $this->oldconn->query($sql102);

    $sql103="INSERT INTO tab VALUES (21,'Orders',0,18,'Orders','','',1)";
    echo '<br> '.$sql103 .' <br> ';
    $res103 = $this->oldconn->query($sql103);

    $sql104="INSERT INTO tab VALUES (22,'SalesOrder',2,19,'SalesOrder','','',1)";
    echo '<br> '.$sql104 .' <br> ';
    $res104 = $this->oldconn->query($sql104);

    $sql105="INSERT INTO tab VALUES (23,'Invoice',0,20,'Invoice','','',1)";
    echo '<br> '.$sql105 .' <br> ';
    $res105 = $this->oldconn->query($sql105);

    $sql106="INSERT INTO tab VALUES (24,'Rss',0,21,'Rss','','',1)";
    echo '<br> '.$sql106 .' <br> ';
    $res106 = $this->oldconn->query($sql106);

    $sql107="INSERT INTO tab VALUES (25,'Reports',0,22,'Reports','','',1)";
    echo '<br> '.$sql107 .' <br> ';
    $res107 = $this->oldconn->query($sql107);


    /*
- $this->db->query("insert into field values (4,".$this->db->getUniqueID("field").",'accountid','contactdetails',1,'50','account_id','Account Name',1,0,0,100,6,1,1,'I~M')");
+ $this->db->query("insert into field values (4,".$this->db->getUniqueID("field").",'accountid','contactdetails',1,'51','account_id','Account Name',1,0,0,100,6,1,1,'I~O')");

    */


    $sql173="update field set uitype=51 where columnname='accountid' and tabid=4 and tablename='contactdetails' and fieldlabel='Account Name'";
    echo '<br> '.$sql173 .' <br> ';
    $res173 = $this->oldconn->query($sql173);




    //Block - Begin Customer Portal
    $sql172="insert into field values (4,".$this->oldconn->getUniqueID("field").",'portal','CustomerDetails',1,'56','portal','Portal User',1,0,0,100,1,4,1,'C~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    $sql172="insert into field values (4,".$this->oldconn->getUniqueID("field").",'support_start_date','CustomerDetails',1,'5','support_start_date','Support Start Date',1,0,0,100,2,4,1,'D~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    $sql172="insert into field values (4,".$this->oldconn->getUniqueID("field").",'support_end_date','CustomerDetails',1,'5','support_end_date','Support End Date',1,0,0,100,3,4,1,'D~O~OTH~GE~support_start_date~Support Start Date')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    //Block - End Customer Portal







    //alterations

    /*
- $this->db->query("insert into field values (13,".$this->db->getUniqueID("field").",'contact_id','troubletickets',1,'57','contact_id','Contact Name',1,0,0,100,4,1,1,'I~O')");
+ $this->db->query("insert into field values (13,".$this->db->getUniqueID("field").",'parent_id','troubletickets',1,'68','parent_id','Related To',1,0,0,100,4,1,1,'I~O')");
    */

    //to verify
    $sql173="update field set columnname='parent_id',uitype=68,fieldname='parent_id',fieldlabel='Related To' where columnname='contact_id' and fieldname='contact_id' and tabid=13 and tablename='troubletickets'";
    echo '<br> '.$sql173 .' <br> ';
    $res173 = $this->oldconn->query($sql173);






    $sql172="insert into field values (13,".$this->oldconn->getUniqueID("field").",'product_id','troubletickets',1,'59','product_id','Product Name',1,0,0,100,6,1,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    $sql172="insert into field values (13,".$this->oldconn->getUniqueID("field").",'severity','troubletickets',1,'15','ticketseverities','Severity',1,0,0,100,7,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);







    $sql174="update field set sequence=8 where columnname='status' and tablename='troubletickets' and fieldlabel='Status'";
    echo '<br> '.$sql174 .' <br> ';
    $res174 = $this->oldconn->query($sql174);


    $sql175="update field set sequence=9 where columnname='category' and tablename='troubletickets' and fieldlabel='Category'";
    echo '<br> '.$sql175 .' <br> ';
    $res175 = $this->oldconn->query($sql175);


    $sql175="update field set sequence=9 where columnname='update_log' and tablename='troubletickets' and fieldlabel='Update History'";
    echo '<br> '.$sql175 .' <br> ';
    $res175 = $this->oldconn->query($sql175);


    $sql176="update field set sequence=10 where columnname='createdtime' and tablename='crmentity' and fieldlabel='Created Time' and tabid=13 and typeofdata='T~O'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    $sql176="update field set sequence=11 where columnname='modifiedtime' and tablename='crmentity' and fieldlabel='Modified Time' and tabid=13 and typeofdata='T~O'"; 
    echo '<br> Fixed by Don'.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    $sql172="insert into field values (13,".$this->oldconn->getUniqueID("field").",'solution','troubletickets',1,'19','solution','Solution',1,0,0,100,1,4,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    $sql172="insert into field values (13,".$this->oldconn->getUniqueID("field").",'comments','ticketcomments',1,'19','comments','Add Comment',1,0,0,100,1,6,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


	$sql176="insert into field values (14,".$this->oldconn->getUniqueID("field").",'imagename','products',1,'69','imagename','Product Image',1,0,0,100,1,6,1,'V~O')"; 
    echo '<br> DON'.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);


    $sql176="update field set sequence=2, block=2 where columnname='commissionrate' and tablename='products' and fieldlabel='Commission Rate'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);




    $sql176="update field set sequence=2, block=3 where columnname='qty_per_unit' and tablename='products' and fieldlabel='Qty/Unit'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);


    
    $sql176="update field set sequence=1, block=2 where columnname='unit_price' and tablename='products' and fieldlabel='Unit Price' and tabid=14"; 
    echo '<br> Fixed by don'.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);




    $sql176="update field set sequence=4 where columnname='manufacturer' and tablename='stockmaster' and fieldlabel='Manufacturer' and tabid=14"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);




    $sql176="update field set sequence=4 where columnname='categoryid' and tablename='stockmaster' and fieldlabel='Product Category' and tabid=14"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);

    
    $sql176="update field set sequence=7 where columnname='start_date' and tablename='stockmaster' and fieldlabel='Support Start Date'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);




    $sql176="update field set sequence=8,typeofdata='D~O~OTH~GE~start_date~Start Date' where columnname='expiry_date' and tablename='products' and fieldlabel='Support Expiry Date'"; 
    echo '<br>DON '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);

    //deleted field
    $sql176="delete from field where columnname='purchase_date' and tablename='products' and fieldlabel='Purchase Date'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    $sql176="update field set sequence=19 where columnname='createdtime' and tablename='crmentity' and fieldlabel='Created Time' and tabid=14 and typeofdata='T~O'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    $sql176="update field set sequence=20 where columnname='modifiedtime' and tablename='crmentity' and fieldlabel='Modified Time' and tabid=14 and typeofdata='T~O'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    $sql176="update field set sequence=1,block=4 where columnname='product_description' and tablename='products' and fieldlabel='Description' and tabid=14 and typeofdata='V~O'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);




    $sql176="update field set sequence=10  where columnname='crmid' and tablename='seproductsrel' and fieldlabel='Related To' and tabid=14 and typeofdata='I~O'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    
    $sql172 = "update field set uitype=52 where columnname='smownerid' and tablename='crmentity' and fieldlabel='Assigned To' and typeofdata='V~M' and tabid=9";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    

    $sql172 = "update field set displaytype=3 where columnname='eventstatus' and tablename='activity' and fieldlabel='Status' and typeofdata='V~O' and tabid=9";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




    $sql172="insert into field values (9,".$this->oldconn->getUniqueID("field").",'reminder_time','activity_reminder',1,'30','reminder_time','Send Reminder',1,0,0,100,1,7,3,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 
    $sql172="insert into field values (9,".$this->oldconn->getUniqueID("field").",'recurringtype','recurringevents',1,'15','recurringtype','Recurrence',1,0,0,100,6,1,3,'O~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




    $sql172 = "update field set uitype=52 where columnname='smownerid' and tablename='crmentity' and fieldlabel='Assigned To' and typeofdata='I~O' and tabid=16";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




    $sql172 = "update field set sequence=7 where columnname='duration_hours' and tablename='activity' and fieldlabel='Duration' and typeofdata='I~M' and tabid=16";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


    $sql172 = "update field set sequence=8 where columnname='duration_minutes' and tablename='activity' and fieldlabel='Duration Minutes' and typeofdata='O~O' and tabid=16";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




    $sql172 = "update field set sequence=9 where columnname='crmid' and tablename='seactivityrel' and fieldlabel='Related To' and tabid=16";
    echo '<br> Fixed by don'.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




    $sql172 = "update field set sequence=11  where columnname='eventstatus' and tablename='activity' and fieldlabel='Status' and typeofdata='V~O' and tabid=16";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




    $sql172="update field set sequence=12 where columnname='sendnotification' and tablename='activity' and fieldlabel='Send Notification' and tabid=16";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
 

    $sql172="update field set sequence=13 where columnname='activitytype' and tablename='activity' and fieldlabel='Activity Type' and tabid=16";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
 


    $sql172="update field set sequence=14 where columnname='location' and tablename='activity' and fieldlabel='Location' and tabid=16";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);





    $sql176="update field set sequence=15 where columnname='createdtime' and tablename='crmentity' and fieldlabel='Created Time' and tabid=16 and typeofdata='T~O'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    $sql176="update field set sequence=16 where columnname='modifiedtime' and tablename='crmentity' and fieldlabel='Modified Time' and tabid=16 and typeofdata='T~O'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);




    $sql172="insert into field values (16,".$this->oldconn->getUniqueID("field").",'reminder_time','activity_reminder',1,'30','reminder_time','Send Reminder',1,0,0,100,1,7,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);



    //crosscheck needed
    $sql176="update field set sequence=2 where columnname='category' and tablename='faq' and fieldlabel='Category' and tabid=15 and typeofdata='V~O'"; 
    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);


    $sql172="insert into field values (15,".$this->oldconn->getUniqueID("field").",'status','faq',1,'15','faqstatus','Status',1,0,0,100,3,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


	//Fixed by Don From Faq the Related To field is removed	
    $sql172="delete from field where tablename='sefaqrel' and fieldname='parent_id' and fieldlabel='Related To' and tabid=15";
    echo '<br> FAQ Query Fixed by Don '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




    $sql176="update field set tablename='faqcomments',fieldlabel='Add Comment'  where columnname='comments' and tablename='faq' and tabid=15"; 
    echo '<br> Fixed by don'.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);


    $sql176="update notificationscheduler  set schedulednotificationname='LBL_TASK_NOTIFICATION_DESCRITPION' ,label='LBL_TASK_NOTIFICATION' where notificationsubject='Tasks delayed beyond 24 hrs'"; 

    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);


  
    $sql176="update notificationscheduler  set schedulednotificationname='LBL_BIG_DEAL_DESCRIPTION',label='LBL_BIG_DEAL' where notificationsubject='Big Deal notification'"; 

    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);


    $sql176="update notificationscheduler  set schedulednotificationname='LBL_TICKETS_DESCRIPTION',label='LBL_PENDING_TICKETS' where notificationsubject='Pending Tickets notification'"; 

    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    $sql176="update notificationscheduler  set schedulednotificationname='LBL_MANY_TICKETS_DESCRIPTION',label='LBL_MANY_TICKETS' where notificationsubject='Too many tickets Notification'"; 

    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



    $sql176="update notificationscheduler  set schedulednotificationname='LBL_START_DESCRIPTION',label='LBL_START_NOTIFICATION' where notificationsubject='Support Start Notification'"; 

    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



  
    $sql176="update notificationscheduler  set schedulednotificationname='LBL_SUPPORT_DESCRIPTION',label='LBL_SUPPORT_NOTICIATION' where notificationsubject='Support ending please'"; 

    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);



  
    $sql176="update notificationscheduler  set schedulednotificationname='LBL_ACTIVITY_REMINDER_DESCRIPTION',label='LBL_ACTIVITY_NOTIFICATION' where notificationsubject='Activity Reminder Notication'"; 

    echo '<br> '.$sql176 .' <br> ';
    $res176 = $this->oldconn->query($sql176);


    $sql108="select profileid from profile where profilename='Administrator'";
    echo '<br> '.$sql108 .' <br> ';
    $res108 = $this->oldconn->query($sql108);
                                    
    $profile1_id= $this->oldconn->query_result($res108,0,'profileid');
                                    
    $sql112="insert into profile2tab values (".$profile1_id.",18,0)";
    echo '<br> '.$sql112 .' <br> ';
    $res112 = $this->oldconn->query($sql112);
                                    
    $sql113="insert into profile2tab values (".$profile1_id.",19,0)";
    echo '<br> '.$sql113 .' <br> ';
    $res113 = $this->oldconn->query($sql113);
                                    
    $sql114="insert into profile2tab values (".$profile1_id.",20,0)";
    echo '<br> '.$sql114 .' <br> ';
    $res114 = $this->oldconn->query($sql114);
                                    
    $sql115="insert into profile2tab values (".$profile1_id.",21,0)";
    echo '<br> '.$sql115 .' <br> ';
    $res115 = $this->oldconn->query($sql115);
                                    
    $sql116="insert into profile2tab values (".$profile1_id.",22,0)";
    echo '<br> '.$sql116 .' <br> ';
    $res116 = $this->oldconn->query($sql116);
                                    
    $sql117="insert into profile2tab values (".$profile1_id.",23,0)";
    echo '<br> '.$sql117 .' <br> ';
    $res117 = $this->oldconn->query($sql117);
                                    
    $sql118="insert into profile2tab values (".$profile1_id.",24,0)";
    echo '<br> '.$sql118 .' <br> ';
    $res118 = $this->oldconn->query($sql118);
                                    
    $sql119="insert into profile2tab values (".$profile1_id.",25,0)";
    echo '<br> '.$sql119 .' <br> ';
    $res119 = $this->oldconn->query($sql119);
                                    
                                    
                                    
                                    
    $sql109="select profileid from profile where profilename='Sales Profile'";
    echo '<br> '.$sql109 .' <br> ';
    $res109 = $this->oldconn->query($sql109);
    $profile2_id= $this->oldconn->query_result($res109,0,'profileid');                        
                                    
                                    
                                    
                                    
                                    
    $sql120="insert into profile2tab values (".$profile2_id.",18,0)";
    echo '<br> '.$sql120 .' <br> ';
    $res120 = $this->oldconn->query($sql120);
                                    
                                    
    $sql121="insert into profile2tab values (".$profile2_id.",19,0)";
    echo '<br> '.$sql121 .' <br> ';
    $res121 = $this->oldconn->query($sql121);
                                    
                                    
    $sql122="insert into profile2tab values (".$profile2_id.",20,0)";
    echo '<br> '.$sql122 .' <br> ';
    $res122 = $this->oldconn->query($sql122);
                                    
                                    
    $sql123="insert into profile2tab values (".$profile2_id.",21,0)";
    echo '<br> '.$sql123 .' <br> ';
    $res123 = $this->oldconn->query($sql123);
                                    
                                    
    $sql124="insert into profile2tab values (".$profile2_id.",22,0)";
    echo '<br> '.$sql124 .' <br> ';
    $res124 = $this->oldconn->query($sql124);
                                    
                                    
    $sql="insert into profile2tab values (".$profile2_id.",23,0)";
    echo '<br> '.$sql119 .' <br> ';
    $res119 = $this->oldconn->query($sql119);
                                    
                                    
    $sql125="insert into profile2tab values (".$profile2_id.",24,0)";
    echo '<br> '.$sql125 .' <br> ';
    $res125 = $this->oldconn->query($sql125);
                                    
                                    
    $sql126="insert into profile2tab values (".$profile2_id.",25,0)";
    echo '<br> '.$sql126 .' <br> ';
    $res126 = $this->oldconn->query($sql126);
                                    
    $sql110="select profileid from profile where profilename='Support Profile'";
    echo '<br> '.$sql110 .' <br> ';
    $res110 = $this->oldconn->query($sql110);
    $profile3_id= $this->oldconn->query_result($res110,0,'profileid');                        
                                    
                                    
                                    
    $sql127="insert into profile2tab values (".$profile3_id.",18,0)";
    echo '<br> '.$sql127 .' <br> ';
    $res127 = $this->oldconn->query($sql127);
                                    
    $sql128="insert into profile2tab values (".$profile3_id.",19,0)";
    echo '<br> '.$sql128 .' <br> ';
    $res128 = $this->oldconn->query($sql128);
                                    
    $sql129="insert into profile2tab values (".$profile3_id.",20,0)";
    echo '<br> '.$sql129 .' <br> ';
    $res129 = $this->oldconn->query($sql129);
                                    
    $sql130="insert into profile2tab values (".$profile3_id.",21,0)";
    echo '<br> '.$sql130 .' <br> ';
    $res130 = $this->oldconn->query($sql130);
                                    
    $sql131="insert into profile2tab values (".$profile3_id.",22,0)";
    echo '<br> '.$sql131 .' <br> ';
    $res131 = $this->oldconn->query($sql131);
                                    
    $sql132="insert into profile2tab values (".$profile3_id.",23,0)";
    echo '<br> '.$sql132 .' <br> ';
    $res132 = $this->oldconn->query($sql132);
                                    
    $sql133="insert into profile2tab values (".$profile3_id.",24,0)";
    echo '<br> '.$sql133 .' <br> ';
    $res133 = $this->oldconn->query($sql133);
                                    
    $sql134="insert into profile2tab values (".$profile3_id.",25,0)";
    echo '<br> '.$sql134 .' <br> ';
    $res134 = $this->oldconn->query($sql134);
                                    
                                    
                                    
                                    
                                    
    $sql111="select profileid from profile where profilename='Guest Profile'";
    echo '<br> '.$sql111 .' <br> ';
    $res111 = $this->oldconn->query($sql111);
    $profile4_id= $this->oldconn->query_result($res111,0,'profileid');                        
                                    
                                    
                                    
    $sql135="insert into profile2tab values (".$profile4_id.",18,0)";
    echo '<br> '.$sql135 .' <br> ';
    $res135 = $this->oldconn->query($sql135);
                                    
    $sql136="insert into profile2tab values (".$profile4_id.",19,0)";
    echo '<br> '.$sql136 .' <br> ';
    $res136 = $this->oldconn->query($sql136);
                                    
                                    
    $sql137="insert into profile2tab values (".$profile4_id.",20,0)";
    echo '<br> '.$sql137 .' <br> ';
    $res137 = $this->oldconn->query($sql137);
                                    
                                    
    $sql138="insert into profile2tab values (".$profile4_id.",21,0)";
    echo '<br> '.$sql138 .' <br> ';
    $res138 = $this->oldconn->query($sql138);
                                    
                                    
    $sql139="insert into profile2tab values (".$profile4_id.",22,0)";
    echo '<br> '.$sql139 .' <br> ';
    $res139 = $this->oldconn->query($sql139);
                                    
                                    
    $sql140="insert into profile2tab values (".$profile4_id.",23,0)";
    echo '<br> '.$sql140 .' <br> ';
    $res1140 = $this->oldconn->query($sql140);
                                    
                                    
    $sql141="insert into profile2tab values (".$profile4_id.",24,0)";
    echo '<br> '.$sql141 .' <br> ';
    $res141 = $this->oldconn->query($sql141);
                                    
                                    
    $sql142="insert into profile2tab values (".$profile4_id.",25,0)";
    echo '<br> '.$sql142 .' <br> ';
    $res142 = $this->oldconn->query($sql142);
                                    
                                    
                                    
                                    
    $sql143="insert into profile2standardpermissions values (".$profile1_id.",18,0,0)";
    echo '<br> '.$sql143 .' <br> ';
    $res143 = $this->oldconn->query($sql143);

    $sql144="insert into profile2standardpermissions values (".$profile1_id.",18,1,0)";
    echo '<br> '.$sql144 .' <br> ';
    $res144 = $this->oldconn->query($sql144);

    $sql145="insert into profile2standardpermissions values (".$profile1_id.",18,2,0)";
    echo '<br> '.$sql145 .' <br> ';
    $res145 = $this->oldconn->query($sql145);

    $sql146="insert into profile2standardpermissions values (".$profile1_id.",18,3,0)";
    echo '<br> '.$sql146 .' <br> ';
    $res146 = $this->oldconn->query($sql146);

    $sql147="insert into profile2standardpermissions values (".$profile1_id.",18,4,0)";
    echo '<br> '.$sql147 .' <br> ';
    $res147 = $this->oldconn->query($sql147);


    $sql148="insert into profile2standardpermissions values (".$profile1_id.",19,0,0)";
    echo '<br> '.$sql148 .' <br> ';
    $res148 = $this->oldconn->query($sql148);

    $sql149="insert into profile2standardpermissions values (".$profile1_id.",19,1,0)";
    echo '<br> '.$sql149 .' <br> ';
    $res149 = $this->oldconn->query($sql149);

    $sql150="insert into profile2standardpermissions values (".$profile1_id.",19,2,0)";
    echo '<br> '.$sql150 .' <br> ';
    $res150 = $this->oldconn->query($sql150);

                                    
    $sql151="insert into profile2standardpermissions values (".$profile1_id.",19,3,0)";
    echo '<br> '.$sql151 .' <br> ';
    $res151 = $this->oldconn->query($sql151);

    $sql152="insert into profile2standardpermissions values (".$profile1_id.",19,4,0)";
    echo '<br> '.$sql152 .' <br> ';
    $res152 = $this->oldconn->query($sql152);


    $sql153="insert into profile2standardpermissions values (".$profile1_id.",20,0,0)";
    echo '<br> '.$sql153 .' <br> ';
    $res153 = $this->oldconn->query($sql153);
                                    
    $sql154="insert into profile2standardpermissions values (".$profile1_id.",20,1,0)";
    echo '<br> '.$sql154 .' <br> ';
    $res154 = $this->oldconn->query($sql154);
                                    
    $sql155="insert into profile2standardpermissions values (".$profile1_id.",20,2,0)";
    echo '<br> '.$sql155 .' <br> ';
    $res155 = $this->oldconn->query($sql155);
                                                
    $sql156="insert into profile2standardpermissions values (".$profile1_id.",20,3,0)";
    echo '<br> '.$sql155 .' <br> ';
    $res155 = $this->oldconn->query($sql155);
                                    
    $sql="insert into profile2standardpermissions values (".$profile1_id.",20,4,0)";
    echo '<br> '.$sql155 .' <br> ';
    $res155 = $this->oldconn->query($sql155);
                
                
    $sql156="insert into profile2standardpermissions values (".$profile1_id.",21,0,0)";
    echo '<br> '.$sql156 .' <br> ';
    $res156 = $this->oldconn->query($sql156);
                
    $sql157="insert into profile2standardpermissions values (".$profile1_id.",21,1,0)";
    echo '<br> '.$sql157 .' <br> ';
    $res157 = $this->oldconn->query($sql157);
                
    $sql158="insert into profile2standardpermissions values (".$profile1_id.",21,2,0)";
    echo '<br> '.$sql158 .' <br> ';
    $res158 = $this->oldconn->query($sql158);
                
    $sql159="insert into profile2standardpermissions values (".$profile1_id.",21,3,0)";
    echo '<br> '.$sql159 .' <br> ';
    $res159 = $this->oldconn->query($sql159);
                
    $sql160="insert into profile2standardpermissions values (".$profile1_id.",21,4,0)";
    echo '<br> '.$sql160 .' <br> ';
    $res160 = $this->oldconn->query($sql160);
                
                
    $sql161="insert into profile2standardpermissions values (".$profile1_id.",22,0,0)";
    echo '<br> '.$sql161 .' <br> ';
    $res161 = $this->oldconn->query($sql161);
                
    $sql162="insert into profile2standardpermissions values (".$profile1_id.",22,1,0)";
    echo '<br> '.$sql162 .' <br> ';
    $res162 = $this->oldconn->query($sql162);
                
    $sql163="insert into profile2standardpermissions values (".$profile1_id.",22,2,0)";
    echo '<br> '.$sql163 .' <br> ';
    $res163 = $this->oldconn->query($sql163);
                
    $sql164="insert into profile2standardpermissions values (".$profile1_id.",22,3,0)";
    echo '<br> '.$sql164 .' <br> ';
    $res164 = $this->oldconn->query($sql164);
                
    $sql165="insert into profile2standardpermissions values (".$profile1_id.",22,4,0)";
    echo '<br> '.$sql165 .' <br> ';
    $res165 = $this->oldconn->query($sql165);
                
                
    $sql166="insert into profile2standardpermissions values (".$profile1_id.",23,0,0)";
    echo '<br> '.$sql166 .' <br> ';
    $res166 = $this->oldconn->query($sql166);
                
    $sql167="insert into profile2standardpermissions values (".$profile1_id.",23,1,0)";
    echo '<br> '.$sql167 .' <br> ';
    $res167 = $this->oldconn->query($sql167);
                
    $sql168="insert into profile2standardpermissions values (".$profile1_id.",23,2,0)";
    echo '<br> '.$sql168 .' <br> ';
    $res168 = $this->oldconn->query($sql168);
                
    $sql169="insert into profile2standardpermissions values (".$profile1_id.",23,3,0)";
    echo '<br> '.$sql169 .' <br> ';
    $res169 = $this->oldconn->query($sql169);
                
    $sql170="insert into profile2standardpermissions values (".$profile1_id.",23,4,0)";
    echo '<br> '.$sql170 .' <br> ';
    $res170 = $this->oldconn->query($sql170);
                
                
                
    $sql171="insert into profile2standardpermissions values (".$profile2_id.",18,0,0)";
    echo '<br> '.$sql171 .' <br> ';
    $res171 = $this->oldconn->query($sql171);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",18,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",18,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",18,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",18,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile2_id.",19,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",19,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",19,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",19,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",19,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",20,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",20,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",20,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",20,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",20,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile2_id.",21,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",21,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",21,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",21,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",21,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile2_id.",22,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",22,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",22,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",22,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",22,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",23,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",23,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",23,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",23,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile2_id.",23,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
                
                
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",18,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",18,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",18,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",18,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",18,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile3_id.",19,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",19,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",19,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",19,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",19,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile3_id.",20,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",20,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",20,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",20,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",20,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile3_id.",21,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",21,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",21,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",21,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",21,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile3_id.",22,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",22,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",22,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",22,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",22,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile3_id.",23,0,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",23,1,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",23,2,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",23,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile3_id.",23,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",18,0,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",18,1,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",18,2,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",18,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",18,4,0)";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",19,0,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",19,1,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",19,2,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",19,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",19,4,0)";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",20,0,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",20,1,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",20,2,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",20,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",20,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",21,0,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",21,1,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",21,2,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",21,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",21,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",22,0,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",22,1,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",22,2,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",22,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",22,4,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",23,0,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                


    $sql172="insert into profile2standardpermissions values (".$profile4_id.",23,1,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile4_id.",23,2,1)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    $sql172="insert into profile2standardpermissions values (".$profile4_id.",23,3,0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                
    $sql172="insert into profile2standardpermissions values (".$profile4_id.",23,4,0)";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
                

    
    //def_org_share entries
    
    
    $sql172="insert into def_org_share values (".$this->oldconn->getUniqueID('def_org_share').",18,2)";		
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    $sql172="insert into def_org_share values (".$this->oldconn->getUniqueID('def_org_share').",19,2)";		
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    $sql172="insert into def_org_share values (".$this->oldconn->getUniqueID('def_org_share').",20,2)";			
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    $sql172="insert into def_org_share values (".$this->oldconn->getUniqueID('def_org_share').",21,2)";			
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    $sql172="insert into def_org_share values (".$this->oldconn->getUniqueID('def_org_share').",22,2)";			
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

    $sql172="insert into def_org_share values (".$this->oldconn->getUniqueID('def_org_share').",23,2)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
   
   echo '>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<'; 



        //insert into related list table
	$sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Potentials").",'get_opportunities',1,'Potentials',0)";
    echo '<br> >>>>>>>>>>>>>>>  '.$sql172 .' <br> ';
	$this->oldconn->query($sql172);	
	//$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Potentials").",'get_opportunities',1,'Potentials',0)");	
		
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Contacts").",'get_contacts',2,'Contacts',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Activities").",'get_activities',3,'Acivities',0)");

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("HelpDesk").",'get_tickets',4,'HelpDesk',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Activities").",'get_history',5,'History',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",0,'get_attachments',6,'Attachments',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Quotes").",'get_quotes',7,'Quotes',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Invoice").",'get_invoices',8,'Invoice',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("SalesOrder").",'get_salesorder',9,'Sales Order',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Products").",'get_products',10,'Products',0)");

	//Inserting Lead Related Lists	

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Leads").",".$this->getTabid("Activities").",'get_activities',1,'Activities',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Leads").",".$this->getTabid("Emails").",'get_emails',2,'Emails',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Leads").",".$this->getTabid("Activities").",'get_history',3,'History',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Leads").",0,'get_attachments',4,'Attachments',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Leads").",".$this->getTabid("Products").",'get_products',5,'Products',0)");

	//Inserting for contact related lists
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Potentials").",'get_opportunities',1,'Potentials',0)");	
		
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Activities").",'get_activities',2,'Activities',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Emails").",'get_emails',3,'Emails',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("HelpDesk").",'get_tickets',4,'HelpDesk',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Quotes").",'get_quotes',5,'Quotes',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Orders").",'get_purchase_orders',6,'Purchase Order',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("SalesOrder").",'get_salesorder',7,'Sales Order',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Products").",'get_products',8,'Products',0)");

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Activities").",'get_history',9,'History',0)");

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",0,'get_attachments',10,'Attachments',0)");

	//Inserting Potential Related Lists	

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("Activities").",'get_activities',1,'Activities',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("Contacts").",'get_contacts',2,'Contacts',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("Products").",'get_products',3,'History',0)");

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",0,'get_stage_history',4,'Sales Stage History',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",0,'get_attachments',5,'Attachments',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("Quotes").",'get_Quotes',6,'Quotes',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("SalesOrder").",'get_salesorder',7,'Sales Order',0)");

		//Inserting Product Related Lists	

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("HelpDesk").",'get_tickets',1,'HelpDesk',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("Activities").",'get_activities',2,'Activities',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",0,'get_attachments',3,'Attachments',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("Quotes").",'get_quotes',4,'Quotes',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("Orders").",'get_purchase_orders',5,'Purchase Order',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("SalesOrder").",'get_salesorder',6,'Sales Order',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("Invoice").",'get_invoices',7,'Invoice',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("PriceBook").",'get_product_pricebooks',8,'PriceBook',0)");
	
		//Inserting Emails Related Lists	

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Emails").",".$this->getTabid("Contacts").",'get_contacts',1,'Contacts',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Emails").",0,'get_users',2,'Users',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Emails").",0,'get_attachments',3,'Attachments',0)");

		//Inserting HelpDesk Related Lists
		
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("HelpDesk").",".$this->getTabid("Activities").",'get_activities',1,'Activities',0)");

	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("HelpDesk").",0,'get_attachments',2,'Attachments',0)");

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("PriceBook").",14,'get_pricebook_products',2,'Products',0)");

        // Inserting Vendor Related Lists
        $this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Vendor").",14,'get_products',1,'Products',0)");

        $this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Vendor").",21,'get_purchase_orders',2,'Products',0)");

        $this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Vendor").",4,'get_contacts',3,'Contacts',0)");

	// Inserting Quotes Related Lists
	
        $this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Quotes").",".$this->getTabid("Invoice").",'get_salesorder',1,'Sales Order',0)");
        
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Quotes").",9,'get_activities',2,'Activities',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Quotes").",9,'get_history',3,'History',0)");

	// Inserting Purchase order Related Lists

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Orders").",9,'get_activities',1,'Activities',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Orders").",0,'get_attachments',2,'Attachments',0)");
	
	// Inserting Sales order Related Lists

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("SalesOrder").",9,'get_activities',1,'Activities',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("SalesOrder").",0,'get_attachments',2,'Attachments',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("SalesOrder").",".$this->getTabid("Invoice").",'get_invoices',3,'Invoice',0)");
	
	// Inserting Invoice Related Lists

	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Invoice").",9,'get_activities',1,'Activities',0)");
	
	$this->oldconn->query("insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Invoice").",0,'get_attachments',2,'Attachments',0)");
	
/*

    //Inserting for account related lists
    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Potentials").",'get_opportunities',1,'Potentials',0)";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Contacts").",'get_contacts',2,'Contacts',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Activities").",'get_activities',3,'Acivities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
        



    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("HelpDesk").",'get_tickets',4,'HelpDesk',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",".$this->getTabid("Activities").",'get_history',5,'History',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",0,'get_attachments',6,'Attachments',0)";

    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",20,'get_quotes',7,'Quotes',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",23,'get_invoices',8,'Invoice',0)";
	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Accounts").",22,'get_salesorder',9,'Sales Order',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Leads").",".$this->getTabid("Activities").",'get_activities',1,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Leads").",".$this->getTabid("Activities").",'get_history',3,'History',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
    
                        	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Leads").",0,'get_attachments',4,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    //Inserting for contact related lists
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Potentials").",'get_opportunities',1,'Potentials',0)";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
		
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Activities").",'get_activities',2,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Emails").",'get_emails',3,'Emails',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    


	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("HelpDesk").",'get_tickets',4,'HelpDesk',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    


    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Activities").",'get_history',5,'History',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    


	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",0,'get_attachments',6,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Quotes").",'get_quotes',7,'Quotes',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Orders").",'get_purchase_orders',8,'Purchase Order',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("SalesOrder").",'get_salesorder',9,'Sales Order',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Contacts").",".$this->getTabid("Products").",'get_products',10,'Products',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    //Inserting Potential Related Lists	
    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("Activities").",'get_activities',1,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("Contacts").",'get_contacts',2,'Contacts',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("Products").",'get_products',3,'History',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",0,'get_stage_history',4,'Sales Stage History',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",0,'get_attachments',5,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("Quotes").",'get_Quotes',6,'Quotes',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Potentials").",".$this->getTabid("SalesOrder").",'get_salesorder',7,'Sales Order',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    //Inserting Product Related Lists	

    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("HelpDesk").",'get_tickets',1,'HelpDesk',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("Activities").",'get_activities',2,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",0,'get_attachments',3,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Products").",".$this->getTabid("Quotes").",'get_quotes',4,'Quotes',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    //Inserting Emails Related Lists	

    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Emails").",".$this->getTabid("Contacts").",'get_contacts',1,'Contacts',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Emails").",0,'get_users',2,'Users',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Emails").",0,'get_attachments',3,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    //Inserting HelpDesk Related Lists
		
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("HelpDesk").",".$this->getTabid("Activities").",'get_activities',1,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("HelpDesk").",0,'get_attachments',2,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
        
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("PriceBook").",14,'get_pricebook_products',2,'Products',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    // Inserting Vendor Related Lists
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Vendor").",14,'get_products',1,'Products',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Vendor").",21,'get_purchase_orders',2,'Products',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Vendor").",4,'get_contacts',3,'Contacts',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
    
    // Inserting Quotes Related Lists
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Quotes").",22,'get_salesorder',1,'Sales Order',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
        
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Quotes").",9,'get_activities',2,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Quotes").",9,'get_history',3,'History',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    

    // Inserting Purchase order Related Lists

    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Orders").",9,'get_activities',1,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Orders").",0,'get_attachments',2,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    // Inserting Sales order Related Lists
    
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("SalesOrder").",9,'get_activities',1,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("SalesOrder").",0,'get_attachments',2,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    // Inserting Invoice Related Lists

    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Invoice").",9,'get_activities',1,'Activities',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
    
	
    $sql172="insert into relatedlists values(".$this->oldconn->getUniqueID('relatedlists').",".$this->getTabid("Invoice").",0,'get_attachments',2,'Attachments',0)";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
  */  

    //Inserting Inventory Notifications
    $invoice_body = 'Dear {HANDLER},

The current stock of {PRODUCTNAME} in our warehouse is {CURRENTSTOCK}. Kindly procure required number of units as the stock level is below reorder level {REORDERLEVELVALUE}.

Please treat this information as Urgent as the invoice is already sent  to the customer.

Severity: Critical

Thanks,
{CURRENTUSER}';

		
    $sql172="insert into inventorynotification(notificationid,notificationname,notificationsubject,notificationbody,label) values (".$this->oldconn->getUniqueID("inventorynotification").",'InvoiceNotification','{PRODUCTNAME} Stock Level is Low','".$invoice_body." ','InvoiceNotificationDescription')";

    $quote_body = 'Dear {HANDLER},

Quote is generated for {QUOTEQUANTITY} units of {PRODUCTNAME}. The current stock of {PRODUCTNAME} in our warehouse is {CURRENTSTOCK}. 

Severity: Minor

Thanks,
{CURRENTUSER}';	
	    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
	
		
               $sql172="insert into inventorynotification(notificationid,notificationname,notificationsubject,notificationbody,label) values (".$this->oldconn->getUniqueID("inventorynotification").",'QuoteNotification','Quote given for {PRODUCTNAME}','".$quote_body." ','QuoteNotificationDescription')";

		$so_body = 'Dear {HANDLER},

                 SalesOrder is generated for {SOQUANTITY} units of {PRODUCTNAME}. The current stock of {PRODUCTNAME} in our warehouse is {CURRENTSTOCK}. 

                 Please treat this information  with priority as the sales order is already generated.

                 Severity: Major

                 Thanks,
{CURRENTUSER}';

    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    
		
               $sql172="insert into inventorynotification(notificationid,notificationname,notificationsubject,notificationbody,label) values (".$this->oldconn->getUniqueID("inventorynotification").",'SalesOrderNotification','Sales Order generated for {PRODUCTNAME}','".$so_body." ','SalesOrderNotificationDescription')";


    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
    



$sql172="insert into field values (15,".$this->oldconn->getUniqueID("field").",'product_id','faq',1,'59','product_id','Product Name',1,0,0,100,1,1,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


$sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'sales_start_date','products',1,'5','sales_start_date','Sales Start Date',1,0,0,100,5,1,1,'D~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'sales_end_date','products',1,'5','sales_end_date','Sales End Date',1,0,0,100,6,1,1,'D~O~OTH~GE~sales_start_date~Sales Start Date')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block 3 stock info

 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'usageunit','products',1,'15','usageunit','Usage Unit',1,0,0,100,1,3,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 //Block2 Pricing Information


 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'currency','products',1,'1','currency','Currency',1,0,0,100,3,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'taxclass','products',1,'15','taxclass','Tax Class',1,0,0,100,4,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'website','products',1,'17','website','Website',1,0,0,100,12,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'glacct','products',1,'15','glacct','GL Account',1,0,0,100,18,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'handler','products',1,'52','assigned_user_id','Handler',1,0,0,100,5,3,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


$sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'vendor_id','products',1,'75','vendor_id','Vendor Name',1,0,0,100,13,1,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'qtyinstock','products',1,'1','qtyinstock','Qty In Stock',1,0,0,100,3,3,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);










 
$sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'mfr_part_no','products',1,'1','mfr_part_no','Mfr PartNo',1,0,0,100,14,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'vendor_part_no','products',1,'1','vendor_part_no','Vendor PartNo',1,0,0,100,15,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'serialno','products',1,'1','serial_no','Serial No',1,0,0,100,16,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

$sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'productsheet','products',1,'1','productsheet','Product Sheet',1,0,0,100,17,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);



$sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'reorderlevel','products',1,'1','reorderlevel','Reorder Level',1,0,0,100,4,3,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'qtyindemand','products',1,'1','qtyindemand','Qty In Demand',1,0,0,100,6,3,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block 4 Description Info
 //$sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'product_description','products',1,'19','product_description','Description',1,0,0,100,1,4,1,'V~O')";
  //  echo '<br> '.$sql172 .' <br> ';
  //  $res172 = $this->oldconn->query($sql172);


 


$sql172="insert into field values (16,".$this->oldconn->getUniqueID("field").",'due_date','activity',1,'5','due_date','End Date',1,0,0,100,5,1,1,'D~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

  $sql172="insert into field values (16,".$this->oldconn->getUniqueID("field").",'recurringtype','recurringevents',1,'15','recurringtype','Recurrence',1,0,0,100,6,1,1,'O~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




 //Vendor Details --START
 //Block1
 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'vendorname','vendor',1,'2','vendorname','Vendor Name',1,0,0,100,1,1,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'phone','vendor',1,'1','phone','Phone',1,0,0,100,3,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'email','vendor',1,'13','email','Email',1,0,0,100,4,1,1,'E~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'website','vendor',1,'17','website','Website',1,0,0,100,5,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'glacct','vendor',1,'15','glacct','GL Account',1,0,0,100,6,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'category','vendor',1,'1','category','Category',1,0,0,100,7,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

$sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'createdtime','crmentity',1,'70','createdtime','Created Time',1,0,0,100,8,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'modifiedtime','crmentity',1,'70','modifiedtime','Modified Time',1,0,0,100,9,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 //Block 2
 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'street','vendor',1,'21','treet','Street',1,0,0,100,1,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'city','vendor',1,'1','city','City',1,0,0,100,2,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'state','vendor',1,'1','state','State',1,0,0,100,3,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'postalcode','vendor',1,'1','postalcode','Postal Code',1,0,0,100,4,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'country','vendor',1,'1','country','Country',1,0,0,100,5,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 //Block 3
 $sql172="insert into field values (18,".$this->oldconn->getUniqueID("field").",'description','crmentity',1,'19','description','Description',1,0,0,100,1,3,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Vendor Details -- END

 //PriceBook Details Start
 //Block1
 $sql172="insert into field values (19,".$this->oldconn->getUniqueID("field").",'bookname','pricebook',1,'2','bookname','Price Book Name',1,0,0,100,1,1,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (19,".$this->oldconn->getUniqueID("field").",'active','pricebook',1,'56','active','Active',1,0,0,100,3,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

$sql172="insert into field values (19,".$this->oldconn->getUniqueID("field").",'createdtime','crmentity',1,'70','createdtime','Created Time',1,0,0,100,4,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (19,".$this->oldconn->getUniqueID("field").",'modifiedtime','crmentity',1,'70','modifiedtime','Modified Time',1,0,0,100,5,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 //Block2
$sql172="insert into field values (19,".$this->oldconn->getUniqueID("field").",'description','crmentity',1,'19','description','Description',1,0,0,100,1,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

//PriceBook Details End


//Quote Details -- START
//Block1
 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'subject','quotes',1,'2','subject','Subject',1,0,0,100,1,1,1,'V~M')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'potentialid','quotes',1,'76','potential_id','Potential Name',1,0,0,100,2,1,1,'I~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'quotestage','quotes',1,'15','quotestage','Quote Stage',1,0,0,100,3,1,1,'V~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'validtill','quotes',1,'5','validtill','Valid Till',1,0,0,100,4,1,1,'D~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'team','quotes',1,'1','team','Team',1,0,0,100,5,1,1,'V~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'contactid','quotes',1,'57','contact_id','Contact Name',1,0,0,100,6,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 //$sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'currency','quotes',1,'1','currency','Currency',1,0,0,100,7,1,1,'V~O')";
   // echo '<br> '.$sql172 .' <br> ';
    //$res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'carrier','quotes',1,'15','carrier','Carrier',1,0,0,100,8,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'subtotal','quotes',1,'1','hdnSubTotal','Sub Total',1,0,0,100,9,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'shipping','quotes',1,'1','shipping','Shipping',1,0,0,100,10,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'inventorymanager','quotes',1,'77','assigned_user_id1','Inventory Manager',1,0,0,100,11,1,1,'I~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 // $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'type','quotes',1,'1','type','Type',1,0,0,100,12,1,1,'V~O')";
 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'tax','quotes',1,'1','txtTax','Tax',1,0,0,100,13,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'adjustment','quotes',1,'1','txtAdjustment','Adjustment',1,0,0,100,20,1,3,'NN~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'total','quotes',1,'1','hdnGrandTotal','Total',1,0,0,100,14,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'accountid','quotes',1,'73','account_id','Account Name',1,0,0,100,16,1,1,'I~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'smownerid','crmentity',1,'52','assigned_user_id','Assigned To',1,0,0,100,17,1,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'createdtime','crmentity',1,'70','createdtime','Created Time',1,0,0,100,18,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'modifiedtime','crmentity',1,'70','modifiedtime','Modified Time',1,0,0,100,19,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block 2
 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'bill_street','quotesbillads',1,'24','bill_street','Billing Address',1,0,0,100,1,2,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'ship_street','quotesshipads',1,'24','ship_street','Shipping Address',1,0,0,100,2,2,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'bill_city','quotesbillads',1,'1','bill_city','Billing City',1,0,0,100,3,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'ship_city','quotesshipads',1,'1','ship_city','Shipping City',1,0,0,100,4,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'bill_state','quotesbillads',1,'1','bill_state','Billing State',1,0,0,100,5,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'ship_state','quotesshipads',1,'1','ship_state','Shipping State',1,0,0,100,6,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'bill_code','quotesbillads',1,'1','bill_code','Billing Code',1,0,0,100,7,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'ship_code','quotesshipads',1,'1','ship_code','Shipping Code',1,0,0,100,8,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);



 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'bill_country','quotesbillads',1,'1','bill_country','Billing Country',1,0,0,100,9,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'ship_country','quotesshipads',1,'1','ship_country','Shipping Country',1,0,0,100,10,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block3
 $sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'description','crmentity',1,'19','description','Description',1,0,0,100,1,3,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block 6
$sql172="insert into field values (20,".$this->oldconn->getUniqueID("field").",'terms_conditions','quotes',1,'19','terms_conditions','Terms & Conditions',1,0,0,100,1,6,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);













//to continue 


//Quote Details -- END

//Purchase Order Details -- START
//Block1
 
 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'subject','purchaseorder',1,'2','subject','Subject',1,0,0,100,1,1,1,'V~M')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'vendorid','purchaseorder',1,'81','vendor_id','Vendor Name',1,0,0,100,3,1,1,'I~M')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'requisition_no','purchaseorder',1,'1','requisition_no','Requisition No',1,0,0,100,4,1,1,'V~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'tracking_no','purchaseorder',1,'1','tracking_no','Tracking Number',1,0,0,100,5,1,1,'V~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'contactid','purchaseorder',1,'57','contact_id','Contact Name',1,0,0,100,6,1,1,'I~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'duedate','purchaseorder',1,'5','duedate','Due Date',1,0,0,100,7,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'carrier','purchaseorder',1,'15','carrier','Carrier',1,0,0,100,8,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'salestax','purchaseorder',1,'1','txtTax','Sales Tax',1,0,0,100,10,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'adjustment','purchaseorder',1,'1','txtAdjustment','Adjustment',1,0,0,100,10,1,3,'NN~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'salescommission','purchaseorder',1,'1','salescommission','Sales Commission',1,0,0,100,11,1,1,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'exciseduty','purchaseorder',1,'1','exciseduty','Excise Duty',1,0,0,100,12,1,1,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'total','purchaseorder',1,'1','hdnGrandTotal','Total',1,0,0,100,13,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'subtotal','purchaseorder',1,'1','hdnSubTotal','Sub Total',1,0,0,100,14,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'postatus','purchaseorder',1,'15','postatus','Status',1,0,0,100,15,1,1,'V~O')";
 echo '<br>DON '.$sql172 .' <br> ';
 $this->oldconn->query($sql172);


 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'smownerid','crmentity',1,'52','assigned_user_id','Assigned To',1,0,0,100,16,1,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'createdtime','crmentity',1,'70','createdtime','Created Time',1,0,0,100,17,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'modifiedtime','crmentity',1,'70','modifiedtime','Modified Time',1,0,0,100,18,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block 2
$sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'bill_street','pobillads',1,'24','bill_street','Billing Address',1,0,0,100,1,2,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'ship_street','poshipads',1,'24','ship_street','Shipping Address',1,0,0,100,2,2,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'bill_city','pobillads',1,'1','bill_city','Billing City',1,0,0,100,3,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'ship_city','poshipads',1,'1','ship_city','Shipping City',1,0,0,100,4,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'bill_state','pobillads',1,'1','bill_state','Billing State',1,0,0,100,5,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'ship_state','poshipads',1,'1','ship_state','Shipping State',1,0,0,100,6,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'bill_code','pobillads',1,'1','bill_code','Billing Code',1,0,0,100,7,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'ship_code','poshipads',1,'1','ship_code','Shipping Code',1,0,0,100,8,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);



 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'bill_country','pobillads',1,'1','bill_country','Billing Country',1,0,0,100,9,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'ship_country','poshipads',1,'1','ship_country','Shipping Country',1,0,0,100,10,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block3
 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'description','crmentity',1,'19','description','Description',1,0,0,100,1,3,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block6
 $sql172="insert into field values (21,".$this->oldconn->getUniqueID("field").",'terms_conditions','purchaseorder',1,'19','terms_conditions','Terms & Conditions',1,0,0,100,1,6,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 //Purchase Order Details -- END

 //Sales Order Details -- START
 //Block1
 
 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'subject','salesorder',1,'2','subject','Subject',1,0,0,100,1,1,1,'V~M')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'potentialid','salesorder',1,'76','potential_id','Potential Name',1,0,0,100,2,1,1,'I~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'customerno','salesorder',1,'1','customerno','Customer No',1,0,0,100,3,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

$sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'quoteid','salesorder',1,'78','quote_id','Quote Name',1,0,0,100,4,1,1,'I~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

$sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'purchaseorder','salesorder',1,'1','purchaseorder','Purchase Order',1,0,0,100,4,1,1,'V~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);



 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'contactid','salesorder',1,'57','contact_id','Contact Name',1,0,0,100,6,1,1,'I~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
 
    
    $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'duedate','salesorder',1,'5','duedate','Due Date',1,0,0,100,8,1,1,'D~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'carrier','salesorder',1,'15','carrier','Carrier',1,0,0,100,9,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'pending','salesorder',1,'1','pending','Pending',1,0,0,100,10,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

$sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'sostatus','salesorder',1,'15','sostatus','Status',1,0,0,100,11,1,1,'V~O')";
   echo '<br> DON'.$sql172 .' <br> ';
    $this->oldconn->query($sql172);


 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'salestax','salesorder',1,'1','txtTax','Sales Tax',1,0,0,100,12,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'adjustment','salesorder',1,'1','txtAdjustment','Sales Tax',1,0,0,100,12,1,3,'NN~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'salescommission','salesorder',1,'1','salescommission','Sales Commission',1,0,0,100,13,1,1,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'exciseduty','salesorder',1,'1','exciseduty','Excise Duty',1,0,0,100,13,1,1,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'total','salesorder',1,'1','hdnGrandTotal','Total',1,0,0,100,14,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'subtotal','salesorder',1,'1','hdnSubTotal','Total',1,0,0,100,15,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'accountid','salesorder',1,'73','account_id','Account Name',1,0,0,100,16,1,1,'I~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'smownerid','crmentity',1,'52','assigned_user_id','Assigned To',1,0,0,100,17,1,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'createdtime','crmentity',1,'70','createdtime','Created Time',1,0,0,100,18,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'modifiedtime','crmentity',1,'70','modifiedtime','Modified Time',1,0,0,100,19,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block 2
 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'bill_street','sobillads',1,'24','bill_street','Billing Address',1,0,0,100,1,2,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'ship_street','soshipads',1,'24','ship_street','Shipping Address',1,0,0,100,2,2,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'bill_city','sobillads',1,'1','bill_city','Billing City',1,0,0,100,3,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'ship_city','soshipads',1,'1','ship_city','Shipping City',1,0,0,100,4,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'bill_state','sobillads',1,'1','bill_state','Billing State',1,0,0,100,5,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'ship_state','soshipads',1,'1','ship_state','Shipping State',1,0,0,100,6,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'bill_code','sobillads',1,'1','bill_code','Billing Code',1,0,0,100,7,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'ship_code','soshipads',1,'1','ship_code','Shipping Code',1,0,0,100,8,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);



 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'bill_country','sobillads',1,'1','bill_country','Billing Country',1,0,0,100,9,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'ship_country','soshipads',1,'1','ship_country','Shipping Country',1,0,0,100,10,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block3
 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'description','crmentity',1,'19','description','Description',1,0,0,100,1,3,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block6
 $sql172="insert into field values (22,".$this->oldconn->getUniqueID("field").",'terms_conditions','salesorder',1,'19','terms_conditions','Terms & Conditions',1,0,0,100,1,6,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 //Sales Order Details -- END

 //Invoice Details -- START
 //Block1
 
$sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'subject','invoice',1,'2','subject','Subject',1,0,0,100,1,1,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'salesorderid','invoice',1,'80','salesorder_id','Sales Order',1,0,0,100,2,1,1,'I~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'customerno','invoice',1,'1','customerno','Customer No',1,0,0,100,3,1,1,'V~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

/*
 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'notes','invoice',1,'1','notes','Notes',1,0,0,100,4,1,1,'V~O')";	
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
*/

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'invoicedate','invoice',1,'5','invoicedate','Invoice Date',1,0,0,100,5,1,1,'D~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'duedate','invoice',1,'5','duedate','Due Date',1,0,0,100,6,1,1,'D~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
/*
 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'invoiceterms','invoice',1,'1','invoiceterms','Invoice Terms',1,0,0,100,7,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);
*/

$sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'purchaseorder','invoice',1,'1','purchaseorder','Purchase Order',1,0,0,100,8,1,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'salestax','invoice',1,'1','txtTax','Sales Tax',1,0,0,100,9,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'adjustment','invoice',1,'1','txtAdjustment','Sales Tax',1,0,0,100,9,1,3,'NN~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'salescommission','invoice',1,'1','salescommission','Sales Commission',1,0,0,10,13,1,1,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'exciseduty','invoice',1,'1','exciseduty','Excise Duty',1,0,0,100,11,1,1,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'subtotal','invoice',1,'1','hdnSubTotal','Sub Total',1,0,0,100,12,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'total','invoice',1,'1','hdnGrandTotal','Total',1,0,0,100,13,1,3,'N~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

$sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'accountid','invoice',1,'73','account_id','Account Name',1,0,0,100,14,1,1,'I~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

$sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'invoicestatus','invoice',1,'15','invoicestatus','Status',1,0,0,100,15,1,1,'V~O')";
    echo '<br> DON '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'smownerid','crmentity',1,'52','assigned_user_id','Assigned To',1,0,0,100,16,1,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'createdtime','crmentity',1,'70','createdtime','Created Time',1,0,0,100,17,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'modifiedtime','crmentity',1,'70','modifiedtime','Modified Time',1,0,0,100,18,1,2,'T~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block 2
 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'bill_street','invoicebillads',1,'24','bill_street','Billing Address',1,0,0,100,1,2,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'ship_street','invoiceshipads',1,'24','ship_street','Shipping Address',1,0,0,100,2,2,1,'V~M')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'bill_city','invoicebillads',1,'1','bill_city','Billing City',1,0,0,100,3,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'ship_city','invoiceshipads',1,'1','ship_city','Shipping City',1,0,0,100,4,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'bill_state','invoicebillads',1,'1','bill_state','Billing State',1,0,0,100,5,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'ship_state','invoiceshipads',1,'1','ship_state','Shipping State',1,0,0,100,6,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'bill_code','invoicebillads',1,'1','bill_code','Billing Code',1,0,0,100,7,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'ship_code','invoiceshipads',1,'1','ship_code','Shipping Code',1,0,0,100,8,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);



 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'bill_country','invoicebillads',1,'1','bill_country','Billing Country',1,0,0,100,9,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'ship_country','invoiceshipads',1,'1','ship_country','Shipping Country',1,0,0,100,10,2,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 //Block3
 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'description','crmentity',1,'19','description','Description',1,0,0,100,1,3,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 //Block6
 $sql172="insert into field values (23,".$this->oldconn->getUniqueID("field").",'terms_conditions','invoice',1,'19','terms_conditions','Terms & Conditions',1,0,0,100,1,6,1,'V~O')";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);




 $sql175="update field set sequence=10 where columnname='createdtime' and tablename='crmentity' and fieldlabel='Created Time' and tabid=13 and typeofdata='T~O'";
    echo '<br> '.$sql175 .' <br> ';
    $res175 = $this->oldconn->query($sql175);

 $sql175="update field set sequence=11 where columnname='modifiedtime' and tablename='crmentity' and fieldlabel='Modified Time' and tabid=13 and typeofdata='T~O'";
    echo '<br> '.$sql175 .' <br> ';
    $res175 = $this->oldconn->query($sql175);




$sql172="insert into field values (14,".$this->oldconn->getUniqueID("field").",'contactid','products',1,'57','contact_id','Contact Name',1,0,0,100,11,1,1,'I~O')";

    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);


 $sql172 = "update field set sequence=9 where columnname='crmid' and tablename='seactivityrel' and fieldlabel='Related To' and typeofdata='I~O' and tabid=16";
    echo '<br> Fixed by don'.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

 $sql172 = "update field set sequence=10, block=1  where columnname='contactid' and tablename='cntactivityrel' and fieldlabel='Contact Name' and typeofdata='V~O'";
    echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);



$sql172="update field set sequence=2 where columnname='category' and tablename='faq' and fieldlabel='Category'";
   echo '<br> '.$sql172 .' <br> ';
    $res172 = $this->oldconn->query($sql172);

//Code Added by DonKing
	
	$sql173="insert into organizationdetails(organizationame,address,city,state,country,code,phone,fax,website,logoname) values ('vtiger',' 40-41-42, Sivasundar Apartments, Flat D-II, Shastri Street, Velachery','Chennai','Tamil Nadu','India','600 042','+91-44-5202-1990','+91-44-5202-1990','www.vtiger.com','vtiger_crm-logo.jpg')";
	echo '<br> DON'.$sql173 .' <br> ';
	$res173 = $this->oldconn->query($sql173);


$sql174="update field set uitype='23',typeofdata='D~M~OTH~GE~date_start~Start Date & Time' where columnname='due_date' and tablename='activity' and fieldlabel='Due Date'";
   echo '<br> DON '.$sql174 .' <br> ';
    $this->oldconn->query($sql174);

$sql175="update field set uitype='23',typeofdata='D~M~OTH~GE~date_start~Start Date & Time' where columnname='due_date' and tablename='activity' and fieldlabel='End Date'";
   echo '<br> DON '.$sql175 .' <br> ';
    $this->oldconn->query($sql175);

$sql176="update field set fieldname='faq_answer',uitype='20',typeofdata='V~M' where columnname='answer' and tablename='faq' and fieldlabel='Answer'";
   echo '<br> DON '.$sql176 .' <br> ';
    $this->oldconn->query($sql176);

$sql176="update field set uitype='20',typeofdata='V~M' where columnname='question' and tablename='faq' and fieldlabel='Question'";
   echo '<br> DON '.$sql176 .' <br> ';
    $this->oldconn->query($sql176);

//Changing the annual revenue in field  table for module leads

$sql176="update field set typeofdata='I~O' where columnname='annualrevenue' and tablename='leaddetails' and fieldlabel='Annual Revenue'";
   echo '<br> DON '.$sql176 .' <br> ';
    $this->oldconn->query($sql176);

//Deleting the Profile2utility entry for export Activity in profile2utility table
	$sql176="delete from profile2utility where tabid=9 and activityid=6";
   	echo '<br> DON '.$sql176 .' <br> ';
	$this->oldconn->query($sql176);

//Updating the Email
	$sql176="update field set typeofdata='E~O' where columnname='email1' and tablename='custbranch' and fieldlabel='Email'";
   echo '<br> DON '.$sql176 .' <br> ';
    $this->oldconn->query($sql176);

	$sql176="update field set typeofdata='E~O' where columnname='email2' and tablename='custbranch' and fieldlabel='Other Email'";
   echo '<br> DON '.$sql176 .' <br> ';
    $this->oldconn->query($sql176);

	$sql176="update field set typeofdata='E~O' where columnname='email' and tablename='leaddetails' and fieldlabel='Email'";
   echo '<br> DON '.$sql176 .' <br> ';
    $this->oldconn->query($sql176);

	$sql176="update field set typeofdata='E~O' where columnname='email' and tablename='contactdetails' and fieldlabel='Email'";
   echo '<br> DON '.$sql176 .' <br> ';
    $this->oldconn->query($sql176);	
		 

//Inserting into email templates table

	$body='
	Hello!

	On behalf of the vtiger team,  I am pleased to announce the release of vtiger crm4.2 . This is a feature packed release including the mass email template handling, custom view feature, reports feature and a host of other utilities. vtiger runs on all platforms.

	Notable Features of vtiger are :
	-Email Client Integration
	-Trouble Ticket Integration
	-Invoice Management Integration
	-Reports Integration
	-Portal Integration
	-Enhanced Word Plugin Support
	-Custom View Integration

	Known Issues:
	-ABCD
	-EFGH
	-IJKL
	-MNOP
	-QRST';

          $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Announcement for Release','Announcement for Release','Announcement of a release','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");
	


$body='name
street,
city,
state,
 zip)
 
 Dear
 
 Please check the following invoices that are yet to be paid by you:
 
 No. Date      Amount
 1   1/1/01    $4000
 2   2/2//01   $5000
 3   3/3/01    $10000
 4   7/4/01    $23560
 
 Kindly let us know if there are any issues that you feel are pending to be discussed.
 We will be more than happy to give you a call.
 We would like to continue our business with you.
 
 Sincerely,
 name
 title';


               $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Pending Invoices','Invoices Pending','Payment Due','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");





$body=' Dear

Your proposal on the project XYZW has been reviewed by us
and is acceptable in its entirety.

We are eagerly looking forward to this project
and are pleased about having the opportunity to work
together. We look forward to a long standing relationship
with your esteemed firm.

I would like to take this opportunity to invite you
to a game of golf on Wednesday morning 9am at the
Cuff Links Ground. We will be waiting for you in the
Executive Lounge.

Looking forward to seeing you there.

Sincerely,
name
title';
	       
               $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Acceptance Proposal','Acceptance Proposal','Acceptance of Proposal','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");


$body= ' The undersigned hereby acknowledges receipt and delivery
of the goods.
The undersigned will release the payment subject to the goods being discovered not satisfactory.

Signed under seal this <date>

Sincerely,
name
title';
	       
               $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Good received acknowledgement','Goods received acknowledgement','Acknowledged Receipt of Goods','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");


	       $body= ' Dear
	 We are in receipt of your order as contained in the
   purchase order form.We consider this to be final and binding on both sides.
If there be any exceptions noted, we shall consider them
only if the objection is received within ten days of receipt of
this notice.

Thank you for your patronage.
Sincerely,
name
title';


	       
               $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Accept Order','Accept Order','Acknowledgement/Acceptance of Order','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");




$body='Dear

We are relocating our office to
11111,XYZDEF Cross,
UVWWX Circle
The telephone number for this new location is (101) 1212-1328.

Our Manufacturing Division will continue operations
at 3250 Lovedale Square Avenue, in Frankfurt.

We hope to keep in touch with you all.
Please update your addressbooks.


Thank You,
name
title';
	       
               $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Address Change','Change of Address','Address Change','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");



$body='Dear

Thank you for extending us the opportunity to meet with
you and members of your staff.

I know that John Doe serviced your account
for many years and made many friends at your firm. He has personally
discussed with me the deep relationship that he had with your firm.
While his presence will be missed, I can promise that we will
continue to provide the fine service that was accorded by
John to your firm.

I was genuinely touched to receive such fine hospitality.

Thank you once again.

Sincerely,
name
title';


	       
               $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Follow Up','Follow Up','Follow Up of meeting','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");



$body='Congratulations!

The numbers are in and I am proud to inform you that our
total sales for the previous quarter
amounts to $100,000,00.00!. This is the first time
we have exceeded the target by almost 30%.
We have also beat the previous quarter record by a
whopping 75%!

Let us meet at Smoking Joe for a drink in the evening!

C you all there guys!

Sincerely,
name
title';

	       
               $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Target Crossed!','Target Crossed!','Fantastic Sales Spree!','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");

$body='
Dear

Thank you for your confidence in our ability to serve you.
We are glad to be given the chance to serve you.I look
forward to establishing a long term partnership with you.
Consider me as a friend.
Should any need arise,please do give us a call.

Sincerely,
name
title';

	       
               $this->oldconn->query("insert into emailtemplates(foldername,templatename,subject,description,body,deleted,templateid) values ('Public','Thanks Note','Thanks Note','Note of thanks','".$body."',0,".$this->oldconn->getUniqueID('emailtemplates').")");



	  $sql35= "truncate table def_org_field";
	  echo '<br> '.$sql35 .' <br> ';
	  $res35 = $this->oldconn->query($sql35);

	  $sql360= "truncate table profile2field";
	  echo '<br> '.$sql360 .' <br> ';
	  $res560 = $this->oldconn->query($sql360);
	  //$sql100 = "insert into profile2field values (1,6,22,0,1)";
  	  //$this->oldconn->query($sql100);	  

	  //check if the table exists
  $sql35= "select * from profile2field ";
  echo '<br> '.$sql35 .' <br> ';
  $res35 = $this->oldconn->query($sql35);
  $count = $this->oldconn->num_rows($res35);
  echo 'the test count is '.$count .'<br>';


  $sql35= "select profileid from profile";
  echo '<br> '.$sql35 .' <br> ';
  $res35 = $this->oldconn->query($sql35);
  $count = $this->oldconn->num_rows($res35);
  echo 'the count is '.$count .'<br>';
  for($i=0;$i < $count;$i++)
  {
	  $prof_id = $this->oldconn->query_result($res35,$i,'profileid');
	  //insertProfile2field($prof_id);
	  $fld_result = $this->oldconn->query("select * from field where displaytype in (1,2)");
	  $num_rows = $this->oldconn->num_rows($fld_result);
	  for($j=0; $j<$num_rows; $j++)
	  {
		  $tab_id = $this->oldconn->query_result($fld_result,$j,'tabid');
		  $field_id = $this->oldconn->query_result($fld_result,$j,'fieldid');
		  $query = "insert into profile2field values (".$prof_id.",".$tab_id.",".$field_id.",0,1)";
		  echo '<br> ***********  the query is ' .$query;
		  $this->oldconn->query("insert into profile2field values (".$prof_id.",".$tab_id.",".$field_id.",0,1)");
	  }

  }

  //inserting into default org field 
  $fld_result = $this->oldconn->query("select * from field where displaytype in (1,2)");
  $num_rows = $this->oldconn->num_rows($fld_result);
  for($i=0; $i < $num_rows; $i++)
  {
	  $tab_id = $this->oldconn->query_result($fld_result,$i,'tabid');
	  $field_id = $this->oldconn->query_result($fld_result,$i,'fieldid');
	  $this->oldconn->query("insert into def_org_field values (".$tab_id.",".$field_id.",0,1)");
  }

	//Populating combo values
	require("include/ComboStrings.php");
	$comboTables = Array('rsscategory','usageunit','glacct','quotestage','carrier','taxclass','recurringtype','faqstatus','sostatus','postatus','invoicestatus');
	foreach ($comboTables as $comTab)
	{
		$this->insertComboValues($combo_strings[$comTab."_dom"],$comTab);
	}	

  }

/*
  function truncateTables()
  {
echo ' in the method truncateTables ';
	  $sql35= "truncate table def_org_share";
	  echo '<br> '.$sql135 .' <br> ';
	  $res135 = $this->oldconn->query($sql135);

	  $sql35= "truncate table profile2field";
	  echo '<br> '.$sql135 .' <br> ';
	  $res135 = $this->oldconn->query($sql135);
  }



function populateProfile2field()
{

  $sql35= "select profileid from profile2tab";
  echo '<br> '.$sql135 .' <br> ';
  $res135 = $this->oldconn->query($sql135);
  $count = $this->oldconn->num_rows($res135);
   echo 'the count is '.$count;
  for($i=0; $i < $count; $i++)
  {
     $prof_id = $this->oldconn->query_result($res135,$i,'profileid');
     insertProfile2field($prof_id);
  }
  insert_def_org_field();
    
  
}

*/
function insertComboValues($values, $tableName)
{
  $i=0;
	foreach ($values as $val => $cal)
	{
		if($val != '')
		{
			$this->oldconn->query("insert into ".$tableName. " values('','".$val."',".$i.",1)");
		}
		else
		{
			$this->oldconn->query("insert into ".$tableName. " values('','--None--',".$i.",1)");
		}
		$i++;
	}
}


function getTabid($module)
{
	$sql = "select tabid from tab where name='".$module."'";
        echo '<br> query is   '.$sql;
	$result = $this->oldconn->query($sql);
	$tabid=  $this->oldconn->query_result($result,0,"tabid");
        echo ' tabid is ' .$tabid;
	return $tabid;

}

function startMigration()
{
  $this->setupDBConnections();
  $this->preliminarySteps();
  $this->makechanges();	
  //$this->clearMigration();
  //$this->logMigration();
}
  
 
}


?>
