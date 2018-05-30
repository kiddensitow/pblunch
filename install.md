# Install Plugins

1. Custom Post Type UI (CPT)
2. WP User Avatar 

# Initial database
## restaurants
    CREATE TABLE `restaurants` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(250) CHARACTER SET utf8 NOT NULL,
        `phone` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT ' ',
        `address` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT ' ',
        `weekday` int(11) NOT NULL DEFAULT '8',
        `comment` varchar(500) CHARACTER SET utf8 NOT NULL DEFAULT ' ',
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

## menu

    CREATE TABLE `menus` (
        `id` INT NOT NULL AUTO_INCREMENT , 
        `rid` INT NOT NULL COMMENT 'restaurant id' , 
        `name` VARCHAR(250) NOT NULL  DEFAULT ' ', 
        `price` DOUBLE NOT NULL  DEFAULT ' ', 
        `image` VARCHAR(250) NOT NULL  DEFAULT ' ' COMMENT 'path of image' , 
        `comment` VARCHAR(500) NOT NULL  DEFAULT ' ', 
        `available` BOOLEAN NOT NULL DEFAULT '1', 
        PRIMARY KEY (`id`)
    ) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;


# Download PBLunch theme

Downalod the pbLunch and save to _wordpress/web-content/themes_ directory.

# Active themes
Active the PBLunch theme

1. Hover on Appearance tab, and click on Themes tab.
2. You should see the newly created _pbLunch_.
3. Click on Activate button of _pbLunch_ to activate the theme.

# Restaurant

## Restaurant information

In the dashboard, hover on Pages and click on Add New tab. You will get the Add New Page screen. 
Create a new Page named Add new, Choose Furniture Creation (new.php) as template, then click on Publish button.


## Restaurant List

# Create Menu item
In the dashboard click on the CPT UI plugin button.
You will get the Add/Edit Post Types page.

1. Input **Post Type Slug** as _menu_.
2. Input **Plural Label** as _menus_.
3. Input **Singular Label** as _menu_.
4. Set **Has Archive** as _True_.
5. In **support** field, uncheck the _Editor_ and _Featured Image boxes_, check the _comments_.
6. Click on the **Add Post Type** button

# Creat Menu field
Add menu fields for menu.

1. Hover on **Custom Fields** and click on **Custom Fields** tab.
2. Click on **Add New** button.
3. Type in _menu fields_ in the **Add New Field Group** as the group name 
4. Click on **Add Field** button.
5. 

Name:, restaurant name, string, union
Price: item price, double.
Picture: url of picture, string, 
Introduction: string.
Delete: the item is delete, bool, true is deleted
