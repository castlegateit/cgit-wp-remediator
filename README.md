# Castlegate IT WP Remediator #

Remediator lets you import images into the WordPress media gallery directly from the uploads directory. This might be useful for moving images from one site to another.

## Instructions ##

*   Put the images anywhere in the uploads directory.
*   In the WordPress admin panel, go to Tools | Remediator.
*   Click "Remediate".

## How it works ##

When run, the importer finds all the image files in the uploads directory, excludes those that are already in the database, and deletes any that are duplicated, resized versions of the new images to import. It then adds each one to the media gallery.
