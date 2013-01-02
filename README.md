Time Clock 
==========

A web based time clock for tracking employee hours.
    
Copyright (C) 2013  Kevin Luke kevzawinning@gmail.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

Installation :
1: 	In  TimeClock_Php/DB/db_inf.php adjust mysql server and login information.
	On first use the program will attempt to create the database and tables,
	depending on the permissions you have it might need help.
	Copy contents of TimeClock_Php to a php5/mysql webserver.

2:	Install TimeClock client on staff computers that will use the time clock,
	adjust the tc_settings.inf file to reflect the server location and login
	details.
	I have built the TimeClock client using monodevelop, it should work fine
	with visual studio as well althought I havent tested it there.

3: 	Setup users with user names and passwords from the web interface.

  

