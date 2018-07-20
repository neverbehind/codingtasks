# Creating a CloudWatch Events Rule That Triggers on a Schedule

Create a scheduled CloudWatch event that triggers every minute and sends an email with SNS.
      
## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 30 mins  
**Task Type:**   
    
## Pre requirements
- AWS Account
- SNS Topic, with email subscription
 
## Task Objectives
- Cloudwatch Event that triggers every 1 min
 
## Instructions
1. Open the CloudWatch console at https://console.aws.amazon.com/cloudwatch/.
1. In the navigation pane, choose Events, Create rule.
1. For Event source, choose Schedule.
1. Choose Fixed rate of and specify 1 min as the Fixed rate value, and Minutes in the dropdown.
1. For Targets, choose Add Target, then choose SNS Topic.
1. In the Topic field choose the SNS topic that you have created and subscribed to with email.
1. Choose Configure details. For Rule definition, type a name and description for the rule.
1. Choose Create rule.    

Note that CloudWatch needs permissions to perform the task of publishing to the SNS topic. AWS will handle creating the role
and assigning to the event. 

## Research and Useful Links Section
https://docs.aws.amazon.com/AmazonCloudWatch/latest/events/Create-CloudWatch-Events-Scheduled-Rule.html
