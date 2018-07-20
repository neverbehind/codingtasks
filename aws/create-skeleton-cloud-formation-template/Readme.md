# Create a Skeleton CloudFormation Template

Create a Skeleton CloudFormation Template
      
## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 5 mins  
**Task Type:** Base  
    
## Pre requirements
* Text editor
 
## Task Objectives
* Cloudformation Template
 
## Instructions
1. Choose between JSON and YAML for your template
1. Add in the Template format version
1. Add in a Resources object

Simple JSON Template:
```
{
    "AWSTemplateFormatVersion": "2010-09-09",
    "Resources": {
        "UniqueResourceId":{
            "Type": "String",
            "Properties":{
                "Name": "String"
            }
        }
    }
}
```

Simple YMAL Template:
```
AWSTemplateFormatVersion: 2010-09-09
Resources:
  UniqueResourceId:
    Type: String
    Properties:
      Name: String
```

## Research and Useful Links Section
https://docs.aws.amazon.com/AWSCloudFormation/latest/UserGuide/aws-properties-s3-bucket.html
