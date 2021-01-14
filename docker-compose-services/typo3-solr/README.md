# TYPO3-specific Apache Solr Integration for DDEV-Local

Although ddev has [documented generic Solr support](https://ddev.readthedocs.io/en/stable/users/extend/additional-services/#apache-solr) it is as simple as possible, and supports only a single core named "dev".

The TYPO3 extension assumes a different approach and a slightly different Solr image.

These instructions were tested with TYPO3 LTS v9.5.

Resources:

* ApacheSolrForTypo3 EXT:Solr [docs (master)](https://docs.typo3.org/p/apache-solr-for-typo3/solr/master/en-us/)
* [typo3solr/ext-solr](https://hub.docker.com/r/typo3solr/ext-solr/) Solr image on hub.docker.com.
* [typo3solr Slack Channel](https://typo3.slack.com/messages/ext-solr/) (request your invite for TYPO3 Slack at <https://my.typo3.org/about-mytypo3org/slack>)
* [Original Stack Overflow Tutorial](https://stackoverflow.com/questions/51479399/how-to-set-up-solr-server-for-typo3-using-ddev) that this is based on.

1. Add the solr extension to your project: `ddev composer require apache-solr-for-typo3/solr`
2. Deactivate and then re-activate the "Apache Solr for TYPO3" module to make sure that its database tables get installed: `ddev typo3 extension:deactivate solr && ddev typo3 extension:activate solr`
3. Copy [docker-compose.solr.yaml](docker-compose.solr.yaml) to your project's .ddev folder.
4. If you want your solr data to be persistent across `ddev restart`, then uncomment the `- solrdata:/var/solr` line in docker-compose.solr.yaml. The comments there explain what you have to do if you want to start over. It's recommended to wait to uncomment that until you have everything else working.
5. Copy the default Solr configuration from Ext:Solr to ddev:
    * `mkdir -p .ddev/solr`
    * `cp -r public/typo3conf/ext/solr/Resources/Private/Solr/* .ddev/solr`
    * You will have `configsets`, `cores`, `solr.xml` and `zoo.cfg` in .ddev/solr.
6. `ddev restart` will bring up the new solr container.
7. On the TYPO3 backend "Sites" module, choose your site
   * Make sure that on the "General" tab a full URL is specified for "Entry Point". Just using "/" here results in a failure of the extension.
   * On the "Solr" tab (far right) set "Host" to "solr" (NOT the default "localhost")
   * On the "Languages" tab configure a Corename at the bottom of the page ("English" selected on the right-hand select widget will result in "core_en" being selected.)
   * Save configuration
8. On the "Template" module, edit your site/page and
   * Choose "Info/Modify" in the select widget at the top of the pane
   * Click "Edit the whole template record" at the bottom.
   * Click the "Includes" tab"
   * Add "Search - Base Configuration (solr)" and "Search - Default Stylesheets (solr)" to the "Selected Items" pane and save.
9. "Flush all caches" using the lightning bolt icon on top of the screen.
10. Click the "Apache Solr" "Info" module on the left and choose your site, you should see that it has connected the Apache Solr server.
11. Click "Index Queue" module under "Apache Solr" and

    * Click the checkbox to initialize all pages.
    * Queue all pages for indexing
    * "Index now" as needed to create the index.

At this point you should have the core_en core populated with an index.

Visit `http://<project>.ddev.site:8983/solr` to use the Solr admin dashboard. If you visit the "Core Admin" and choose "core_en" to see statistics about indexed documents, etc.

Now revisit the [EXT:Solr docs](https://docs.typo3.org/p/apache-solr-for-typo3/solr/master/en-us/Index.html)  for help with specific configuration, including templating for quality indexing, etc.

When everything is working, consider enabling the `- solrdata:/var/solr` line in .ddev/docker-compose.solr.yaml so you'll have persistent Solr data. If the docker volume accidentally already had data in it, then stop the project and delete the volume with `docker rm ddev-<project>_solrdata` before you restart.
