# [Bedrock](https://roots.io/bedrock/) + PHP Server + Livereload

```
mkdir projectname/ && cd projectname/
git clone git@github.com:OutThisLife/NWS-WP.git .
composer install
touch .env
```

Setup database credentials for `.env` and then run `yarn dev` to start a PHP server, livereload server, and to listen to all css/js changes.

# WPEngine work flow
First, you have to enable git on your WPE install as well as a staging environment.

Your remotes should ideally look something like this:

```
$ git remote -v
origin  git@bitbucket.org:outthislife/reponame.git (fetch)
origin  git@bitbucket.org:outthislife/reponame.git (push)
production      git@git.wpengine.com:production/reponame (fetch)
production      git@git.wpengine.com:production/reponame (push)
staging git@git.wpengine.com:staging/reponame (fetch)
staging git@git.wpengine.com:staging/reponame (push)

```

You need remotes setup as above in order to manage your VC. Staging will be where you push most of your changes up, but all of your git work will remain mostly on bitbucket. This is because WPE will automatically deploy any push to their git servers despite the branch name.

To bypass this, you use the origin remote to manage your branches and then just deploy to whichever WPE environment you need once ready.

With this setup, and on any branch, you can deploy via `yarn deploy` to staging and `yarn golive` to production.
