# Installing Magento 2 from Archive

Install a vanilla Magento 2 application using a full copy of Magento 2

## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 1 hr  
**Task Type:** Base

## Pre requirements
- Web Server (PHP 7 + Apache)
- MySQL Server

## Task Objectives
- Fully running Magento 2 Store

## Instructions
1. Download and Extract Magento 2 Code Archive
1. Setup Web Server with Domain and Document Root Location
1. Set Install Permissions (Example Below)
1. As the same user as the web server
    1. Create `~/.composer/auth.json` (Example Below)
    1. Run `composer install` at Magento root
    1. Run Install via CLI (Example Below)
    1. Clear Cache `php bin/magento cache:flush`
    1. Run Upgrade `php bin/magento setup:upgrade`
    1. Clear Cache `php bin/magento cache:flush` (Yes Again)
1. Set Runtime Permissions (Example Below)

Once these steps are followed, you should be able to visit the browser at the domain that was setup. 
The first page load may take a few moments as the static assets and code generation takes place.
    
## Examples and Snippets

### Set Install Permissions
 ```bash
    chmod -R a+wX app/etc
    chmod -R a+wX var
    chmod -R a+wX pub
 ```
     
### Set Runtime Permissions
 
Assuming `application` is the web server user.
 
 ```bash
    chmod -R g-wX app/etc
    chmod -R o-wX app/etc
    chown -R application:application app/etc
    chown -R application:application var
    chown -R application:application pub
 ```

### Create Composer Auth File
 
This is generally only needed for Magento Commerce *(formerly Enterprise Edition)*
 
 ```json
 {
    "http-basic": {
       "repo.magento.com": {
          "username": "${MAGENTO_REPO_PUBLIC}",
          "password": "${MAGENTO_REPO_PRIVATE}"
       }
    }
 }
 ```
 
### Run Install via CLI
 ```bash
 php bin/magento setup:install --base-url="${MAGENTO_BASE_URL}" \
     --db-host="${MAGENTO_DB_HOST}" --db-name="${MAGENTO_DB_NAME}" --db-user="${MAGENTO_DB_USER}" \
     --db-password="${MAGENTO_DB_PASSWORD}" --admin-firstname="${MAGENTO_ADMIN_FIRSTNAME}" \
     --admin-lastname="${MAGENTO_ADMIN_LASTNAME}" --admin-email="${MAGENTO_ADMIN_EMAIL}" \
     --admin-user="${MAGENTO_ADMIN_USER}" --admin-password="${MAGENTO_ADMIN_PASSWORD}" --language=en_US \
     --currency=USD --timezone=America/Los_Angeles --use-rewrites=1 --key="${MAGENTO_CRYPT_KEY}" \
     --backend-frontname="${MAGENTO_BACKEND_PATH}"
 ```
 
## Research and Useful Links Section
[Install Magento](http://devdocs.magento.com/guides/v2.2/install-gde/install/cli/install-cli-install.html)
