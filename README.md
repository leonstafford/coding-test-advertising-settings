# Coding Test Advertising Standards

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

## Development notes

OK, so having some experience in WP admin development, but not for Gutenberg/block editor yet, I'll be looking at some established themes/plugins for how they're approaching. I'll create this as a plugin, so will have Composer and implement tools I usually use for code quality/styling. The custom panel should be done in ReactJS, so will want to get up to speed on how those are arranged, with I assume some custom components, which I can unit test. Bonus points should all be achievable. I have my own [local WP environment project](https://lokl.dev), but in order to use the same for local dev and a public test site, I'll lean towards a `docker-composer.yml` and spin up on a Sydney instance in my Vultr account.

 
