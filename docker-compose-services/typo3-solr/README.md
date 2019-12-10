## TYPO3-specific Apache Solr Integration for DDEV-Local

Although ddev has [documented generic Solr support](https://ddev.readthedocs.io/en/stable/users/extend/additional-services/#apache-solr) it is as simple as possible, and supports only a single core named "dev". 

The TYPO3 extension assumes a different approach and a slightly different Solr image. 

These instructions were tested with TYPO3 LTS v9.5.

Resources:
* ApacheSolrForTypo3 EXT:Solr [docs (master)](https://docs.typo3.org/p/apache-solr-for-typo3/solr/master/en-us/)
* [typo3solr/ext-solr](https://hub.docker.com/r/typo3solr/ext-solr/) Solr image on hub.docker.com.
* [typo3solr Slack Channel](https://typo3.slack.com/messages/ext-solr/)  (request your invite for TYPO3 Slack at https://forger.typo3.org/slack)
* [Original Stack Overflow Tutorial](https://stackoverflow.com/questions/51479399/how-to-set-up-solr-server-for-typo3-using-ddev) that this is based on.

1. Add the solr extension to your project: `ddev composer require apache-solr-for-typo3/solr`
2. In the "Extensions" module deactivate and then re-activate the "Apache Solr for TYPO3" module to make sure that its database tables get installed.


