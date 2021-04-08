CREATE TABLE `skiType` (
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
    (`type`,`model`,`temperature`,`gripSystem`,`typeOfSkiing`,`descripton`,`historical`,`msrp`)
    VALUES
    ('skate','Active','cold','IntelliGrip','free-style',' perfect for youth skiers interested in starting skating','no','999'),
    ('classic','Endurance','cold','IntelliGrip','double pole','Endurace Classic is the ideal choice for fast fitness workouts and long weekend tours.','no','1200'),
    ('skate','Intrasonic','warm','IntelliGrip','free-style','The Intrasonic Skate is a high-stability skate ski designed for beginners who are looking for an introduction to skate-style skiing.','no','2100'),
    ('skate','Redline','warm','wax','free-style','Dynamic and high responsive camber perfect for harder tracks and higher snow speed.','no','7200'),
    ('classic','Race Pro','cold','wax','classic','Race Pro Classic shares its construction with our race-proven world cup skis from 2017.','no','5300');


CREATE TABLE `ski` (
    `pnr`             int(11) NOT NULL,
    `size`            int(11),
    `weightClass`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `productionDate`  date,
    `type`            varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `model`           varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `temperature`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `gripSystem`      varchar(50) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;


INSERT INTO `ski`
    (`pnr`,`type`,`model`, `temperature`, `size`, `weightClass`, `gripSystem`,`productionDate`)
    VALUES
    ('1','skate','Active','cold',142,'20-30','IntelliGrip','2020-10-01'),
    ('2','skate','Active','cold',147,'30-40','IntelliGrip','2021-01-01'),
    ('3','skate','Active','cold',152,'40-50','IntelliGrip','2021-02-10'),
    ('4','skate','Active','cold',157,'50-60','IntelliGrip','2021-02-10'),
    ('5','classic','Endurance','cold',147,'30-40','IntelliGrip','2020-03-16'),
    ('6','classic','Endurance','cold',152,'40-50','IntelliGrip','2020-09-10'),
    ('7','classic','Endurance','cold',157,'50-60','IntelliGrip','2021-01-05'),
    ('8','classic','Endurance','cold',162,'60-70','IntelliGrip','2021-03-20'),
    ('9','skate','Intrasonic','warm',152,'40-50','IntelliGrip','2021-01-10'),
    ('10','skate','Intrasonic','warm',157,'50-60','IntelliGrip','2021-02-21'),
    ('11','skate','Intrasonic','warm',162,'60-70','IntelliGrip','2021-02-10'),
    ('12','skate','Intrasonic','warm',167,'70-80','IntelliGrip','2021-03-10'),
    ('13','skate','Redline','warm',152,'50-60','wax','2021-01-10'),
    ('14','skate','Redline','warm',157,'50-60','wax','2021-02-10'),
    ('15','skate','Redline','warm',162,'50-60','wax','2021-02-10'),
    ('16','skate','Redline','warm',167,'50-60','wax','2021-02-12'),
    ('17','classic','Race Pro','cold',172,'60-70','wax','2021-02-05'),
    ('18','classic','Race Pro','cold',177,'70-80','wax','2021-02-05'),
    ('19','classic','Race Pro','cold',182,'80-90','wax','2021-02-05'),
    ('20','classic','Race Pro','cold',187,'90-100','wax','2021-02-05');




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
    `id`       INT NOT NULL,
    `name`              VARCHAR(50),
    `contract_start`    date,
    `contract_end`      date,
    `address`           VARCHAR(50),
    `price`             INT) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `customer`
    (`id`,`name`,`contract_start`,`contract_end`,`address`,`price`)
    VALUES
    ('1','XXL','2010-01-01','2030-01-01','Trondheimsveien 1','100000'),
    ('2','Sport 1','2016-01-01','2025-01-01','Gata nr 43','100000');


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
    `period`        varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `type`          varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `model`         varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `temperature`   varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `gripSystem`    varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `quantity`      INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `productionPlanSkis`
    (`period`,`type`,`model`,`temperature`,`gripSystem`,`quantity`)
    VALUES
    ('2021-01','skate','Active','cold','IntelliGrip',700),
    ('2021-01','classic','Endurance','cold','IntelliGrip',500),
    ('2021-02','skate','Active','cold','IntelliGrip',900),
    ('2021-03','skate','Intrasonic','warm','IntelliGrip',400),
    ('2021-03','classic','Endurance','cold','IntelliGrip',600),
    ('2021-04','skate','Redline','warm','wax',900),
    ('2021-04','classic','Race Pro','cold','wax',700);



ALTER TABLE `ski` 
    ADD PRIMARY KEY(`pnr`),
    ADD KEY `ski_skitype_fk` (`type`,`model`,`temperature`,`gripSystem`);

ALTER TABLE `skiType` 
    ADD PRIMARY KEY(`type`,`model`,`temperature`,`gripSystem`);

ALTER TABLE `productionPlan`
    ADD PRIMARY KEY(`period`);

ALTER TABLE `productionPlanSkis`
    ADD PRIMARY KEY(`period`,`type`,`model`,`temperature`,`gripSystem`),
    ADD KEY `productionPlanSkis_productionPlan_fk` (`period`),
    ADD KEY `productionPlanSkis_skiTypes_fk` (`type`,`model`,`temperature`,`gripSystem`);

ALTER TABLE `customer`
    ADD PRIMARY KEY(`id`);
 
ALTER TABLE `orderItems`
    ADD PRIMARY KEY(`order_number`, `ski_pnr`),
    ADD KEY `orderItems_order_fk` (`order_number`), 
    ADD KEY `orderItems_ski_fk` (`ski_pnr`);


ALTER TABLE `order`
    ADD PRIMARY KEY(`number`),
    ADD KEY `order_customer_fk` (`customerId`);

ALTER TABLE `ski`
    ADD CONSTRAINT `ski_skitype_fk` FOREIGN KEY(`type`,`model`,`temperature`,`gripSystem`) REFERENCES `skiType`(`type`,`model`,`temperature`,`gripSystem`) ON DELETE CASCADE ON UPDATE CASCADE;
 
ALTER TABLE `orderItems`
    ADD CONSTRAINT `orderItems_order_fk` FOREIGN KEY(`order_number`) REFERENCES `order`(`number`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `orderItems`
    ADD CONSTRAINT `orderItems_ski_fk` FOREIGN KEY(`ski_pnr`) REFERENCES `ski`(`pnr`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `order`
    ADD CONSTRAINT `order_customer_fk` FOREIGN KEY(`customerId`) REFERENCES `customer`(`id` ) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `productionPlanSkis`
    ADD CONSTRAINT `productionPlanSkis_productionPlan_fk` FOREIGN KEY(`period`) REFERENCES `productionPlan`(`period`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `productionPlanSkis`
    ADD CONSTRAINT `productionPlanSkis_skiTypes_fk` FOREIGN KEY(`type`,`model`,`temperature`,`gripSystem`) REFERENCES `skiType`(`type`,`model`,`temperature`,`gripSystem`) ON DELETE CASCADE ON UPDATE CASCADE;





/*
ALTER TABLE `orderItem` 
    ADD PRIMARY KEY(`itemNr`),
    ADD KEY `orderItem_order_fk` (`order_number`),
    ADD KEY `orderItem_ski_fk` (`ski_pnr`);

ALTER TABLE `orderItem`
    ADD CONSTRAINT `orderItem_order_fk` FOREIGN KEY(`order_number`) REFERENCES `order`(`number`) ON UPDATE CASCADE;
ALTER TABLE `orderItem`
    ADD CONSTRAINT `orderItem_ski_fk` FOREIGN KEY(`ski_pnr`) REFERENCES `ski`(`pnr`) ON UPDATE CASCADE;


*/