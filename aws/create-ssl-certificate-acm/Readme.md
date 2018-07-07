# Create SSL Certificate

ACM allows you to manage SSL certificates for your applications in AWS. This task is to create a SSL certificate.
      
## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 30 mins  
**Task Type:** Base  
    
## Pre requirements
* AWS Account
* Registrered domain name in Route53
 
## Task Objectives
* To create a SSL Certificate that you can use for your AWS resources
 
## Instructions
1. Access the ACM (AWS Certificate Manager) service in the AWS Console (Might need to "Get Started")
1. Choose Request Certificate, and choose public certifcate
1. Enter in the domain name, and for this task we will use the DNS style verification
1. Confirm and Request
1. Add the provided CNAME record in the DNS settings for your domain
1. Wait for verification

## Research and Useful Links Section
https://aws.amazon.com/blogs/aws/new-aws-certificate-manager-deploy-ssltls-based-apps-on-aws/
