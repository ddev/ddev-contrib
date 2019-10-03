# Install [Bludit CMS](https://www.bludit.com/) with DDEV

# What is Bludit?
Bludit is an open source content managment system. Its a flat file cms which means that you dont need a database for it, bludit saves everything in the folders. You can read more about that, in the Bludit Documentation for the [Folder Structure](https://docs.bludit.com/en/developers/folder-structure).

# Installation
First we need to clone the git repository for bludit:

`git clone https://github.com/bludit/bludit.git`

## Configure ddev

* Use `ddev config --project-type=php` to configure the project.

## Start ddev and install Bludit

* `ddev start`
* Visit the selected URL (like `https://bludit.ddev.site`) to install Bludit.
* To see complete ddev project information, use `ddev describe`.

