## Intro

We have the `verification-system` which have two DDD modules`(Verification & Notification)` built using `Laravel-Framework`
and also we have another domain `templates` which is responsible for providing `templates/render` endpoint built using `Laravel-Lumen microservices framework`

## Installation & Preparing the environment
Please follow the following steps one by one, in the same order.

- Go to `templates` folder, then run the following commands:
``` 
composer install --ignore-platform-reqs

```
Then
``` 
docker-compose up -d
```
Then
``` 
docker-compose exec -ti templates.thirdparty php artisan migrate:fresh
``` 

- After `template` finishing and become ready you can now go to `verification-system` folder and run the following commands:
``` 
composer install --ignore-platform-reqs

```
Then
``` 
docker-compose up -d
```
Then
```
docker-compose exec -ti verification.system php artisan migrate:fresh
```

Currently we should have both systems are running,

## How to test it
1- Open the `gotify` using `http://127.0.0.1:8000/` 
2- Open the `mailhog` using `http://localhost:8025/` to check your received mails
3- Use the following endpoint to create a new verification
```
POST http://localhost/verifications
````

It takes the following payload
```
{
    "subject": {
        "identity": "your-valid-mobile-number",
        "type": "mobile_confirmation"
    }
}
```

or

```
{
    "subject": {
        "identity": "your-valid-email-address",
        "type": "email_confirmation"
    }
}
```

4- By getting your success code which is `201` you will receive your verification code on the already specified channel depending on your payload
5- Now for confirmation, you should use the returned `uuid` as a verification identifier and the code received as a verification cod, and call the following endpoint
```
POST http://localhost/verifications/:uuid/confirm
```
 
 It takes the following payload
```
{
    "code": your-code
}
```

##IMP note
- Currently I could not receive the first message from Kafka(I think it's a partition issue, to not being so late, I decided to deliver it like that, and I can look into it myself for curiosity and for future need) so please ignore the first verification's request's notification
- Check that Kafka is running please from Docker, sometimes maybe it will require restart or something, so only double check that all services are running

##Other notes
- if all provided info are correct, you will receiver a `204` code as a verification confirmed successfully
- Remember that after 5 invalid code attempts your code will be expired
- Remember that naturally after 5 minutes your code will be expired too if you have not already confirmed it
