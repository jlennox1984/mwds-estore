#############################################
# SQL update script for upgrading 
# from VirtueMart 1.0.x to VirtueMart 1.0.8
#
#############################################

UPDATE `jos_vm_csv` SET `field_name` = 'product_parent_sku',
`field_default_value` = '',
`field_required` = 'N' WHERE `field_name` = 'product_parent_id' LIMIT 1 ;

INSERT INTO `jos_vm_csv` ( `field_id` , `field_name` , `field_default_value` , `field_ordering` , `field_required` )
VALUES ( NULL , 'product_discount', NULL , '26', 'N' );