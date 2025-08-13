# Custom Help Drupal module

## Contents of this file

* Summary
* Requirements
* Installation
* Configuration
* Usage
* Contact

## Summary

Let's site administrators to manage site help contents that guides users on its
operations. Help contents can be displayed inline, in the help area at
configured paths, as well as standalone content on its canonical URL

## Requirements

The module depends on the Drupal core Help and Text modules.

## Installation

Install as usual, see https://www.drupal.org/node/1897420 for further
information.

## Configuration

Help texts are grouped into custom help types. Each type defines a collection of
help texts intended for a specific audience.

In order to create help contents, create your first custom help type at Help ->
Custom help -> Types (/admin/help/custom-help/types).

## Usage

Once the module is installed and some help type was created, add your first help
content at Help -> Custom help -> Texts -> Add custom help text
(/admin/help/custom-help/add).

Set some paths at the "Display on pages" field where the new content help should
be displayed inline at the help text area.

You might grant some roles the required view custom help texts permission at the
permissions administration page (/admin/people/permissions#module-custom_help).

## Contact

Current maintainers:
* Manuel Adan (manuel.adan) - https://www.drupal.org/user/516420
