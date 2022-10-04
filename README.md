# twilio-sms-schedule-php
This is a simple PHP solution to schedule sms messages from .csv for Twilio.

1. Create .csv following the ```sms_format.csv```
2. Import the .csv using the script ```import_sms_schedule.php```
3. Make sure you have the right autoload.php installed (from Twilio's PHP manual), link will be uploaded later.

```
composer require --with-all-dependencies \
    twilio/sdk \
    laminas/laminas-validator \
    vlucas/phpdotenv
```

4. Run in bash ---> will add more instructions later.
```php schedule_send_sms.php```
