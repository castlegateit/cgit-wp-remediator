<?php

namespace Cgit\Remediator;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Importer
{
    /**
     * List of image media types
     *
     * @var array
     */
    private $types = [
        'image/gif',
        'image/jpeg',
        'image/png',
    ];

    /**
     * Global wpdb object
     */
    private static $database;

    /**
     * WordPress uploads directory
     *
     * @var string
     */
    private static $uploads;

    /**
     * List of images to import and their properties
     *
     * @var array
     */
    private $images = [];

    /**
     * List of imported images
     *
     * @var array
     */
    private $imported = [];

    /**
     * Constructor
     *
     * Assigns properties for the database object and the uploads directory and
     * performs the import.
     *
     * @return void
     */
    public function __construct()
    {
        global $wpdb;

        // Assign the global database object and the path of the WordPress
        // uploads directory to properties.
        self::$database = $wpdb;
        self::$uploads = wp_upload_dir()['basedir'];
    }

    /**
     * Import new images
     *
     * Scans the uploads directory for new images and imports each one into the
     * media gallery.
     *
     * @return void
     */
    private function import()
    {
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $this->scan();

        foreach ($this->images as $image) {
            // Import the image as an attachment
            $id = wp_insert_attachment($image, $image['_path']);
            $meta = wp_generate_attachment_metadata($id, $image['_path']);
            wp_update_attachment_metadata($id, $meta);

            // Add the image to the array of imported images
            $this->imported[] = $image;
        }
    }

    /**
     * Find images in the uploads directory
     *
     * Scans the uploads directory recursively for images, i.e. files with a
     * recognised image media type, and updates the list of images. Removes and
     * deletes previously resized images and ignores images that are already in
     * the database.
     *
     * @return void
     */
    private function scan()
    {
        $directory = new RecursiveDirectoryIterator(self::$uploads);
        $iterator = new RecursiveIteratorIterator($directory); // seriously?

        foreach ($iterator as $item) {
            $path = $item->getPathname();
            $type = mime_content_type($path);

            // Ignore file paths that do not match one of the accepted image
            // media types.
            if (!in_array($type, $this->types)) {
                continue;
            }

            $this->images[] = [
                '_path' => $path,
                '_parent_path' => self::parentPath($path),
                'post_mime_type' => $type,
                'post_title' => basename($path),
                'post_content' => '',
                'post_status' => 'inherit',
            ];
        }

        // Remove and delete cropped and resized variants of other images in the
        // list and ignore any images that already exist in the database.
        $this->sanitize();
    }

    /**
     * Remove redundant images
     *
     * Remove and delete cropped and resized variants of other images in the
     * main list of images and ignore any images that already exist in the
     * database. Note that WordPress will create new resized versions
     * automatically.
     *
     * @return void
     */
    private function sanitize()
    {
        foreach ($this->images as $key => $image) {
            $path = $image['_path'];
            $parent = $image['_parent_path'];

            // This image, or its original version, already exists in the
            // database, so remove it from the list of images to import.
            if (self::inDatabase($parent)) {
                unset($this->images[$key]);
                continue;
            }

            // This image is a resized version of another image in the list of
            // images to import. Remove it from the list and delete the file.
            if ($path != $parent && self::searchArray($parent, $this->images)) {
                unset($this->images[$key]);
                unlink($path);
            }
        }
    }

    /**
     * Is this image already in the database?
     *
     * The image paths stored in the database are relative to the uploads
     * directory.
     *
     * @return boolean
     */
    private static function inDatabase($path)
    {
        $path = str_replace(self::$uploads . '/', '', $path);
        $table = self::$database->postmeta;

        $count = self::$database->get_var("
            SELECT COUNT(*)
            FROM $table
            WHERE meta_value = '$path'
        ");

        return $count ? true : false;
    }

    /**
     * Return "parent" image path
     *
     * If an image has been cropped or resized by WordPress, there will be
     * smaller duplicate images with the same file name plus a size-based
     * suffix. This returns the path of the original "parent" image.
     *
     * @return string
     */
    private static function parentPath($path)
    {
        return preg_replace('/[_\-]\d+x\d+(\.[^.]+)$/i', '$1', $path);
    }

    /**
     * Search multidimensional array for value
     *
     * return boolean
     */
    private static function searchArray($needle, $haystack)
    {
        if (in_array($needle, $haystack)) {
            return true;
        }

        foreach ($haystack as $element) {
            if (is_array($element) && self::searchArray($needle, $element)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return list of imported images
     *
     * @return array
     */
    public function getImported()
    {
        return $this->imported;
    }
}
