# Overview
This repository is built using the Twig template engine.

Running `php index.php` will generate template folders in the `dist` directory, which can be zipped up for use in HTML5 banner ads.

# Installation Instructions

Download a version of this repository and unzip it, or run `git clone` in your working directory.

# Usage

Before following any of these instructions, make sure your terminal pointing to the correct directory.

On MacOS, you can do this by typing `cd` in your terminal, a space, and then dragging in the project folder. If done correctly, running `ls` in your terminal should list all the project files.

Below is brief overview of the development process.

1. Run `php composer.phar install` to install all the required PHP dependencies.
2. Edit your HTML from the files in the `templates` folder. Note: each `*.html.twig` file represents one ad.
3. Edit your CSS (in SASS syntax) in the `templates/_css` folder.
4. Run `php index.php` to generate your ad templates in the `dist` folder.
5. Zip up your folders and upload to your ad manager.

Step 1 only has to be done once, at the very beginning. For any additional edits, you only have to repeat steps 2-4.

# Editing

## CSS

This template uses SASS to reduce the amount of CSS lines required to implement complex styles and animations.

Overall, it's pretty similar to regular CSS but with the ability to add variables and nest elements. You can get a brief overview of the syntax [here](https://sass-lang.com/guide).

CSS is mainly defined in the `templates/_css/main.scss` file, while the animations live in `partials/animations.scss` to keep things tidy.

We've set up some variables at the top of the `templates/_css/main.scss` file to quickly change some ad styles:

	$backgroundColor: #5E366E; // Changes background color of the ad
	$textColor: white; // Changes the heading color of the ad

Simply change these variables and run `php index.php` to view the changes.

## HTML

The ad HTML is editable in any of the `*.html.twig` files living in the `templates` folder. 

If you need to create an ad with a new set ratio, simply duplicate the file and rename appropriately. You might have to change the variables in the template as well. You'll see something like this at the top of each of the `html.twig` files:

	{% set width  	= 300 %}
	{% set height 	= 250 %}
	{% set class 	= 'big-box' %}

The `width` and `height` variable define the size of your ad, and create important meta tags for HTML5 ads. The `class` variable will add a class to the container of the ad so you can define ad-specific CSS.

## Images

All the images live in the `assets` folder. When the templates are built, they are processed into the distribution folders so the correct relative urls are maintained.

Images can be edited, resized or replaced in the `assets` folder. A couple of things to keep in mind:

- If you decide to rename the files, make sure the file name is updated in both the CSS and `*.html.twig` template files.
- If you decide to replace or resize the files, it's highly recommended to use an image of the same ratio.

## Links

All clickthrough ads assume the same clickthrough link. The default link can be changed by editing this line of code in `_layouts/_ad.twig`. Locate the following snippet:

    <script type="text/javascript">
    	var clickTag = "https://www.ecuad.ca/";
	</script>

And change `https://www.ecuad.ca/` to your preferred destination URL.

## Text

All ad text is defined on a per-ad basis. You can edit the text of any of the `*.html.twig` files in the `templates` directory. 

Note that some ad headings use `<br>` tags to force line breaks.

## Tracking Pixels

You can add scripts in the footer (before the body tag) by placing this at the bottom of your `*.html.twig` template:

	{% block footer %}
		Your footer scripts go here.
	{% endblock %}

You can also add scripts in the `<head>` by placing this at the top of your `*.html.twig` template:

	{% block head %}
		Your head scripts go here.
	{% endblock %}

Your finished template should look something like

	{% extends '_layouts/_ad.twig' %}

	{% set width  	= 320 %}
	{% set height 	= 50 %}
	{% set class 	= 'mobile-leaderboard' %}

	{% block head %}
		Your head scripts go here.
	{% endblock %}

	{% block content %}
		Your content goes here.
	{% endblock %}

	{% block footer %}
		Your footer scripts go here.
	{% endblock %}

# Previewing Changes

With Google Chrome, you can drag any of the `index.html` files in the `dist/*` folders into your browser to preview your ad.

# Testing/Uploading Your Changes

To test your changes, upload a zipped version of your folders from the `dist` folder to any validation application. We've run all the current ads through [this HTML5 validator](https://h5validator.appspot.com/dcm/asset), but feel free to use any service of your choice.

Once the ad is confirmed valid, you can then upload the final version to your ad manager.