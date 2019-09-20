# Install RedaxoCMS with DDEV

First you have to install DDEV on your system, here you find the [installation instructions](https://ddev.readthedocs.io/en/stable/#installation).

To check if ddev is installed on your system, just type `ddev --version` in the terminal, or cmd if you are a windows user.

Next create a folder (in your home folder for example) for all your ddev projects.

## Install Redaxo

Clone the Redaxo Repository in your folder:

`git clone http://github.com/redaxo/redaxo`

then type `ddev config` in the terminal.
Follow the instructions on it. 

In the last step just type `ddev start` and everything should work fine!. 

You can use the `ddev describe` command to see all your informations about the ddev project, (database credentials for example). 