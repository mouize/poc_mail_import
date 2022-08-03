## About

This is a P.O.C. (proof of concept) of an app importing emails into database.

The app is supposed to be connected to many providers (Gmail implemented, Hotmail is coming soon).
Once providers defined, jobs are launched to import all the emails & calendar events.

## Architecture

In App/Services/MailImporter, an interface is defined so many connectors can be plugged in.
Import can be launched through a job.

LiveWire were used for the front end, you can find the Component in app/Http/Livewire

## Demo
I use [lando](https://docs.lando.dev/) for my local developments and did put the .lando.yml
Configure your .env
Access to your homepage 
