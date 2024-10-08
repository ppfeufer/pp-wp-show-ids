<?php

namespace Ppfeufer\Plugin\PpWpShowIDs;

/**
 * Autoloader for the plugin classes and interfaces to be loaded dynamically.
 * This will allow us to include only the files we need when we need them.
 *
 * @param string $className The name of the class to load
 * @return void
 * @package Ppfeufer\Plugin\PpWpShowIDs
 */
spl_autoload_register(callback: static function (string $className): void {
    $myNamespace = 'Ppfeufer\\Plugin\\PpWpShowIDs';

    // If the specified $className does not include our namespace, duck out.
    if (!str_starts_with(haystack: $className, needle: $myNamespace)) {
        return;
    }

    $namespace = '';
    $fileName = null;

    // Split the class name into an array to read the namespace and class.
    $fileParts = explode(separator: '\\', string: $className);

    // Do a reverse loop through $fileParts to build the path to the file.
    for ($i = count($fileParts) - 1; $i > 0; $i--) {
        // Read the current component of the file part.
        $current = str_ireplace(search: '_', replace: '-', subject: $fileParts[$i]);
        $namespace = '/' . $current . $namespace;

        // If we're at the first entry, then we're at the filename.
        if (count($fileParts) - 1 === $i) {
            $namespace = '';
            $fileName = $current . '.php';

            /**
             * If 'interface' is contained in the parts of the file name, then
             * define the $file_name differently so that it's properly loaded.
             * Otherwise, set the $file_name equal to that of the class
             * filename structure.
             */
            if (stripos(haystack: $fileParts[count($fileParts) - 1], needle: 'interface')) {
                // Grab the name of the interface from its qualified name.
                $interfaceNameParts = explode(
                    separator: '_',
                    string: $fileParts[count($fileParts) - 1]
                );
                $interfaceName = $interfaceNameParts[0];

                $fileName = $interfaceName . '.php';
            }
        }

        // Now build a path to the file using mapping to the file location.
        $filepath = trailingslashit(value: __DIR__ . $namespace) . $fileName;

        // If the file exists in the specified path, then include it.
        if ($fileName !== null && file_exists(filename: $filepath)) {
            include_once $filepath;
        }
    }
});
