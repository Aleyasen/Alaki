Installation Instructions

1- Erase inside of CDA/algorithms/'data' folder 
2- Clean DB if it is needed
3- Zip file, version it and transfer to the server by ssh:D
4- Delete CDA-OLD by command: rm -rf CDA-OLD
5- Rename CDA to CDA-OLD: mv CDA CDA-OLD
6- Unzip new CDA versinoing folder: unzip CDA-*-*-*.zip
7- ./init.sh
8- If DB model has been changed, delete last DB version and create a new one:
	mysql -h localhost -u root -phello
	drop database CDA;
	create database CDA;
	exit
9- Go to protected/data/versions and run: mysql -h localhost -u root -p CDA < cda-*-*-*.sql
pass: hello

10- Check the transfer by :
	mysql -h localhost -u root -phello
	use CDA;
	show tables;
	select * from tbl_algorithm;
	
Bye & Enjoy the Application :P
	

