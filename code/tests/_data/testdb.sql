
CREATE TABLE `ski` (
    `pnr`             int(11) NOT NULL,
    `type`            varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `model`           varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `typeOfSkiing`    varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `temperature`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `size`            int(11),
    `weightClass`     varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `gripSystem`      varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `descripton`      varchar(500) COLLATE utf8mb4_danish_ci NOT NULL,
    `historical`      varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `msrp`            int(11),
    `productionDate`  date
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `ski`
    (`pnr`,`type`,`model`, `typeOfSkiing`, `temperature`, `size`, `weightClass`, `gripSystem`, `descripton`, `historical`, `msrp`, `productionDate`)
    VALUES
    ('1','skate','Active','free-style','cold',142,'20-30','wax','They are blue','no',999,'2021-03-17'),
    ('2','classic','Endurance','double pole','cold',147,'30-40','IntelliGrip','They are red','no',1200,'2021-03-16');




CREATE TABLE `order` (
    `number`        int(11) NOT NULL,
    `totalPrice`    int(11),
    `offLargeOrder` varchar(50) COLLATE utf8mb4_danish_ci,
    `state`         varchar(50) COLLATE utf8mb4_danish_ci NOT NULL,
    `franchise_id` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `order`
    (`number`,`totalPrice`,`offLargeOrder`,`state`,`franchise_id`)
    VALUES
    ('1',0,NULL,'new',1),
    ('2',0,NULL,'open',1),
    ('3',0,NULL,'new',2),
    ('4',0,NULL,'new',2);


CREATE TABLE `orderItem` (
    `itemNr`    int(11) NOT NULL,
    `ski_pnr`   int(11) NOT NULL,
    `order_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;


INSERT INTO `orderItem`
    (`itemNr`,`ski_pnr`,`order_number`)
    VALUES
    ('1','1','1'),
    ('2','2','1'),
    ('3','1','2'),
    ('4','2','2');


CREATE TABLE `franchise` (
    `id`       INT NOT NULL,
    `name`              VARCHAR(50),
    `contract_start`    date,
    `contract_end`      date,
    `address`           VARCHAR(50),
    `price`             INT) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

INSERT INTO `franchise`
    (`id`,`name`,`contract_start`,`contract_end`,`address`,`price`)
    VALUES
    ('1','XXL','2010-01-01','2030-01-01','Trondheimsveien 1','100000'),
    ('2','Sport 1','2016-01-01','2025-01-01','Gata nr 43','100000');







ALTER TABLE `ski` 
    ADD PRIMARY KEY(`pnr`);

ALTER TABLE `franchise`
    ADD PRIMARY KEY(`id`);


ALTER TABLE `order`
    ADD PRIMARY KEY(`number`),
    ADD KEY `order_franchise_fk` (`franchise_id`);

ALTER TABLE `order`
    ADD CONSTRAINT `order_customer_fk` FOREIGN KEY(`franchise_id`) REFERENCES `franchise`(`id`) ON UPDATE CASCADE;


ALTER TABLE `orderItem` 
    ADD PRIMARY KEY(`itemNr`),
    ADD KEY `orderItem_order_fk` (`order_number`),
    ADD KEY `orderItem_ski_fk` (`ski_pnr`);

ALTER TABLE `orderItem`
    ADD CONSTRAINT `orderItem_order_fk` FOREIGN KEY(`order_number`) REFERENCES `order`(`number`) ON UPDATE CASCADE;
ALTER TABLE `orderItem`
    ADD CONSTRAINT `orderItem_ski_fk` FOREIGN KEY(`ski_pnr`) REFERENCES `ski`(`pnr`) ON UPDATE CASCADE;


    

