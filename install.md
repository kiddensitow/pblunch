# Install Plugins

1. Custom Post Type UI (CPT)
2. WP User Avatar 

# Initial database
## restaurants
    --
    -- Table structure for table `restaurants`
    --

    CREATE TABLE `restaurants` (
        `id` int(11) NOT NULL,
        `name` varchar(250) NOT NULL,
        `phone` varchar(100) NOT NULL DEFAULT ' ',
        `address` varchar(250) NOT NULL DEFAULT ' ',
        `weekday` int(11) NOT NULL DEFAULT '8',
        `comment` varchar(500) NOT NULL DEFAULT ' '
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    --
    -- Indexes for dumped tables
    --

    --
    -- Indexes for table `restaurants`
    --
    ALTER TABLE `restaurants`
    ADD PRIMARY KEY (`id`);

    --
    -- AUTO_INCREMENT for dumped tables
    --

    --
    -- AUTO_INCREMENT for table `restaurants`
    --
    ALTER TABLE `restaurants`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
    COMMIT;


## menu

    CREATE TABLE `menus` (
        `id` int(11) NOT NULL,
        `rid` int(11) NOT NULL COMMENT 'restaurant id',
        `name` varchar(250) NOT NULL,
        `price` double NOT NULL,
        `image` varchar(250) NOT NULL COMMENT 'path of image',
        `comment` varchar(500) NOT NULL,
        `available` int(11) NOT NULL DEFAULT '1'
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    --
    -- Indexes for table `menus`
    --
    ALTER TABLE `menus`
    ADD PRIMARY KEY (`id`);

    --
    -- AUTO_INCREMENT for dumped tables
    --

    --
    -- AUTO_INCREMENT for table `menus`
    --
    ALTER TABLE `menus`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
    COMMIT;

## order 

    CREATE TABLE `orders` (
        `id` int(11) NOT NULL,
        `uid` int(11) NOT NULL,
        `items` varchar(1024) NOT NULL DEFAULT '{}' COMMENT 'Key: menu id, value price',
        `price` int(11) NOT NULL DEFAULT '0',
        `order_date` date NOT NULL,
        `due_date` datetime NOT NULL
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    --
    -- Indexes for dumped tables
    --

    --
    -- Indexes for table `orders`
    --
    ALTER TABLE `orders`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `uid` (`uid`,`due_date`);

    --
    -- AUTO_INCREMENT for table `orders`
    --
    ALTER TABLE `orders`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
    COMMIT;

## system setting

    CREATE TABLE `pb_setting` ( 
        `due_time` TIME NOT NULL DEFAULT '11:00' , 
        `overdraft` FLOAT NOT NULL DEFAULT '10.00' 
    ) ENGINE = MyISAM;

## Overtime plans
    --
    -- Table structure for table `ot_plans`
    --

    CREATE TABLE `ot_plans` (
        `id` int(11) NOT NULL,
        `ot_date` date NOT NULL,
        `rid` int(11) NOT NULL COMMENT 'restaurant id',
        `price` double NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    --
    -- Indexes for dumped tables
    --

    --
    -- Indexes for table `ot_plans`
    --
    ALTER TABLE `ot_plans`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `ot_date` (`ot_date`);

    --
    -- AUTO_INCREMENT for dumped tables
    --

    --
    -- AUTO_INCREMENT for table `ot_plans`
    --
    ALTER TABLE `ot_plans`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
    COMMIT;

## Overtime orders
    --
    -- Table structure for table `ot_orders`
    --

    CREATE TABLE `ot_orders` (
        `id` int(11) NOT NULL,
        `uid` int(11) NOT NULL,
        `ot_date` int(11) NOT NULL,
        `items` int(11) NOT NULL,
        `price` int(11) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    --
    -- Indexes for dumped tables
    --

    --
    -- Indexes for table `ot_orders`
    --
    ALTER TABLE `ot_orders`
    ADD PRIMARY KEY (`id`);

    --
    -- AUTO_INCREMENT for dumped tables
    --

    --
    -- AUTO_INCREMENT for table `ot_orders`
    --
    ALTER TABLE `ot_orders`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
    COMMIT;

## Settings 
    --
    -- Table structure for table `pb_setting`
    --

    CREATE TABLE `pb_setting` (
        `id` int(11) NOT NULL,
        `due_time` time NOT NULL DEFAULT '11:00:00',
        `overdraft` float NOT NULL DEFAULT '10'
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

    --
    -- Dumping data for table `pb_setting`
    --

    INSERT INTO `pb_setting` (`id`, `due_time`, `overdraft`) VALUES
    (1, '23:00:00', 10);

    --
    -- Indexes for dumped tables
    --

    --
    -- Indexes for table `pb_setting`
    --
    ALTER TABLE `pb_setting`
    ADD PRIMARY KEY (`id`);

    --
    -- AUTO_INCREMENT for dumped tables
    --

    --
    -- AUTO_INCREMENT for table `pb_setting`
    --
    ALTER TABLE `pb_setting`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
    COMMIT;


# Download PBLunch theme

Downalod the pbLunch and save to _wordpress/web-content/themes_ directory.

# Active themes
Active the PBLunch theme

1. Hover on Appearance tab, and click on Themes tab.
2. You should see the newly created _pbLunch_.
3. Click on Activate button of _pbLunch_ to activate the theme.

# Restaurant

## Restaurant information

In the dashboard, hover on Pages and click on **Add New** tab. 
You will get the Add New Page screen. 
Create a new Page named _Restaurant_, Choose _Restaurant Editor_ as template, 
then click on **Publish** button.

## Restaurant List

In the dashboard, hover on Pages and click on **Add New** tab. 
You will get the Add New Page screen. 
Create a new Page named _Restaurant_, Choose _Restaurant Editor_ as template, 
then click on **Publish** button.

# Menu

## Menu Editor
In the dashboard, hover on Pages and click on **Add New** tab. 
You will get the Add New Page screen. 
Create a new Page named _Menu Item_, Choose _Menu Item Editor_ as template, 
then click on **Publish** button.

## Menu List

In the dashboard, hover on Pages and click on **Add New** tab. 
You will get the Add New Page screen. 
Create a new Page named _Menu Items_, Choose _List Menu_ as template, 
then click on **Publish** button.

# Oder
## Order Editor
Just in index.php

## Order List

In the dashboard, hover on Pages and click on **Add New** tab. 
You will get the Add New Page screen. 
Create a new Page named _Orders_, Choose _List Order_ as template, 
then click on **Publish** button.

# over time

## overtime plans
In the dashboard, hover on Pages and click on **Add New** tab. 
You will get the Add New Page screen. 
Create a new Page named _Overtime Plans_, Choose _List Overtime_ as template, 
then click on **Publish** button.

Name:, restaurant name, string, union
Price: item price, double.
Picture: url of picture, string, 
Introduction: string.
Delete: the item is delete, bool, true is deleted
