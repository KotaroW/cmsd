# CMSD Project

## About
I have been wanting to develop a simple CMS which leaves me much room to write my own codes. Sometimes what I need is something simple that allows me to effectively manage the common components in order to reduce repetitions as much as I could.
This project is still in a rudimentary state. I will add more functionalities and optimise the code. 

## Structure
The program stands on the below four pillars:
1. class-web-page-config.php
  A configuration getter. As the file naming might be confisuing or misleading, the file name will be changed in due course.
2. json-web-page-config.php
  This is actually the configuration file. The configuration is stored in the JSON format in the PHP style. It could have been a JSON application file. 
3. class-web-page.php
  A webpage builder. 
4. class-template.php
 A template. This can be anything.

## Known Issue (like)
### class-web-page.php
One note about the class is that the current class structure does not require the actual URI (requested by the browser) to be the same as the first argument (string $url - see below code).
```
(Web_Page class instantiation)
new Web_Page(string $url, string $template_name)
```
This was not intentional but a production of a coincidence. Maybe you can configure, the PHP file that includes class-web-page.php, to get the requested file and then instantiates the class with the file name as the first argument.
