FROM openshift/php-56-centos7

# Add application sources
ADD . /opt/app-root/src/

DOCUMENTROOT=/opt/app-root/src/

# The run script uses standard ways to run the application
CMD bash