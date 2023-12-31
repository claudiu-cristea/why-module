## Deprecation notice

This repository is deprecated in favour of https://github.com/claudiu-cristea/drupal-dependencies

[![ci](https://github.com/claudiu-cristea/why-module/actions/workflows/ci.yml/badge.svg)](https://github.com/claudiu-cristea/why-module/actions/workflows/ci.yml)

## Description

Provides a Drush command that shows a tree of modules having a given module as
dependency. Useful to understand the dependency chain in a Drupal installation.

## Usage

### Include only installed modules

```bashcated in fav
./vendor/bin/drush pm:why-module node
```

will output

```
node
┣━forum
┣━history
┃ ┗━forum
┗━taxonomy
  ┗━forum
```

### Include uninstalled modules

```bash
./vendor/bin/drush pm:why-module node --no-only-installed
```

will output

```
node
┣━book
┣━forum
┣━history
┃ ┗━forum
┣━statistics
┣━taxonomy
┃ ┗━forum
┗━tracker
```
