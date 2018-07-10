# Create a Subnet in a VPC

Creating a Subnet in a VPC takes a little planning, but is pretty simple once you have chosen your IP range for your network.
      
## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 30 mins  
**Task Type:** Modifier  
    
## Pre requirements
* AWS Account
* Console Access
* Existing VPC - [Create a VPC Task](/aws/create-a-vpc)
 
## Task Objectives
* A subnet in an existing VPC
 
## Instructions
1. Decide on a IP Address Schema for the subnet (e.g. If your VPC has a CIDR block of 172.16.0.0, then your subnet could be 172.16.1.0/24)
2. Go to the VPC Console, and select Subnets, then select Create subnet.
3. You can name your subnet, and choose your VPC, and a CIDR block.

Once you have done this, you have an empty Subnet. The next step is to create a routing for your resources, so your resources
like an EC2 instances can access to the internet, and traffic can get to your resources.

## Research and Useful Links Section
https://en.wikipedia.org/wiki/Private_network#Private_IPv4_addresses
https://docs.aws.amazon.com/AmazonVPC/latest/UserGuide/VPC_Scenario2.html
