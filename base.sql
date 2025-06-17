CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_registration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_lastupdate` timestamp NULL ,
  `user_level` int(11) NOT NULL DEFAULT '1',
  
  `date` time DEFAULT NULL,
PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES (1, 'zampier', 'pjcwb86@gmail.com', '1');

CREATE TABLE IF NOT EXISTS `profile_trainings` (
  `profile_training_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_training_age` varchar(255) CHARACTER SET latin1 NOT NULL,
  `profile_training_weight` tinyint(3) NOT NULL,
  `profile_training_height` decimal(10,2) DEFAULT NULL,
  `profile_training_biotype` tinyint(3) NOT NULL,
  `profile_training_trainingGoal` tinyint(3) NOT NULL,
  `profile_training_dailyActivity` tinyint(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` time DEFAULT NULL,

PRIMARY KEY (`profile_training_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `contact_ip` varchar(255) CHARACTER SET latin1 NOT NULL,

  `date` time DEFAULT NULL,

PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `visit` (
  `visit_id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_ip` int(11) NOT NULL,
  `date` time DEFAULT NULL,

PRIMARY KEY (`visit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;




CREATE TABLE IF NOT EXISTS `foods` (
  `food_id` int(11) NOT NULL AUTO_INCREMENT,
  `food_name` varchar(55) CHARACTER SET latin1 NOT NULL,
  `food_measure_unit` tinyint(4) NOT NULL,
  `food_amount` decimal(10,2) DEFAULT NULL,
  `food_calorie` decimal(10,2) DEFAULT NULL,
  `food_protein` decimal(10,2) DEFAULT NULL,
  `food_fat` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `diets` (
  `diet_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL,
  `diet_number_meal` tinyint(4) NULL,
  `food_id` int(11) NULL,
  `diet_food_amount` decimal(10,2) DEFAULT NULL,
  
  PRIMARY KEY (`diet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `phone_clients` (
  `phone_clients_id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_clients_name` varchar(55) CHARACTER SET latin1 NOT NULL,
  `phone_clients_number` varchar(20) CHARACTER SET latin1 NOT NUL,
  `phone_clients_state` tinyint(4) NULL,
  
  PRIMARY KEY (`phone_clients_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


/* ###############   FIM #############################*/
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(55) CHARACTER SET latin1 NOT NULL,
  `client_lastname` varchar(100) CHARACTER SET latin1 NOT NULL,
 /* `client_description` varchar(100) CHARACTER SET latin1 NOT NULL,*/
  `client_cnpj` varchar(30) CHARACTER SET latin1 NOT NULL,
  `client_ie` varchar(30) CHARACTER SET latin1 NOT NULL,
 /* `client_birth` date NOT NULL,*/
  `client_email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `client_tel` varchar(20) CHARACTER SET latin1 NOT NULL,
  `client_tel_2` varchar(20) CHARACTER SET latin1 NOT NULL,
  `client_street` varchar(100) CHARACTER SET latin1 NOT NULL,
  `client_number` tinyint(6) NOT NULL DEFAULT '0',
  `client_district` varchar(100) CHARACTER SET latin1 NOT NULL,
  `client_city` varchar(100) CHARACTER SET latin1 NOT NULL,
  `client_country` varchar(100) CHARACTER SET latin1 NOT NULL,
  `client_cep` varchar(20) CHARACTER SET latin1 NOT NULL,
  `date` time DEFAULT NULL,
  `user_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `immobiles` (
  `immobile_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` tinyint(4) NOT NULL,
  `immobile_service` tinyint(4) NOT NULL,
  `immobile_type` tinyint(4) NOT NULL,
  `immobile_city` tinyint(4) NOT NULL,
  `immobile_price` decimal(10,2) DEFAULT NULL,
  `immobile_room` tinyint(4) NOT NULL,
  `immobile_meter` decimal(10,2) DEFAULT NULL,
  `immobile_map` text NOT NULL,
  `immobile_note` varchar(240) CHARACTER SET latin1 NOT NULL,
  
  `date` time DEFAULT NULL,
  `user_id` varchar(75) CHARACTER SET latin1 DEFAULT NULL,
    
PRIMARY KEY (`immobile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `images_immobiles` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `immobile_id` tinyint(4) NOT NULL,
  `image_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  
  `date` time DEFAULT NULL,
  `user` tinyint(4) NOT NULL,
PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `spends` (
  `spend_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` tinyint(4) NOT NULL DEFAULT '0',
  `setor_id` tinyint(4) NOT NULL DEFAULT '0',
  `spend_number` int(11) NOT NULL,
  `spend_name` varchar(75) CHARACTER SET latin1 DEFAULT NULL,
  `spend_value` decimal(10,2) DEFAULT NULL,
  `date` date NOT NULL,
  `user_id` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',

  PRIMARY KEY (`spend_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
