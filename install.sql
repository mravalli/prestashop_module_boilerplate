CREATE TABLE IF NOT EXISTS `PREFIX_mymodule_boiler` (
    `id_mymodule_boiler` int(10) unsigned NOT NULL auto_increment,
    `boiler` varchar(9) NOT NULL,
    PRIMARY KEY (`id_mymodule_boiler`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_mymodule_plate` (
    `id_mymodule_plate` int(10) unsigned NOT NULL auto_increment,
    `plate` int(10) unsigned NOT NULL,
    `message` text NULL,
    PRIMARY KEY (`id_mymodule_plate`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;