<?php

namespace Castlegate\Remediator;

class Admin
{
    /**
     * Initialization
     *
     * @return void
     */
    public static function init(): void
    {
        $admin = new static();

        add_action('admin_menu', [$admin, 'register']);
    }

    /**
     * Register menu
     *
     * @return void
     */
    public function register()
    {
        add_submenu_page(
            'tools.php',
            'Remediator',
            'Remediator',
            'import',
            'cgit-remediator',
            [$this, 'render']
        );
    }

    /**
     * Render menu page
     *
     * @return void
     */
    public function render()
    {
        ?>
        <div class="wrap">
            <h1>Remediator</h1>

            <?php

            // If the import request has been sent, run the importer instead of
            // showing the form.
            if (isset($_GET['import']) && $_GET['import']) {
                return $this->renderImport();
            }

            ?>

            <p>Use the button below to find all the images in the uploads directory that are not already in the media gallery and import them.</p>

            <form action="" method="get">
                <input type="hidden" name="page" value="cgit-remediator" />
                <input type="hidden" name="import" value="1" />
                <button class="button button-primary">Remediate</button>
            </form>
        </div>
        <?php
    }

    /**
     * Render results of import
     *
     * @return void
     */
    public function renderImport()
    {
        // Run the importer and get a list of images, if any, that have been
        // imported into the database.
        $importer = new Importer();
        $result = $importer->import();
        $images = $importer->getImported();

        if ($images) {
            ?>
            <p>The following images have been imported:</p>

            <ul>
                <?php

                foreach ($images as $image) {
                    ?>
                    <li><?= $image['post_title'] ?></li>
                    <?php
                }

                ?>
            </ul>

            <?php
        } else {
            ?>
            <p>Nothing to import.</p>
            <?php
        }

        ?>
        <form action="" method="get">
            <input type="hidden" name="page" value="cgit-remediator" />
            <button class="button button-primary">Back</button>
        </form>
        <?php
    }
}
