## Headless Chrome

This recipe allows you to configure a Headless chrome available, inside the web container, at `chrome:9222`.

The reason why I moved from selenium + Chrome to a headless Chrome is quickness. Headless Chrome is a bit quicker

I'm also providing the behat.ddev.yml file that I have configured to use as example. One thing to take in consideration
is that at this moment, I'm using drupal extension v4, and it has some differences between v3. You're own behat file
will work file too.