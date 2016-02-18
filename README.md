# Setup

1) Upload to the /wp-content/plugins/ directory

2) On the wordpress wp-config.php file, add the following line then save

    define('DISABLE_WP_CRON', true);
    
3) Create a cron job and point it to http://<yourwordpressbaseurl>/wp-cron.php and set it to run daily.
