## About

This is a P.O.C. (proof of concept) of an app importing emails into database.

The app is supposed to be connected to many providers (Gmail implemented, Hotmail is coming soon).
Once providers defined, jobs are launched to import all the emails & calendar events.

## Architecture

In App/Services/MailImporter, an interface is defined so many connectors can be plugged in.
A job gonna launch as many jobs as connectors implemented

## Demo
I use [lando](https://docs.lando.dev/) for my local developments and did put the .lando.yml
Configure your .env
Access to your homepage 
