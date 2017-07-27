#
# Structure for the `xasset_app_product` table : 
#

CREATE TABLE `xasset_app_product` (
  `id`                      INT(11)        NOT NULL AUTO_INCREMENT,
  `application_id`          INT(11)        NOT NULL DEFAULT '0',
  `tax_class_id`            INT(11)        NOT NULL DEFAULT '0',
  `base_currency_id`        INT(11)        NOT NULL DEFAULT '0',
  `package_group_id`        INT(11)                 DEFAULT NULL,
  `sample_package_group_id` INT(11)                 DEFAULT NULL,
  `display_order`           TINYINT(4)     NOT NULL DEFAULT '0',
  `item_code`               VARCHAR(10)             DEFAULT NULL,
  `item_description`        VARCHAR(100)            DEFAULT NULL,
  `unit_price`              DECIMAL(16, 4) NOT NULL DEFAULT '0.0000',
  `old_unit_price`          DECIMAL(16, 4)          DEFAULT NULL,
  `min_unit_count`          INT(11)                 DEFAULT NULL,
  `max_access`              INT(11)                 DEFAULT NULL,
  `max_days`                INT(11)                 DEFAULT NULL,
  `expires`                 INT(11)                 DEFAULT NULL,
  `credits`                 INT(11)                 DEFAULT NULL,
  `add_to_group`            INT(11)                 DEFAULT NULL,
  `add_to_group2`           INT(11)                 DEFAULT NULL,
  `item_rich_description`   TEXT,
  `enabled`                 TINYINT(4)              DEFAULT '1',
  `group_expire_date`       INT(11)                 DEFAULT NULL,
  `group_expire_date2`      INT(11)                 DEFAULT NULL,
  `extra_instructions`      TEXT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `applicationid` (`application_id`),
  KEY `tax_class_id` (`tax_class_id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_application` table : 
#

CREATE TABLE `xasset_application` (
  `id`                    INT(11) NOT NULL AUTO_INCREMENT,
  `name`                  VARCHAR(50)      DEFAULT NULL,
  `description`           TINYTEXT,
  `platform`              TINYTEXT,
  `version`               VARCHAR(10)      DEFAULT NULL,
  `datePublished`         INT(11)          DEFAULT NULL,
  `requiresLicense`       TINYINT(4)       DEFAULT '1',
  `hasSamples`            TINYINT(4)       DEFAULT '0',
  `listInEval`            TINYINT(4)       DEFAULT NULL,
  `richDescription`       TEXT,
  `mainMenu`              TINYINT(4)       DEFAULT '0',
  `menuItem`              VARCHAR(20)      DEFAULT NULL,
  `productsVisible`       TINYINT(4)       DEFAULT NULL,
  `product_list_template` TEXT,
  `image`                 VARCHAR(250)     DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_application_groups` table : 
#

CREATE TABLE `xasset_application_groups` (
  `id`             INT(11) NOT NULL AUTO_INCREMENT,
  `application_id` INT(11) NOT NULL DEFAULT '0',
  `group_id`       INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_config` table : 
#

CREATE TABLE `xasset_config` (
  `id`     INT(11)     NOT NULL AUTO_INCREMENT,
  `dkey`   VARCHAR(20) NOT NULL DEFAULT '',
  `dvalue` VARCHAR(50)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_country` table : 
#

CREATE TABLE `xasset_country` (
  `id`   INT(11)     NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(75) NOT NULL DEFAULT '',
  `iso2` CHAR(2)     NOT NULL DEFAULT '',
  `iso3` CHAR(3)     NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `iso3` (`iso3`),
  UNIQUE KEY `iso2` (`iso2`),
  UNIQUE KEY `name` (`name`)
)
  ENGINE = MyISAM;


INSERT INTO `xasset_country` (`id`, `name`, `iso2`, `iso3`) VALUES
  (1, 'Afghanistan', 'AF', 'AFG'),
  (2, 'Albania', 'AL', 'ALB'),
  (3, 'Algeria', 'DZ', 'DZA'),
  (4, 'American Samoa', 'AS', 'ASM'),
  (5, 'Andorra', 'AD', 'AND'),
  (6, 'Angola', 'AO', 'AGO'),
  (7, 'Anguilla', 'AI', 'AIA'),
  (8, 'Antarctica', 'AQ', 'ATA'),
  (9, 'Antigua and Barbuda', 'AG', 'ATG'),
  (10, 'Argentina', 'AR', 'ARG'),
  (11, 'Armenia', 'AM', 'ARM'),
  (12, 'Aruba', 'AW', 'ABW'),
  (13, 'Australia', 'AU', 'AUS'),
  (14, 'Austria', 'AT', 'AUT'),
  (15, 'Azerbaijan', 'AZ', 'AZE'),
  (16, 'Bahamas', 'BS', 'BHS'),
  (17, 'Bahrain', 'BH', 'BHR'),
  (18, 'Bangladesh', 'BD', 'BGD'),
  (19, 'Barbados', 'BB', 'BRB'),
  (20, 'Belarus', 'BY', 'BLR'),
  (21, 'Belgium', 'BE', 'BEL'),
  (22, 'Belize', 'BZ', 'BLZ'),
  (23, 'Benin', 'BJ', 'BEN'),
  (24, 'Bermuda', 'BM', 'BMU'),
  (25, 'Bhutan', 'BT', 'BTN'),
  (26, 'Bolivia', 'BO', 'BOL'),
  (27, 'Bosnia and Herzegowina', 'BA', 'BIH'),
  (28, 'Botswana', 'BW', 'BWA'),
  (29, 'Bouvet Island', 'BV', 'BVT'),
  (30, 'Brazil', 'BR', 'BRA'),
  (31, 'British Indian Ocean Territory', 'IO', 'IOT'),
  (32, 'Brunei Darussalam', 'BN', 'BRN'),
  (33, 'Bulgaria', 'BG', 'BGR'),
  (34, 'Burkina Faso', 'BF', 'BFA'),
  (35, 'Burundi', 'BI', 'BDI'),
  (36, 'Cambodia', 'KH', 'KHM'),
  (37, 'Cameroon', 'CM', 'CMR'),
  (38, 'Canada', 'CA', 'CAN'),
  (39, 'Cape Verde', 'CV', 'CPV'),
  (40, 'Cayman Islands', 'KY', 'CYM'),
  (41, 'Central African Republic', 'CF', 'CAF'),
  (42, 'Chad', 'TD', 'TCD'),
  (43, 'Chile', 'CL', 'CHL'),
  (44, 'China', 'CN', 'CHN'),
  (45, 'Christmas Island', 'CX', 'CXR'),
  (46, 'Cocos (Keeling) Islands', 'CC', 'CCK'),
  (47, 'Colombia', 'CO', 'COL'),
  (48, 'Comoros', 'KM', 'COM'),
  (49, 'Congo', 'CG', 'COG'),
  (50, 'Cook Islands', 'CK', 'COK'),
  (51, 'Costa Rica', 'CR', 'CRI'),
  (52, 'Cote D\'Ivoire', 'CI', 'CIV'),
  (53, 'Croatia', 'HR', 'HRV'),
  (54, 'Cuba', 'CU', 'CUB'),
  (55, 'Cyprus', 'CY', 'CYP'),
  (56, 'Czech Republic', 'CZ', 'CZE'),
  (57, 'Denmark', 'DK', 'DNK'),
  (58, 'Djibouti', 'DJ', 'DJI'),
  (59, 'Dominica', 'DM', 'DMA'),
  (60, 'Dominican Republic', 'DO', 'DOM'),
  (61, 'East Timor', 'TP', 'TMP'),
  (62, 'Ecuador', 'EC', 'ECU'),
  (63, 'Egypt', 'EG', 'EGY'),
  (64, 'El Salvador', 'SV', 'SLV'),
  (65, 'Equatorial Guinea', 'GQ', 'GNQ'),
  (66, 'Eritrea', 'ER', 'ERI'),
  (67, 'Estonia', 'EE', 'EST'),
  (68, 'Ethiopia', 'ET', 'ETH'),
  (69, 'Falkland Islands (Malvinas)', 'FK', 'FLK'),
  (70, 'Faroe Islands', 'FO', 'FRO'),
  (71, 'Fiji', 'FJ', 'FJI'),
  (72, 'Finland', 'FI', 'FIN'),
  (73, 'France', 'FR', 'FRA'),
  (74, 'France, Metropolitan', 'FX', 'FXX'),
  (75, 'French Guiana', 'GF', 'GUF'),
  (76, 'French Polynesia', 'PF', 'PYF'),
  (77, 'French Southern Territories', 'TF', 'ATF'),
  (78, 'Gabon', 'GA', 'GAB'),
  (79, 'Gambia', 'GM', 'GMB'),
  (80, 'Georgia', 'GE', 'GEO'),
  (81, 'Germany', 'DE', 'DEU'),
  (82, 'Ghana', 'GH', 'GHA'),
  (83, 'Gibraltar', 'GI', 'GIB'),
  (84, 'Greece', 'GR', 'GRC'),
  (85, 'Greenland', 'GL', 'GRL'),
  (86, 'Grenada', 'GD', 'GRD'),
  (87, 'Guadeloupe', 'GP', 'GLP'),
  (88, 'Guam', 'GU', 'GUM'),
  (89, 'Guatemala', 'GT', 'GTM'),
  (90, 'Guinea', 'GN', 'GIN'),
  (91, 'Guinea-bissau', 'GW', 'GNB'),
  (92, 'Guyana', 'GY', 'GUY'),
  (93, 'Haiti', 'HT', 'HTI'),
  (94, 'Heard and Mc Donald Islands', 'HM', 'HMD'),
  (95, 'Honduras', 'HN', 'HND'),
  (96, 'Hong Kong', 'HK', 'HKG'),
  (97, 'Hungary', 'HU', 'HUN'),
  (98, 'Iceland', 'IS', 'ISL'),
  (99, 'India', 'IN', 'IND'),
  (100, 'Indonesia', 'ID', 'IDN'),
  (101, 'Iran (Islamic Republic of)', 'IR', 'IRN'),
  (102, 'Iraq', 'IQ', 'IRQ'),
  (103, 'Ireland', 'IE', 'IRL'),
  (104, 'Israel', 'IL', 'ISR'),
  (105, 'Italy', 'IT', 'ITA'),
  (106, 'Jamaica', 'JM', 'JAM'),
  (107, 'Japan', 'JP', 'JPN'),
  (108, 'Jordan', 'JO', 'JOR'),
  (109, 'Kazakhstan', 'KZ', 'KAZ'),
  (110, 'Kenya', 'KE', 'KEN'),
  (111, 'Kiribati', 'KI', 'KIR'),
  (112, 'Korea, Democratic People\'s Republic of', 'KP', 'PRK'),
  (113, 'Korea, Republic of', 'KR', 'KOR'),
  (114, 'Kuwait', 'KW', 'KWT'),
  (115, 'Kyrgyzstan', 'KG', 'KGZ'),
  (116, 'Lao People\'s Democratic Republic', 'LA', 'LAO'),
  (117, 'Latvia', 'LV', 'LVA'),
  (118, 'Lebanon', 'LB', 'LBN'),
  (119, 'Lesotho', 'LS', 'LSO'),
  (120, 'Liberia', 'LR', 'LBR'),
  (121, 'Libyan Arab Jamahiriya', 'LY', 'LBY'),
  (122, 'Liechtenstein', 'LI', 'LIE'),
  (123, 'Lithuania', 'LT', 'LTU'),
  (124, 'Luxembourg', 'LU', 'LUX'),
  (125, 'Macau', 'MO', 'MAC'),
  (126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD'),
  (127, 'Madagascar', 'MG', 'MDG'),
  (128, 'Malawi', 'MW', 'MWI'),
  (129, 'Malaysia', 'MY', 'MYS'),
  (130, 'Maldives', 'MV', 'MDV'),
  (131, 'Mali', 'ML', 'MLI'),
  (132, 'Malta', 'MT', 'MLT'),
  (133, 'Marshall Islands', 'MH', 'MHL'),
  (134, 'Martinique', 'MQ', 'MTQ'),
  (135, 'Mauritania', 'MR', 'MRT'),
  (136, 'Mauritius', 'MU', 'MUS'),
  (137, 'Mayotte', 'YT', 'MYT'),
  (138, 'Mexico', 'MX', 'MEX'),
  (139, 'Micronesia, Federated States of', 'FM', 'FSM'),
  (140, 'Moldova, Republic of', 'MD', 'MDA'),
  (141, 'Monaco', 'MC', 'MCO'),
  (142, 'Mongolia', 'MN', 'MNG'),
  (143, 'Montserrat', 'MS', 'MSR'),
  (144, 'Morocco', 'MA', 'MAR'),
  (145, 'Mozambique', 'MZ', 'MOZ'),
  (146, 'Myanmar', 'MM', 'MMR'),
  (147, 'Namibia', 'NA', 'NAM'),
  (148, 'Nauru', 'NR', 'NRU'),
  (149, 'Nepal', 'NP', 'NPL'),
  (150, 'Netherlands', 'NL', 'NLD'),
  (151, 'Netherlands Antilles', 'AN', 'ANT'),
  (152, 'New Caledonia', 'NC', 'NCL'),
  (153, 'New Zealand', 'NZ', 'NZL'),
  (154, 'Nicaragua', 'NI', 'NIC'),
  (155, 'Niger', 'NE', 'NER'),
  (156, 'Nigeria', 'NG', 'NGA'),
  (157, 'Niue', 'NU', 'NIU'),
  (158, 'Norfolk Island', 'NF', 'NFK'),
  (159, 'Northern Mariana Islands', 'MP', 'MNP'),
  (160, 'Norway', 'NO', 'NOR'),
  (161, 'Oman', 'OM', 'OMN'),
  (162, 'Pakistan', 'PK', 'PAK'),
  (163, 'Palau', 'PW', 'PLW'),
  (164, 'Panama', 'PA', 'PAN'),
  (165, 'Papua New Guinea', 'PG', 'PNG'),
  (166, 'Paraguay', 'PY', 'PRY'),
  (167, 'Peru', 'PE', 'PER'),
  (168, 'Philippines', 'PH', 'PHL'),
  (169, 'Pitcairn', 'PN', 'PCN'),
  (170, 'Poland', 'PL', 'POL'),
  (171, 'Portugal', 'PT', 'PRT'),
  (172, 'Puerto Rico', 'PR', 'PRI'),
  (173, 'Qatar', 'QA', 'QAT'),
  (174, 'Reunion', 'RE', 'REU'),
  (175, 'Romania', 'RO', 'ROM'),
  (176, 'Russian Federation', 'RU', 'RUS'),
  (177, 'Rwanda', 'RW', 'RWA'),
  (178, 'Saint Kitts and Nevis', 'KN', 'KNA'),
  (179, 'Saint Lucia', 'LC', 'LCA'),
  (180, 'Saint Vincent and the Grenadines', 'VC', 'VCT'),
  (181, 'Samoa', 'WS', 'WSM'),
  (182, 'San Marino', 'SM', 'SMR'),
  (183, 'Sao Tome and Principe', 'ST', 'STP'),
  (184, 'Saudi Arabia', 'SA', 'SAU'),
  (185, 'Senegal', 'SN', 'SEN'),
  (186, 'Seychelles', 'SC', 'SYC'),
  (187, 'Sierra Leone', 'SL', 'SLE'),
  (188, 'Singapore', 'SG', 'SGP'),
  (189, 'Slovakia (Slovak Republic)', 'SK', 'SVK'),
  (190, 'Slovenia', 'SI', 'SVN'),
  (191, 'Solomon Islands', 'SB', 'SLB'),
  (192, 'Somalia', 'SO', 'SOM'),
  (193, 'South Africa', 'ZA', 'ZAF'),
  (194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS'),
  (195, 'Spain', 'ES', 'ESP'),
  (196, 'Sri Lanka', 'LK', 'LKA'),
  (197, 'St. Helena', 'SH', 'SHN'),
  (198, 'St. Pierre and Miquelon', 'PM', 'SPM'),
  (199, 'Sudan', 'SD', 'SDN'),
  (200, 'Suriname', 'SR', 'SUR'),
  (201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM'),
  (202, 'Swaziland', 'SZ', 'SWZ'),
  (203, 'Sweden', 'SE', 'SWE'),
  (204, 'Switzerland', 'CH', 'CHE'),
  (205, 'Syrian Arab Republic', 'SY', 'SYR'),
  (206, 'Taiwan', 'TW', 'TWN'),
  (207, 'Tajikistan', 'TJ', 'TJK'),
  (208, 'Tanzania, United Republic of', 'TZ', 'TZA'),
  (209, 'Thailand', 'TH', 'THA'),
  (210, 'Togo', 'TG', 'TGO'),
  (211, 'Tokelau', 'TK', 'TKL'),
  (212, 'Tonga', 'TO', 'TON'),
  (213, 'Trinidad and Tobago', 'TT', 'TTO'),
  (214, 'Tunisia', 'TN', 'TUN'),
  (215, 'Turkey', 'TR', 'TUR'),
  (216, 'Turkmenistan', 'TM', 'TKM'),
  (217, 'Turks and Caicos Islands', 'TC', 'TCA'),
  (218, 'Tuvalu', 'TV', 'TUV'),
  (219, 'Uganda', 'UG', 'UGA'),
  (220, 'Ukraine', 'UA', 'UKR'),
  (221, 'United Arab Emirates', 'AE', 'ARE'),
  (222, 'United Kingdom', 'GB', 'GBR'),
  (223, 'United States', 'US', 'USA'),
  (224, 'United States Minor Outlying Islands', 'UM', 'UMI'),
  (225, 'Uruguay', 'UY', 'URY'),
  (226, 'Uzbekistan', 'UZ', 'UZB'),
  (227, 'Vanuatu', 'VU', 'VUT'),
  (228, 'Vatican City State (Holy See)', 'VA', 'VAT'),
  (229, 'Venezuela', 'VE', 'VEN'),
  (230, 'Viet Nam', 'VN', 'VNM'),
  (231, 'Virgin Islands (British)', 'VG', 'VGB'),
  (232, 'Virgin Islands (U.S.)', 'VI', 'VIR'),
  (233, 'Wallis and Futuna Islands', 'WF', 'WLF'),
  (234, 'Western Sahara', 'EH', 'ESH'),
  (235, 'Yemen', 'YE', 'YEM'),
  (236, 'Yugoslavia', 'YU', 'YUG'),
  (237, 'Zaire', 'ZR', 'ZAR'),
  (238, 'Zambia', 'ZM', 'ZMB'),
  (239, 'Zimbabwe', 'ZW', 'ZWE');

#
# Structure for the `xasset_currency` table : 
#

CREATE TABLE `xasset_currency` (
  `id`              INT(11)      NOT NULL AUTO_INCREMENT,
  `name`            VARCHAR(30)  NOT NULL DEFAULT '',
  `code`            CHAR(3)               DEFAULT NULL,
  `decimal_places`  TINYINT(4)            DEFAULT NULL,
  `symbol_left`     VARCHAR(10)           DEFAULT NULL,
  `symbol_right`    VARCHAR(10)           DEFAULT NULL,
  `decimal_point`   CHAR(1)               DEFAULT NULL,
  `thousands_point` CHAR(1)               DEFAULT NULL,
  `value`           FLOAT(13, 8) NOT NULL DEFAULT '0.00000000',
  `enabled`         TINYINT(4)            DEFAULT '1',
  `updated`         INT(11)               DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `code` (`code`)
)
  ENGINE = MyISAM;

INSERT INTO `xasset_currency` VALUES (1, 'US Dollar', 'USD', 2, '$', '', '.', ',', 1.66999996, 1, NULL);
INSERT INTO `xasset_currency` VALUES (2, 'Pound Sterling', 'GBP', 2, '£', '', '.', ',', 1.00000000, 1, NULL);
INSERT INTO `xasset_currency` VALUES (3, 'Brazil Reais', 'BRL', 2, 'R$', '', '.', ',', 4.0649474155, 1, NULL);

#
# Structure for the `xasset_gateway` table : 
#

CREATE TABLE `xasset_gateway` (
  `id`      TINYINT(4)  NOT NULL AUTO_INCREMENT,
  `code`    VARCHAR(10) NOT NULL DEFAULT '',
  `enabled` TINYINT(4)           DEFAULT '0',
  `gorder`  SMALLINT(6)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_gateway_detail` table : 
#

CREATE TABLE `xasset_gateway_detail` (
  `id`          INT(11) NOT NULL AUTO_INCREMENT,
  `gateway_id`  INT(11) NOT NULL DEFAULT '0',
  `gorder`      TINYINT(4)       DEFAULT NULL,
  `gkey`        VARCHAR(30)      DEFAULT NULL,
  `gvalue`      TEXT,
  `description` VARCHAR(200)     DEFAULT NULL,
  `list_ov`     VARCHAR(200)     DEFAULT NULL,
  `gtype`       CHAR(1)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `gateway_id` (`gateway_id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_gateway_log` table : 
#

CREATE TABLE `xasset_gateway_log` (
  `id`          INT(11) NOT NULL AUTO_INCREMENT,
  `gateway_id`  INT(11)          DEFAULT NULL,
  `order_id`    INT(11)          DEFAULT NULL,
  `date`        INT(11)          DEFAULT NULL,
  `order_stage` TINYINT(4)       DEFAULT NULL,
  `log_text`    MEDIUMTEXT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_license` table : 
#

CREATE TABLE `xasset_license` (
  `id`            INT(4)  NOT NULL AUTO_INCREMENT,
  `uid`           INT(11) NOT NULL DEFAULT '0',
  `applicationid` INT(11) NOT NULL DEFAULT '0',
  `authKey`       VARCHAR(50)      DEFAULT NULL,
  `authCode`      VARCHAR(100)     DEFAULT NULL,
  `expires`       INT(11)          DEFAULT NULL,
  `dateIssued`    INT(11)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `applicationid` (`applicationid`),
  KEY `uid` (`uid`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_links` table : 
#

CREATE TABLE `xasset_links` (
  `id`            INT(11) NOT NULL AUTO_INCREMENT,
  `applicationid` INT(11)          DEFAULT NULL,
  `name`          TINYTEXT,
  `link`          TINYTEXT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `applicationid` (`applicationid`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_order_detail` table : 
#

CREATE TABLE `xasset_order_detail` (
  `id`             INT(11) NOT NULL AUTO_INCREMENT,
  `order_index_id` INT(11) NOT NULL DEFAULT '0',
  `app_prod_id`    INT(11) NOT NULL DEFAULT '0',
  `qty`            INT(9)  NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `order_index_id` (`order_index_id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_order_index` table : 
#

CREATE TABLE `xasset_order_index` (
  `id`             INT(11)    NOT NULL AUTO_INCREMENT,
  `uid`            INT(11)    NOT NULL DEFAULT '0',
  `user_detail_id` INT(11)    NOT NULL DEFAULT '0',
  `currency_id`    INT(11)             DEFAULT NULL,
  `number`         INT(11)    NOT NULL DEFAULT '0',
  `date`           INT(11)             DEFAULT NULL,
  `status`         TINYINT(4) NOT NULL DEFAULT '0',
  `gateway`        INT(11)             DEFAULT NULL,
  `trans_id`       VARCHAR(200)        DEFAULT NULL,
  `value`          DOUBLE(15, 3)       DEFAULT NULL,
  `fee`            DOUBLE(15, 3)       DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `user_detail_id` (`user_detail_id`),
  KEY `uid` (`uid`),
  KEY `trans_id` (`trans_id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_package` table : 
#

CREATE TABLE `xasset_package` (
  `id`             INT(11) NOT NULL AUTO_INCREMENT,
  `packagegroupid` INT(11)          DEFAULT NULL,
  `filename`       VARCHAR(32)      DEFAULT NULL,
  `serverFilePath` VARCHAR(255)     DEFAULT NULL,
  `filesize`       INT(11)          DEFAULT NULL,
  `filetype`       VARCHAR(10)      DEFAULT NULL,
  `protected`      TINYINT(4)       DEFAULT '1',
  `isVideo`        TINYINT(4)       DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `packagegroupid` (`packagegroupid`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_packagegroup` table : 
#

CREATE TABLE `xasset_packagegroup` (
  `id`            INT(11) NOT NULL AUTO_INCREMENT,
  `applicationid` INT(11)          DEFAULT NULL,
  `name`          VARCHAR(50)      DEFAULT NULL,
  `grpDesc`       TINYTEXT,
  `version`       VARCHAR(10)      DEFAULT NULL,
  `datePublished` INT(11)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `applicationid` (`applicationid`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_region` table : 
#

CREATE TABLE `xasset_region` (
  `id`          INT(4)      NOT NULL AUTO_INCREMENT,
  `region`      VARCHAR(30) NOT NULL DEFAULT '',
  `description` VARCHAR(200)         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_tax_class` table : 
#

CREATE TABLE `xasset_tax_class` (
  `id`          INT(11)     NOT NULL AUTO_INCREMENT,
  `code`        VARCHAR(30) NOT NULL DEFAULT '',
  `description` VARCHAR(200)         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
  ENGINE = MyISAM;


INSERT INTO `xasset_tax_class` VALUES (1, 'none', 'none');

#
# Structure for the `xasset_tax_rates` table : 
#

CREATE TABLE `xasset_tax_rates` (
  `id`           INT(11)       NOT NULL AUTO_INCREMENT,
  `region_id`    INT(11)       NOT NULL DEFAULT '0',
  `tax_class_id` INT(11)       NOT NULL DEFAULT '0',
  `rate`         DECIMAL(7, 4) NOT NULL DEFAULT '0.0000',
  `priority`     TINYINT(4)             DEFAULT NULL,
  `description`  VARCHAR(200)           DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `zone_id` (`region_id`),
  KEY `tax_class_id` (`tax_class_id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_tax_zone` table : 
#

CREATE TABLE `xasset_tax_zone` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `region_id`  INT(30) NOT NULL DEFAULT '0',
  `country_id` INT(11) NOT NULL DEFAULT '0',
  `zone_id`    INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `country_id` (`country_id`),
  KEY `zone_id` (`zone_id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_user_details` table : 
#

CREATE TABLE `xasset_user_details` (
  `id`              INT(11)      NOT NULL AUTO_INCREMENT,
  `uid`             INT(11)      NOT NULL DEFAULT '0',
  `zone_id`         INT(11)               DEFAULT '0',
  `country_id`      INT(11)      NOT NULL DEFAULT '0',
  `first_name`      VARCHAR(50)  NOT NULL DEFAULT '',
  `last_name`       VARCHAR(50)  NOT NULL DEFAULT '',
  `street_address1` VARCHAR(200) NOT NULL DEFAULT '',
  `street_address2` VARCHAR(200)          DEFAULT NULL,
  `town`            VARCHAR(30)           DEFAULT NULL,
  `state`           VARCHAR(30)           DEFAULT NULL,
  `zip`             VARCHAR(20)           DEFAULT NULL,
  `tel_no`          VARCHAR(30)           DEFAULT NULL,
  `fax_no`          VARCHAR(30)           DEFAULT NULL,
  `company_name`    VARCHAR(100) NOT NULL DEFAULT '',
  `company_reg`     VARCHAR(50)           DEFAULT '',
  `vat_no`          VARCHAR(30)           DEFAULT '',
  `client_type`     TINYINT(4)            DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `uid` (`uid`),
  KEY `zone_id` (`zone_id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_user_products` table : 
#

CREATE TABLE `xasset_user_products` (
  `id`                     INT(11) NOT NULL AUTO_INCREMENT,
  `application_product_id` INT(11) NOT NULL DEFAULT '0',
  `uid`                    INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_userpackagestats` table : 
#

CREATE TABLE `xasset_userpackagestats` (
  `id`        INT(11) NOT NULL AUTO_INCREMENT,
  `packageid` INT(11) NOT NULL DEFAULT '0',
  `uid`       INT(11)          DEFAULT NULL,
  `ip`        VARCHAR(50)      DEFAULT NULL,
  `date`      INT(11)          DEFAULT NULL,
  `dns`       VARCHAR(250)     DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `packageid` (`packageid`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_zone` table : 
#

CREATE TABLE `xasset_zone` (
  `id`         INT(11)     NOT NULL AUTO_INCREMENT,
  `country_id` INT(11)     NOT NULL DEFAULT '0',
  `code`       VARCHAR(20) NOT NULL DEFAULT '',
  `name`       VARCHAR(30)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `country_id` (`country_id`)
)
  ENGINE = MyISAM;

#
# Structure for the `xasset_app_prod_memb` table : 
#

CREATE TABLE `xasset_app_prod_memb` (
  `id`              INT(11) NOT NULL AUTO_INCREMENT,
  `uid`             INT(11) NOT NULL DEFAULT '0',
  `order_detail_id` INT(11) NOT NULL DEFAULT '0',
  `group_id`        INT(11) NOT NULL DEFAULT '0',
  `expiry_date`     INT(11) NOT NULL DEFAULT '0',
  `sent_warning`    INT(11)          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `uid` (`uid`),
  KEY `order_detail_id` (`order_detail_id`),
  KEY `group_id` (`group_id`)
)
  ENGINE = MyISAM

