FROM registry.redhat.io/rhel8/httpd-24

# Add application sources
ADD . /var/www/html/

# The run script uses standard ways to run the application
CMD run-httpd