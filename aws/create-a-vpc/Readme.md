# Create a VPC in AWS

Creating a VPC in AWS takes a little planning, but is pretty simple once you have chosen your IP range for your network.
      
## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 30 mins  
**Task Type:** Base  
    
## Pre requirements
* AWS Account
* Console Access
 
## Task Objectives
* A new VPC 
 
## Instructions
1. Decide on a IP Address Schema for the internal network (e.g. 10.0.0.0, or 172.16.0.0, or 192.168.0.0)
2. Go to the VPC Console, and Create VPC
3. Give your VPC a name, and a CIDR block (IP address schema)

Once you have done this, you have an empty VPC. The next step is to create a subnet, so you can assign resources like EC2
instances to the VPC.

## Research and Useful Links Section
https://en.wikipedia.org/wiki/Private_network#Private_IPv4_addresses
https://docs.aws.amazon.com/AmazonVPC/latest/UserGuide/VPC_Scenario1.html
