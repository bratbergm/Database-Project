CREATE TABLE `skiType` (
    `id`              int(11),
    `type`            varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `model`           varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `temperature`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `gripSystem`      varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `typeOfSkiing`    varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `descripton`      varchar(5000) COLLATE utf8mb4_danish_ci,
    `historical`      varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `msrp`            int(11)    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `skiType`
    (`id`,`type`,`model`,`temperature`,`gripSystem`,`typeOfSkiing`,`descripton`,`historical`,`msrp`)
    VALUES
    ('1','skate','Active','cold','IntelliGrip','free-style',' perfect for youth skiers interested in starting skating','no','999'),
    ('2','classic','Endurance','cold','IntelliGrip','double pole','Endurace Classic is the ideal choice for fast fitness workouts and long weekend tours.','no','1200'),
    ('3','skate','Intrasonic','warm','IntelliGrip','free-style','The Intrasonic Skate is a high-stability skate ski designed for beginners who are looking for an introduction to skate-style skiing.','no','2100'),
    ('4','skate','Redline','warm','wax','free-style','Dynamic and high responsive camber perfect for harder tracks and higher snow speed.','no','7200'),
    ('5','classic','Race Pro','cold','wax','classic','Race Pro Classic shares its construction with our race-proven world cup skis from 2017.','no','5300');


CREATE TABLE `ski` (
    `pnr`             int(11) NOT NULL,
    `size`            int(11),
    `weightClass`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `productionDate`  date,
    `ski_type_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;


INSERT INTO `ski`
    (`pnr`,`size`, `weightClass`,`productionDate`,`ski_type_id`)
    VALUES
    ('1',142,'20-30','2020-10-01',1),
    ('2',147,'30-40','2021-01-01',1),
    ('3',152,'40-50','2021-02-10',1),
    ('4',157,'50-60','2021-02-10',1),
    ('5',147,'30-40','2020-03-16',2),
    ('6',152,'40-50','2020-09-10',2),
    ('7',157,'50-60','2021-01-05',2),
    ('8',162,'60-70','2021-03-20',2),
    ('9',152,'40-50','2021-01-10',3),
    ('10',157,'50-60','2021-02-21',3),
    ('11',162,'60-70','2021-02-10',3),
    ('12',167,'70-80','2021-03-10',3),
    ('13',152,'50-60','2021-01-10',4),
    ('14',157,'50-60','2021-02-10',4),
    ('15',162,'50-60','2021-02-10',4),
    ('16',167,'50-60','2021-02-12',4),
    ('17',172,'60-70','2021-02-05',5),
    ('18',177,'70-80','2021-02-05',5),
    ('19',182,'80-90','2021-02-05',5),
    ('20',187,'90-100','2021-02-05',5);




CREATE TABLE `order` (
    `number`        int(11) NOT NULL,
    `totalPrice`    int(11),
    `offLargeOrder` varchar(50) COLLATE utf8mb4_danish_ci,
    `state`         varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `customerId`    int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `order`
    (`number`,`totalPrice`,`offLargeOrder`,`state`,`customerId`)
    VALUES
    ('1',0,NULL,'new','1'),
    ('2',0,NULL,'open','2'),
    ('3',0,NULL,'new','2'),
    ('4',0,NULL,'open','2');


CREATE TABLE `orderItems` (
    `order_number` int(11) NOT NULL,
    `ski_pnr`      int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;


INSERT INTO `orderItems`
    (`order_number`,`ski_pnr`)
    VALUES
    ('1','1'),
    ('1','5'),
    ('1','17'),
    ('2','2'),
    ('2','10'),
    ('3','2'),
    ('3','11'),
    ('4','16'),
    ('4','20');



CREATE TABLE `customer` (
    `id`                INT(11) NOT NULL,
    `contract_start`    date,
    `contract_end`      date
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `customer`
    (`id`,`contract_start`,`contract_end`)
    VALUES
    ('1','2010-01-01','2030-01-01'),
    ('2','2016-01-01','2025-01-01'),
    ('3','2010-01-01','2025-01-01'),
    ('4','2015-01-01','2025-01-01'),
    ('5','2020-01-01','2025-01-01'),
    ('6','2018-01-01','2023-01-01'),
    ('7','2021-01-01','2026-01-01'),
    ('8','2019-01-01','2024-01-01');


CREATE TABLE `franchise` (
    `customer_id`       INT(11) NOT NULL,
    `name`              VARCHAR(50),
    `address`           VARCHAR(50),
    `price`             VARCHAR(50)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `franchise`
    (`customer_id`,`name`,`address`,`price`)
    VALUES
    ('1','XXL','Trondheimsveien 1','50% of msrp'), 
    ('2','Sport 1','Gata nr 43','60% of msrp');


CREATE TABLE `store` (
    `customer_id`       INT(11) NOT NULL,
    `name`              VARCHAR(50),
    `address`           VARCHAR(50),
    `price`             VARCHAR(50)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `store`
    (`customer_id`,`name`,`address`,`price`)
    VALUES
    ('3','Sportsbutikken','Parkveien 42','70% of msrp'),
    ('4','Ski Spesialisten','Gatevegen 35','65% of msrp');


CREATE TABLE `athlete` (
    `customer_id`       INT(11) NOT NULL,
    `firstName`         VARCHAR(50),
    `lastName`          VARCHAR(50),
    `dob`               date,
    `club`              VARCHAR(50),
    `annual_quant`      INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `athlete`
    (`customer_id`,`firstName`,`lastName`,`dob`,`club`,`annual_quant`)
    VALUES
    ('5','Jhon','Jhonsen','1990-05-05','Trondheim Skiklubb',10),
    ('6','Adam','Adamson','1995-01-01','Oslo Skiklubb',14),
    ('7','Brian','Brianson','1994-01-01','Tromsø Skiklubb',8),
    ('8','Fiona','Olsen','1996-01-01','Bergen Skiklubb', 20);


CREATE TABLE `productionPlan` (
    `period`    VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `productionPlan`
    (`period`)
    VALUES
    ('2021-01'),
    ('2021-02'),
    ('2021-03'),
    ('2021-04');

CREATE TABLE `productionPlanSkis` (
    `plan_period`        varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `ski_pnr`       INT(11),
    `quantity`      INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `productionPlanSkis`
    (`plan_period`,`ski_pnr`,`quantity`)
    VALUES
    ('2021-01',1,700),
    ('2021-01',2,500),
    ('2021-02',3,900),
    ('2021-03',4,400),
    ('2021-03',5,600),
    ('2021-04',6,900),
    ('2021-04',7,700);


CREATE TABLE `auth_token` (
    `token`     char(64) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `auth_token` 
    (`token`) 
    VALUES
    ('efa1f375d76194fa51a3556a97e641e61685f914d446979da50a551a4333ffd7'),
    ('d5367aea1c17343b6c380f774b81a8d7d5e33c43dc445fdc8a6f884723694f3d'),
    ('fbecd91f02f99f3d896f387283921118375de5624d0a4b5eb614d248479dfef4'),
    ('b6c45863875e34487ca3c155ed145efe12a74581e27befec5aa661b8ee8ca6dd');

/**
CREATE USER 'public'@'localhost' IDENTIFIED BY PASSWORD 'public';
GRANT SELECT ON `dbproject`.`skitype` TO 'public'@'localhost';
**/


ALTER TABLE `ski` 
    ADD PRIMARY KEY(`pnr`),
    ADD KEY `ski_skitype_fk` (`ski_type_id`);

ALTER TABLE `skiType` 
    ADD PRIMARY KEY(`id`);

ALTER TABLE `productionPlan`
    ADD PRIMARY KEY(`period`);

ALTER TABLE `productionPlanSkis`
    ADD PRIMARY KEY(`plan_period`,`ski_pnr`),
    ADD KEY `productionPlanSkis_productionPlan_fk` (`plan_period`),
    ADD KEY `productionPlanSkis_ski_fk` (`ski_pnr`);

ALTER TABLE `customer`
    ADD PRIMARY KEY(`id`);

ALTER TABLE `franchise`
    ADD PRIMARY KEY(`customer_id`),
    ADD KEY `franchise_customer_fk` (`customer_id`);

ALTER TABLE `store`
    ADD PRIMARY KEY(`customer_id`),
    ADD KEY `store_customer_fk` (`customer_id`);

ALTER TABLE `athlete`
    ADD PRIMARY KEY(`customer_id`),
    ADD KEY `athlete_customer_fk` (`customer_id`);

ALTER TABLE `orderItems`
    ADD PRIMARY KEY(`order_number`, `ski_pnr`),
    ADD KEY `orderItems_order_fk` (`order_number`), 
    ADD KEY `orderItems_ski_fk` (`ski_pnr`);

ALTER TABLE `order`
    ADD PRIMARY KEY(`number`),
    ADD KEY `order_customer_fk` (`customerId`);

ALTER TABLE `order`
    MODIFY `number` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ski`
    ADD CONSTRAINT `ski_skitype_fk` FOREIGN KEY(`ski_type_id`) REFERENCES `skiType`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 
ALTER TABLE `franchise`
    ADD CONSTRAINT `franchise_customer_fk` FOREIGN KEY(`customer_id`) REFERENCES `customer`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `store`
    ADD CONSTRAINT `store_customer_fk` FOREIGN KEY(`customer_id`) REFERENCES `customer`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `athlete`
    ADD CONSTRAINT `athlete_customer_fk` FOREIGN KEY(`customer_id`) REFERENCES `customer`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `orderItems`
    ADD CONSTRAINT `orderItems_order_fk` FOREIGN KEY(`order_number`) REFERENCES `order`(`number`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `orderItems`
    ADD CONSTRAINT `orderItems_ski_fk` FOREIGN KEY(`ski_pnr`) REFERENCES `ski`(`pnr`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `order`
    ADD CONSTRAINT `order_customer_fk` FOREIGN KEY(`customerId`) REFERENCES `customer`(`id` ) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `productionPlanSkis`
    ADD CONSTRAINT `productionPlanSkis_productionPlan_fk` FOREIGN KEY(`plan_period`) REFERENCES `productionPlan`(`period`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `productionPlanSkis`
    ADD CONSTRAINT `productionPlanSkis_ski_fk` FOREIGN KEY(`ski_pnr`) REFERENCES `ski`(`pnr`) ON DELETE CASCADE ON UPDATE CASCADE;


