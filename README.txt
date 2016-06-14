Steps:

1. Put this folder into document root: eg. /var/www/html/
2. Run the users_table.sql into your DB as whole
3. Set the dbconn.php with your DB details
4. Set the SMTP details into forgotpassword.php
5. By default users table will have dhiraj.patra@gmail.com and 12345 as password
6. Run this as http://localhost/internetstores/
7. You can login and see the DB changes to logged in = 1 from 0
8. You can forgot password by entering the correct email [should be in users table] and click of forgotpassword button
9. Forgotpassword will dynamically create password and save with md5() of it in DB and send that in email without md5()

