# Subscribe to a SNS Topic with Email

You can subscribe to topics with a variety of things. THis task is for subscribing with an email address. 
So that when a message is published to a topic, an email is sent.
      
## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 5 mins  
**Task Type:** Modifier  
    
## Pre requirements
- AWS Account
- SNS Topic
 
## Task Objectives
- Create and confirm a SNS email subscription
 
## Instructions
- Open the Amazon SNS console at https://console.aws.amazon.com/sns/v2/home.
- Find and select the SNS Topic to which you want to subscribe.
- Choose Create subscription.
- For Protocol, choose Email
- For Endpoint, enter your email address.
- Choose Create Subscription.
- To confirm the subscription, Amazon SNS sends you an email named AWS Notification — Subscription Confirmation. 
Open the link in the email to confirm your subscription.

Until you verify the email subscription, the subscription will be pending and will not recieve any messages from this topic.

## Research and Useful Links Section
https://docs.aws.amazon.com/sns/latest/dg/SubscribeTopic.html
