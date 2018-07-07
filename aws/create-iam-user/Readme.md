# Create IAM User

This task are the steps for creating a user on AWS

## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 15 mins  
**Task Type:** Base  
    
## Pre requirements
* An AWS account
* Permissions/Right to create IAM users
* Access to the AWS Console for the AWS account
 
## Task Objectives
* IAM User that has programmatic access to AWS
* IAM User that has console access to AWS
* IAM User should have full access to 1 service (Amazon S3)
 
## Instructions
1. Go to the IAM Users grid
1. Add user, by giving the user a name, and choosing the Access Type
1. Give this user all access to 1 service only, by attaching an existing policy
    1. Search the Policy Grid for "S3", chose `AmazonS3FullAccess`
1. Review and Create the user


## Research and Useful Links Section
* https://docs.aws.amazon.com/IAM/latest/UserGuide/access_controlling.html
