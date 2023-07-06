[![ci](https://github.com/claudiu-cristea/why-module/actions/workflows/ci.yml/badge.svg)](https://github.com/claudiu-cristea/why-module/actions/workflows/ci.yml)

## Description

Provides a Drush command that shows a tree of modules having a given module as
dependency. Useful to understand the dependency chain in a Drupal installation.

## Usage

```bash
./vendor/bin/drush pm:why-module node
```
will output
```
node
 ┣━book
 ┣━forum
 ┣━history
 ┃  ┗━forum
 ┣━statistics
 ┣━taxonomy
 ┃  ┗━forum
 ┗━tracker
```
