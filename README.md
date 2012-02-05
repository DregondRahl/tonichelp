# TonicHelp

Is a open source support ticket system (or helpdek) in PHP.

## Submodules

TonicHelp is coded in PHP and built on top of the awesome PHP framework [FuelPHP](http://fuelphp.com). We will use FuelPHP with submodules and we can easily update the core of the application. We also use the [Sentry](https://github.com/cartalyst/sentry) package for authentication.

To clone TonicHelp using submodules we need to do:

    git clone --recursive git://github.com/tonichelp/tonichelp.git


## Coding TonicHelp  with git-flow

We'll develop TonicHelp using the fantastic git-flow tool. First of all, a must read [Why aren't you using git-flow?](http://jeffkreeftmeijer.com/2010/why-arent-you-using-git-flow/). To install git-flow is easy as see the [oficial repository](https://raw.github.com/nvie/gitflow/).

Our default branches:

- Production releases: **master**
- "Next release" development: **develop**
- Features: **feature**
- Release: **release**
- Hotfixes: **hotfix**
- Support: **support**
