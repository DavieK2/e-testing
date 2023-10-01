FROM nginx:latest

RUN apt-get update && apt-get install -y \
    snapd

RUN snap install --classic certbot

RUN ln -s /snap/bin/certbot /usr/bin/certbot