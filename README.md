# Laravel Car Interview Question

The Car Solutions owns multiple workshops located at different locations with different working hours.

The company is currently building a platform for its admin staff in order to schedule booking appointments with different workshops.

Whenever a client called in to schedule for an appointment. The admin staff needs to be able to check the availability of the workshops, make recommendations and also create a new appointment.

The staff at the workshop will need to have access to the appointments on daily basis in order to prepare the required parts and tools.

## Assumptions and notes
1. Added seeding script for appointments for testing purpose
2. start_time and end_time in my opinion should be of type datetime instead of varchar, but there might be other design concern, so I keep the format as varchar(255)
3. I implemented eager loading on all API relationship for ease of use, this should be modified to cater to certain API use case for efficiency.
4. I assume each workshop is only capable of serving one appointment at any given time
5. Creation of appointment will be done by a software/web client that already have the information of car_id and workshop_id, hence it will assume it's valid.
6. I disabled CSRF token protection for api/* route
7. There is a bug in error message where I required the end_time > start_time, the error message can't express correctly, but instead will display "The end time must be greater than 19 characters." 

## Your task

Create endpoints that allows the admin staff to:

1. List down all the appointments for all workshops with ability to filter by each workshop

2. Schedule an appointment based on client's request

  - It should be able to create a new appointment based on given information

  - Other than that, it should also detect the availablility of the workshop and prevent appointments with overlapping time from being created.

3. Recommend the workshops based on the availability and the locations

  - The endpoint should be able to recommend workshops based on

    1. Availability (Show workshop that do not have appointment during the provided time)

    2. Location (Sort the workshop based on the distance)

## Notes

- Feel free include any assumptions or notes that you have

- Please include any instructions or guides that you have in order for us to test the work that you have done

- We like tests, include tests in your code will be advantageous

## Setup

- Please refer to https://laravel.com/docs/8.x/installation on how to set it up and running in you machine

- Once you have the environment up, run `scripts/setup` to setup the database and run the migration

- In order to seed the data, please run `php artisan db:seed`

## Send the answer back to us

1. Checkout and work on your branch

2. Commit as you progress

3. Once you are done, generate the patch file by using

```
git format-patch develop
```

4. Send the patch file back to us
