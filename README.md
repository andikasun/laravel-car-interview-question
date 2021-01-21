# Laravel Car Interview Question

## Assumptions and notes
1. Added seeding script for appointments for testing purpose
2. start_time and end_time in my opinion should be of type datetime instead of varchar, but there might be other design concern, so I keep the format as varchar(255)
3. I implemented eager loading on all API relationship for ease of use, this should be modified to cater to certain API use case for efficiency.
4. I assume each workshop is only capable of serving one appointment at any given time
5. Creation of appointment will be done by a software/web client that already have the information of car_id and workshop_id, hence it will assume it's valid.
6. I disabled CSRF token protection for api/* route
7. There is a bug in error message where I required the end_time > start_time, the error message can't express correctly, but instead will display "The end time must be greater than 19 characters." 
8. MySQL Database version is > 5.7 to have ST_Distance_Sphere function, if not, please run this command to create the function
```
CREATE FUNCTION `st_distance_sphere`(`pt1` POINT, `pt2` POINT) RETURNS 
    decimal(10,2)
    BEGIN
    return 6371000 * 2 * ASIN(SQRT(
       POWER(SIN((ST_Y(pt2) - ST_Y(pt1)) * pi()/180 / 2),
       2) + COS(ST_Y(pt1) * pi()/180 ) * COS(ST_Y(pt2) *
       pi()/180) * POWER(SIN((ST_X(pt2) - ST_X(pt1)) *
       pi()/180 / 2), 2) ));
    END
```

## Testing
Manual testing endpoint
1. Sample listing appointments by workshop_id
```http://localhost/laravel-carro/laravel-car-interview-question/public/index.php/api/v1/workshop?workshop_id=3```

2. Sample listing appointments by workshop_name
```http://localhost/laravel-carro/laravel-car-interview-question/public/index.php/api/v1/workshop?workshop_name=724%20Ang%20Mo%20Kio%20Workshop```

3. Scheduling appointment script using postman
```
car_id=1
workshop_id=2
start_time=2021-04-20 10:00:17
end_time=2021-04-20 12:00:17
```

4. Sample workshops recommendation
```http://localhost/laravel-carro/laravel-car-interview-question/public/index.php/api/v1/recommendworkshop?start_time=2021-01-20%2009:00:17&end_time=2021-01-20%2015:00:17&latitude=1.3000&longitude=102```

