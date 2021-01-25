# Coding Test Advertising Settings

Demonstrable Gutenberg block with automated tests.

Completed as part of a job application.

## User story

    As an editor or journalist
    I can access advertising features in a single location
    So I can easily find all advertising-related settings

## Acceptance Criteria


 - [ ] In the Gutenberg/Block Editor, a new custom panel is visible in the sidebar for the standard “post” type
 - [ ] The custom panel title is “Advertising Settings”
 - [ ] Three fields appear in the custom panel, their requirements are outlined below
 - [ ] These fields should be disabled while post is being saved/updated/published

### Bonus points

 - [ ] Test WordPress environment to be hosted and publicly accessible (with username/password)
 - [ ] Local environment is ideally run via Docker
 - [ ] Frontend code is ideally Typescript
 - [ ] Code has unit and/or functional tests

### Fields

 - [ ] Advertisements
   - [ ] Label: `Advertisements`
   - [ ] Type: Toggle control
   - [ ] Default: On

 - [ ] Commercial content type
   - [ ] Label: “Commercial content type”
   - [ ] Type: Radio control
   - [ ] Options: 
     - [ ] `None`     
     - [ ] `Sponsored content`
     - [ ] `Partnered content`
     - [ ] `Brought to you by`
   - [ ] Default: `None`

 - [ ] Advertiser name
   - [ ] Label: `Advertiser name`
   - [ ] Type: Text control
   - [ ] Visibility: The advertiser name field is hidden while `None` is the selected commercial content type

## Building

### To use plugin from source code

 - `composer i --ignore-platform-reqs` (workaround for Automattic's phpcs-neutron locked to < 8 still)
 - `npm i`
 - `npm build`

### To build an installable zip

 - `composer i --ignore-platform-reqs` (workaround for Automattic's phpcs-neutron locked to < 8 still)
 - `npm i`
 - `npm build`
 - `composer build PLUGIN-NAME-VERSION` where output will be `PLUGIN-NAME-VERSION.zip`

## Testing

I'll use a unified `composer test` to test the PHP and JS together.

### Unit testing (frontend)

 - `npm i`
 - `npm test`

### Manual testing

 - `composer i`
 - `npm i`
 - `wp-env start` launches docker container on `:8888` with plugin installed and activated. Username/password are `admin/password`.

## Development notes

OK, so having some experience in WP admin development, but not for Gutenberg/block editor yet, I'll be looking at some established themes/plugins for how they're approaching. I'll create this as a plugin, so will have Composer and implement tools I usually use for code quality/styling. The custom panel should be done in ReactJS, so will want to get up to speed on how those are arranged, with I assume some custom components, which I can unit test. Bonus points should all be achievable. I have my own [local WP environment project](https://lokl.dev), but in order to use the same for local dev and a public test site, I'll lean towards a `docker-composer.yml` and spin up on a Sydney instance in my Vultr account.

Assuming to add permanance to the controls via Post Meta. Assuming to use some kind of frontend build tool like WebPack and Jest for testing.

Borrowing `composer.json` from [leonstafford/wp2static](https://github.com/leonstafford), as it's my most up to date one. Decided a namespace for the plugin. More notes in commits.

For quick spin up of WP env for developing a single plugin, [WP's official guide](https://developer.wordpress.org/block-editor/tutorials/devenv/) looks straightfroward enough, using a Node project to manage a Docker site. There is also [an official Jest-powered test package](https://www.npmjs.com/package/@wordpress/scripts#test-unit-js) that should be sufficient for a simple admin block like this. I'd use its `build` commands within my own `composer build` that creates the installer zip. Will add instructions for a user to build this for running directly from the repo, something like `composer i && npm i && npm build`.

Will start with `wp-env` and make sure I can see something spin up, then add the plugin skeleton with activation/deactivation, maybe a CLI class for bonus points, like printing out IDs for all of the posts with this meta assigned/unassigned.

Installs NVM, as I wiped this machine and haven't needed any Node stuff this week. Installs Node LTS. Installs `wp-env` globally. `wp-env start` unsuprisingly comlains that there's no config and can't detect the project type (doesn't infer from `composer.json`'s `"type": "wordpress-plugin"`!). I'll copy in one of my plugin's entrypoint and `Controller` or `WordPressAdmin` classes. There's some good [plugin guidelines](https://github.com/szepeviktor/small-project) that I'm using amongst other checks in a new auditing tool for my own projects, I'll try to review that as part of this and serve a polished new plugin.

Testing `wp-env start` again throws a nice error now:

> Uncaught AdvertisingSettings\AdvertisingSettingsException: Looks like you're trying to activate AdvertisingSettings from source code, without compiling it first.

So some of my boiler plate code is working. I'll need to `composer i` before that...

Added in a PHPCS ruleset that I'd been meaning to try out, [szepeviktor/phpcs-psr-12-neutron-hybrid-ruleset](https://github.com/szepeviktor/phpcs-psr-12-neutron-hybrid-ruleset). Unfortunately, the upstream ruleset by Automattic that it uses is semver locked, so requires a `composer i --ignore-platform-reqs` to overcome. Also, my project I copied boilerplate from is quite different coding standard, so will take some time to do a bit of search-replacing of vars and some other adjustments.

OK, back from dinner and will get onto appeasing the coding standards I chose. Have added exepcted failing tests to GitHub Actions workflow, too. At this point, I'm wiring up the basics, with tests in place, doing an occasional manual test to see if things are showing up in `wp-env`'s WP.

Converting some of my boilerplate is going to be some slow grunt work, but good practice for me anyway, as am planning to move my projects to that. I also took the opportunity to apply best practices from @szepeviktor's [small project](https://github.com/szepeviktor/small-project), which is much more elegant, but different enough to what I'm used to with my plugins that it's taking me more time than expect to get the PHP part of things done.

Made minor adjustment to GitHub workflow config file to get them triggering. Encountered this recently, when copying an old config, that I needed to simplify the trigger action. Can look into it another time, it's running tests now.

Code analysis tools now green. Whether the code is still functional is yet unknown. I'll try to add in Pest for unit/integration tests, another tool on my todo list for my own projects this week.

Running `wp-env start` surfaced an error from bulk-rewriting. Fixing that shows the plugin installed and activated (but not doing anything yet). Deactivating and activating via WP admin surfaces an issue with dbDelta/SQL query, with a bunch of `\n`'s in it. So, I know where that's come from - adjusting older manually formed queries with `$wpdb->prepare()`'s and not handling the newlines correctly. Fixing now.

PHPUnit and ode quality tools running without issue now, but no assertions with one placeholder unit test. Going to add Pest to the mix and get first red-green test. Previous issue with MySQL query fixed by adjusting string formatting.


