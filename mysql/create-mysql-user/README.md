# Create MySQL User

MySQL User Creation and Granting and Revoking Permissions 
 
## Task Details  
**Platform/Framework:** MySQL 5.7  
**Development Hours:** 30 mins  
**Task Type:** Base
 
## Pre requirements
1. Running MySQL Server

## Task Objectives
- Create a limited user on MySQL server
 
## Instructions
1. Log into MySQL with User that has access and permissions to Create Users and Grant Privledges
1. Create User
1. Grant Privileges
1. Flush Privileges

### Create User
```mysql
CREATE USER 'username'@'host' IDENTIFIED BY 'password';
```

### Grant or Revoke Privileges

Example - The Following would create a read only user 

```mysql
REVOKE CREATE USER, ALTER, SUPER, REPLICATION CLIENT, DELETE, CREATE TEMPORARY TABLES, SHOW DATABASES, INSERT, UPDATE, EVENT, ALTER ROUTINE, GRANT OPTION, PROCESS, INDEX, SHUTDOWN, SHOW VIEW, REPLICATION SLAVE, REFERENCES, CREATE ROUTINE, DROP, FILE, SELECT, CREATE, EXECUTE, CREATE VIEW, RELOAD, TRIGGER, LOCK TABLES ON *.* FROM 'username'@'host';
GRANT INDEX, SHOW VIEW, REFERENCES, SELECT, EXECUTE ON *.* TO 'user'@'host';
```

### Flush Privileges
```mysql
FLUSH PRIVILEGES;
```

## Research and Useful Links Section
[MySQL Docs](https://dev.mysql.com/doc/refman/5.7/en/adding-users.html)

