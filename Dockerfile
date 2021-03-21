FROM registry.redhat.io/rhscl/php-56-rhel7 

ENV DOCUMENTROOT=/opt/app-root/src/
# Add application sources
ADD . /opt/app-root/src/


# The run script uses standard ways to run the application
CMD bash
