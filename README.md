# Migrate 728
Drupal 7 to 8 migration example

## Migration setup & execution

1. Create dummy content (users, articles, taxonomy, comments, ...) in D7 with `devel_generate`

2. Setup connection details in D8:

    ```
    // Source db.
    $databases['migrate']['default'] = array(
      ... connection details
    );
    
    // Destination db.
    $databases['default']['default'] = array(
      ... connection details
    );
    
    ```

3. Download & install module: `$ drush en migrate_728 -y`

4. Adjust `bundle` value in Tag migration YAML to an existing vid from your D7 generated vocabulary.

5. Run migration script:

    ```
    $ drush mi --group=migrate_728 --feedback=100
    ```
