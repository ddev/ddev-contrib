# Install [REDAXO CMS](https://redaxo.org) with DDEV

## What is REDAXO?

REDAXO is an open source content managment system devleoped by a german web agency called [Yakamara](https://www.yakamara.de/). 

REDAXO is for people who love the flexibility about a content managment system, you have easy control about your code and also about the content that you want to create. 

## Install REDAXO

Lets start by cloning the REDAXO repository in our project folder first.

`git clone https://github.com/redaxo/redaxo.git .`

![](https://raw.githubusercontent.com/crydotsnake/ddev-contrib/master/recipes/install-redaxo-cms-with-ddev/img/clone-repository.gif)

After cloning the repository its important to install the git submodules too:

```bash
git submodule init
git submodule update
```

---

In the next step we run the `ddev config` command.

![](https://github.com/crydotsnake/ddev-contrib/blob/master/recipes/install-redaxo-cms-with-ddev/img/project-name.png?raw=true)

You will be asked for your project name. But you can skip that and 
just press enter, the same thing for the next step.

Now we have to choose a project type, in our case its the `php` type.

![](https://github.com/crydotsnake/ddev-contrib/blob/master/recipes/install-redaxo-cms-with-ddev/img/project-type.png?raw=true)

# Start the project

Now we are done and we can run the `ddev start` command to start the project!.

![](https://github.com/crydotsnake/ddev-contrib/blob/master/recipes/install-redaxo-cms-with-ddev/img/project-start.gif?raw=true)

And now you can enter the project with the urls you see in the terminal!.

![](https://github.com/crydotsnake/ddev-contrib/blob/master/recipes/install-redaxo-cms-with-ddev/img/project.png?raw=true)

## Project informations

To see your database informations, and other helpful things run the `ddev describe` command.

![](https://github.com/crydotsnake/ddev-contrib/blob/master/recipes/install-redaxo-cms-with-ddev/img/project-informations.png?raw=true)

We are done!

# Credits

Tool for the animated GIF: [Licecap](https://www.cockos.com/licecap/)