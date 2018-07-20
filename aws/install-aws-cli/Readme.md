# Install AWS CLI Tools

Install the AWS CLI tools on a server or computer
      
## Task Details  
**Platform/Framework:** AWS  
**Development Hours:** 30 mins  
**Task Type:** Base  
    
## Pre requirements
* None
 
## Task Objectives
* AWS CLI tool installed
 
## Instructions
1. Locate the AWS CLI installation instructions [AWS CLI Docs](https://docs.aws.amazon.com/cli/latest/userguide/installing.html)
1. Find the version for your operating system, and follow the instructions. (See below for some tips)
1. Run `aws --version` and you should see some output like `aws-cli/1.11.100 Python/2.7.10 Darwin/17.6.0 botocore/1.5.63`

For Unix and Linux based systems, I have had the best luck with using the bundled installer:

To install the AWS CLI using the bundled installer

Download the AWS CLI Bundled Installer.

`$ curl "https://s3.amazonaws.com/aws-cli/awscli-bundle.zip" -o "awscli-bundle.zip"`
Unzip the package.

`$ unzip awscli-bundle.zip`

Run the install executable.

If you want to install for all users on your system install in a common place in the the executable path like:
`$ sudo ./awscli-bundle/install -i /usr/local/aws -b /usr/local/bin/aws`

If you want to only install for a local user, you can install in a user executable path like `~/bin` directory.

```
$ cd ~
$ curl "https://s3.amazonaws.com/aws-cli/awscli-bundle.zip" -o "awscli-bundle.zip"
$ unzip awscli-bundle.zip; ./awscli-bundle/install -b ~/bin/aws
```

Then you just need to make sure that `~/bin` is in the users executable path.

## Research and Useful Links Section
https://docs.aws.amazon.com/cli/latest/userguide/installing.html
