<?php

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

use ScssPhp\ScssPhp\Compiler;

use Padaliyajay\PHPAutoprefixer\Autoprefixer;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig 	= new Environment($loader);

// Indent Filter 
$filter = new TwigFilter('indent', function ($string, $number) {
    $spaces = str_repeat(' ', $number);
    return rtrim(preg_replace('#^(.+)$#m', sprintf('%1$s$1', $spaces), $string));
}, array('is_safe' => array('all')));

$twig->addFilter($filter);

// Compile SCSS
$compiler = new Compiler();
$compiler->setImportPaths('templates/_css');

$css = $compiler->compileString(file_get_contents('templates/_css/main.scss'))->getCss();

// Prefix CSS
$prefixed_css = new Autoprefixer($css);
$prefixed_css = $prefixed_css->compile();

// Pipe CSS into file. Craft CMS will require it in your templates.
file_put_contents('templates/_css/main.css', $prefixed_css);

// Get all templates
$files = scandir('templates');

foreach ($files as $file) {
	// // Make sure we don't include directories
	if(! is_dir('templates/'. $file)){

		$directory_name	= explode('.', $file)[0];
		$directory_path = 'dist/' . $directory_name;
		if(!is_dir($directory_path)) {
			mkdir($directory_path);
		}

		$asset_path = $directory_path . '/assets';
		if(!is_dir($asset_path)){
			mkdir($asset_path);
		} else {
			// Clean out old assets.
			$assets_to_remove = scandir($asset_path);
			foreach($assets_to_remove as $asset) {
				if(!is_dir($asset_path . '/' . $asset)){
					unlink($asset_path . '/' . $asset);
				}
			}
		}

		// Move in assets.
		// TODO: Minify assets
		$assets = scandir('assets');
		foreach ($assets as $asset) {
			if(!is_dir('assets/' . $asset)) {
				file_put_contents($asset_path . '/' . $asset, file_get_contents('assets/' . $asset));
			}
		}

		// Create ad HTML.
		file_put_contents($directory_path . '/index.html', $twig->render($file));
	}
}