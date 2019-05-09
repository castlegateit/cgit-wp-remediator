# Castlegate IT WP Remediator #

Remediator lets you import images into the WordPress media gallery directly from the uploads directory. This might be useful for moving images from one site to another.

## Instructions ##

*   Put the images anywhere in the uploads directory.
*   In the WordPress admin panel, go to Tools | Remediator.
*   Click "Remediate".

## How it works ##

When run, the importer finds all the image files in the uploads directory, excludes those that are already in the database, and deletes any that are duplicated, resized versions of the new images to import. It then adds each one to the media gallery.

## License

Copyright (c) 2019 Castlegate IT. All rights reserved.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.
