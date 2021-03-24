CREATE TABLE `skiType` (
    `type`            varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `model`           varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `temperature`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `gripSystem`      varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `typeOfSkiing`    varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `descripton`      varchar(500) COLLATE utf8mb4_danish_ci NOT NULL,
    `historical`      varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `msrp`            int(11),
    `ski_pnr`         int(11)        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `skiType`
    (`type`,`model`,`temperature`,`gripSystem`,`typeOfSkiing`,`descripton`,`historical`,`msrp`, `ski_pnr`)
    VALUES
    ('skate','Active','cold','IntelliGrip','free-style','They are blue','no','999', 1),
    ('classic','Endurance','cold','IntelliGrip','double pole','They are red','no','1200', 2);


CREATE TABLE `ski` (
    `pnr`             int(11) NOT NULL,
    `size`            int(11),
    `weightClass`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `productionDate`  date,
    `type`            varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `model`           varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `temperature`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `gripSystem`      varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `orderNumber`     int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;


INSERT INTO `ski`
    (`pnr`,`type`,`model`, `temperature`, `size`, `weightClass`, `gripSystem`,`productionDate`,`orderNumber`)
    VALUES
    ('1','skate','Active','cold',142,'20-30','IntelliGrip','2021-03-17','1'),
    ('2','classic','Endurance','cold',147,'30-40','IntelliGrip','2021-03-16','2'),
    ('3','skate','Intrasonic','warm',152,'40-50','IntelliGrip','2021-01-21','2'),
    ('4','classic','Redline','warm',152,'50-60','wax','2021-02-10','3'),
    ('5','classic','Race Speed','cold',157,'50-60','wax','2021-02-05','3');




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
    ('1','2'),
    ('2','5'),
    ('2','2'),
    ('3','3'),
    ('3','1'),
    ('4','5'),
    ('4','2');



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




ALTER TABLE `skiType` 
    ADD PRIMARY KEY(`type`, `model`, `temperature`, `gripSystem`);


ALTER TABLE `ski` 
    ADD PRIMARY KEY(`pnr`),
    ADD KEY `ski_skitype_fk` (`type`);


ALTER TABLE `customer`
    ADD PRIMARY KEY(`id`);
 
ALTER TABLE `orderItems`
    ADD PRIMARY KEY(`order_number`, `ski_pnr`);


ALTER TABLE `order`
    ADD PRIMARY KEY(`number`),
    ADD KEY `order_customer_fk` (`customerId`);

ALTER TABLE `ski`
    ADD CONSTRAINT `ski_skitype_fk` FOREIGN KEY(`type`) REFERENCES `skiType`(`type`) ON UPDATE CASCADE;
 
ALTER TABLE `orderItems`
    ADD CONSTRAINT `orderItems_order_fk` FOREIGN KEY(`order_number`) REFERENCES `order`(`number`) ON UPDATE CASCADE;
ALTER TABLE `orderItems`
    ADD CONSTRAINT `orderItems_ski_fk` FOREIGN KEY(`ski_pnr`) REFERENCES `ski`(`pnr`) ON UPDATE CASCADE;

ALTER TABLE `order`
    ADD CONSTRAINT `order_customer_fk` FOREIGN KEY(`customerId`) REFERENCES `customer`(`id`) ON UPDATE CASCADE;

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