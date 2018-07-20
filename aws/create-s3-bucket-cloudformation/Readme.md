# Create S3 Bucket with CloudFormation

Using Cloudformation, Create an S3 Bucket
      
## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 30 mins  
**Task Type:** Base  
    
## Pre requirements
* AWS Account
 
## Task Objectives
* Cloudformation Template
* A Simple S3 Bucket for storing personal files
 
## Instructions
1. Create a cloudformation template file by using the Cloudformation Docs (see template below)
1. Login to the AWS Console
1. Access Cloudformation Console
1. Create a new Stack in Cloudformation using the template you created
1. Give the Stack a name
1. Wait for the Cloudformation Stack to Complete

Super Simple Bucket Creation Template:
```AWSTemplateFormatVersion: 2010-09-09
Resources:
  CodingTaskBucket:
    Type: "AWS::S3::Bucket"
    Properties: 
      BucketName: my-unique-bucket-name
```

## Research and Useful Links Section
- [Create Skeleton CloudFormation Template](/aws/create-skeleton-cloud-formation-template)
- https://docs.aws.amazon.com/AWSCloudFormation/latest/UserGuide/aws-properties-s3-bucket.html
- https://docs.aws.amazon.com/AWSCloudFormation/latest/UserGuide/quickref-s3.html#scenario-s3-bucket-website
