-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: 1414
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `config_device`
--

DROP TABLE IF EXISTS `config_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_device` (
  `device_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `username` bigint(20) unsigned NOT NULL,
  `ha1` char(64) DEFAULT NULL,
  `device_type` int(11) DEFAULT NULL,
  `row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `country` int(11) unsigned DEFAULT '1' COMMENT 'Country type',
  PRIMARY KEY (`device_id`),
  UNIQUE KEY `config_device_device_user_id_index` (`user_id`,`device_id`),
  UNIQUE KEY `config_device_username_unique_index` (`username`),
  KEY `config_device_user_id_index` (`user_id`),
  CONSTRAINT `config_device_user_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `config_user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=270000035 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC COMMENT='User Agent Client';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_device`
--

LOCK TABLES `config_device` WRITE;
/*!40000 ALTER TABLE `config_device` DISABLE KEYS */;
INSERT INTO `config_device` VALUES (270000000,250000003,96087610727,'a17c24c9524d00b2eeadbc8b5cc29d52',0,'2015-05-24 03:02:25',1),(270000001,250000004,53156073364,'57134436e4717bd8d9b289d94423ebd2',0,'2015-05-24 03:02:54',1),(270000002,250000005,10152727069,'9214f1d1e954cdb17678fbf6d9014ed3',0,'2015-05-24 03:03:25',1),(270000003,250000006,10153878055,'8d1a1f20ce2a01aa8c869bb2f2abb48b',0,'2015-05-24 03:03:43',1),(270000004,250000007,10152966959,'5cefcc0a6d2dbaaa45ce443040df3a5b',0,'2015-05-24 03:04:03',1),(270000006,250000007,16503983002,'e27276458e3f7aea5fd78766c9237335',1,'2015-05-30 05:56:33',1),(270000011,250000008,95592867111,'913042b78d8b5685d47a3d8c369f0a2a',0,'2015-05-24 03:51:18',1),(270000012,250000008,16503383002,'d1cafdbdc2b72f5c8dfc4a364b55e3e8',0,'2015-06-11 05:31:13',972),(270000014,250000008,16509433364,'2ed504a50df044c55cc8c88b45a15ac3',1,'2015-06-14 03:10:52',1),(270000017,250000008,16503383004,'8ab68733d800c725b90b9e4fafffc1bb',1,'2015-06-11 05:31:42',972),(270000021,250000011,838241189590106,'5eb647a93fbf66dea475e485d7e42704',0,'2015-07-01 02:11:16',1),(270000031,250000008,955928671117829,'db3d2a2f17c18f120022f0ba94cec61c',0,'2015-07-01 02:11:16',1),(270000032,250000010,972525284154,'b5c4db3aacef69e17983435d5d738698',0,'2015-06-30 22:44:18',972),(270000033,250000010,972525284157,'8e7a32cafa46d6588345861c650b3b16',0,'2015-07-01 02:09:53',972),(270000034,250000008,16503383008,'ab4298879a827905d5332951090613ca',1,'2015-08-01 06:21:59',972);
/*!40000 ALTER TABLE `config_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_device_group`
--

DROP TABLE IF EXISTS `config_device_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_device_group` (
  `device_group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `src_username` bigint(20) unsigned NOT NULL,
  `dst_username` bigint(20) unsigned NOT NULL,
  `row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`device_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=280000001 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC COMMENT='Device Group';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_device_group`
--

LOCK TABLES `config_device_group` WRITE;
/*!40000 ALTER TABLE `config_device_group` DISABLE KEYS */;
INSERT INTO `config_device_group` VALUES (280000000,95592867111,16503383004,'2015-06-11 06:01:18');
/*!40000 ALTER TABLE `config_device_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_farm`
--

DROP TABLE IF EXISTS `config_farm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_farm` (
  `farm_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `farm_uid` varchar(50) NOT NULL DEFAULT '1414' COMMENT 'the farm unique name',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'the farm name',
  `domain` varchar(50) NOT NULL DEFAULT '1414intl.com' COMMENT 'farm domain name used by UAC for identification',
  `language` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`farm_id`),
  UNIQUE KEY `config_partner_farm_uid_unique_index` (`farm_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=230000001 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_farm`
--

LOCK TABLES `config_farm` WRITE;
/*!40000 ALTER TABLE `config_farm` DISABLE KEYS */;
INSERT INTO `config_farm` VALUES (230000000,'tmus','tmus','tmusqa.com',1,'2015-05-24 02:48:45');
/*!40000 ALTER TABLE `config_farm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_number`
--

DROP TABLE IF EXISTS `config_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_number` (
  `number_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `number` bigint(20) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `intl_code` int(11) unsigned DEFAULT '11',
  `country_code` int(11) unsigned DEFAULT NULL,
  `area_code` int(11) unsigned DEFAULT NULL,
  `row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`number_id`),
  UNIQUE KEY `config_number_number` (`number`),
  KEY `config_number_user_id_index` (`user_id`),
  CONSTRAINT `config_number_user_id` FOREIGN KEY (`user_id`) REFERENCES `config_user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=260000000 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_number`
--

LOCK TABLES `config_number` WRITE;
/*!40000 ALTER TABLE `config_number` DISABLE KEYS */;
/*!40000 ALTER TABLE `config_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_tenant`
--

DROP TABLE IF EXISTS `config_tenant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_tenant` (
  `tenant_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `farm_id` int(11) unsigned NOT NULL,
  `tenant_uid` varchar(50) DEFAULT NULL COMMENT 'the unique tenant uid that tied to the tenant id',
  `name` varchar(50) DEFAULT NULL COMMENT 'printable tenant name for log an dither service functions',
  `time_zone` varchar(64) NOT NULL DEFAULT 'America/Los_Angeles' COMMENT 'time area mapping (e.g.: America/Los_Angeles)',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '[1=default,0=regular]',
  `row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tenant_id`),
  UNIQUE KEY `config_tenant_tenant_uid_unique_index` (`tenant_uid`),
  KEY `config_tenant_partner_id_index` (`farm_id`),
  KEY `config_tenant_name_index` (`name`),
  CONSTRAINT `config_tenant_farm_id_foreign_key` FOREIGN KEY (`farm_id`) REFERENCES `config_farm` (`farm_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=240000002 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC COMMENT='Table for tenant (billable customer/company) information';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_tenant`
--

LOCK TABLES `config_tenant` WRITE;
/*!40000 ALTER TABLE `config_tenant` DISABLE KEYS */;
INSERT INTO `config_tenant` VALUES (240000000,230000000,'tmus','tmus','America/Los_Angeles',0,'2015-05-24 02:49:35'),(240000001,230000000,'shirigolan','shirigolan','America/Los_Angeles',0,'2015-05-24 02:55:28');
/*!40000 ALTER TABLE `config_tenant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_user`
--

DROP TABLE IF EXISTS `config_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) unsigned NOT NULL,
  `fname` varchar(50) DEFAULT NULL COMMENT 'user First name',
  `lname` varchar(50) DEFAULT NULL COMMENT 'user Last name',
  `email` varchar(256) DEFAULT NULL COMMENT 'user email',
  `language` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '[1=us,2=de]',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '[1=default,0=regular]',
  `row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `config_user_email_unique_index` (`email`),
  KEY `config_user_tenant_id_index` (`tenant_id`),
  CONSTRAINT `config_user_tenant_id_foreign_key` FOREIGN KEY (`tenant_id`) REFERENCES `config_tenant` (`tenant_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=250000012 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC COMMENT='USER is a object to represent end-user';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_user`
--

LOCK TABLES `config_user` WRITE;
/*!40000 ALTER TABLE `config_user` DISABLE KEYS */;
INSERT INTO `config_user` VALUES (250000000,240000000,'DEFAULT','DEFAULT','tmus@tmus.com',1,1,'2015-05-24 02:53:28'),(250000002,240000001,'DEFAULT','DEFAULT','golanfamily@gmail.com',1,1,'2015-05-24 02:59:04'),(250000003,240000001,'Arna','Gadiel','gadielarna@hotmail.com',1,0,'2015-05-24 02:59:24'),(250000004,240000001,'Fly','Flyerson','flyflyerson@gmail.com',1,0,'2015-05-24 02:59:44'),(250000005,240000001,'Inbal','Dvir','inbaldvir@gmail.com',1,0,'2015-05-24 02:59:44'),(250000006,240000001,'Aviv','Raff','avivra@gmail.com',1,0,'2015-05-24 02:59:44'),(250000007,240000001,'Shira','Gadiel','shira.gadiel@gmail.com',1,0,'2015-05-24 02:59:44'),(250000008,240000001,'Ronen','Goldenber','ronen.goldenber@gmail.com',1,0,'2015-05-24 02:59:44'),(250000010,240000001,'Shiri','Golan','shirigolan@gmail.com',1,0,'2015-06-11 05:29:51'),(250000011,240000001,'Yiftach','Golan','yiftach.golan@1414intl.com',0,2,'2015-06-22 06:25:35');
/*!40000 ALTER TABLE `config_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state_cmd`
--

DROP TABLE IF EXISTS `state_cmd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state_cmd` (
  `cmd_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(11) unsigned NOT NULL,
  `cmd` varchar(512) NOT NULL,
  `row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cmd_id`),
  KEY `state_cmd_device_id` (`device_id`),
  CONSTRAINT `state_cmd_config_device_device_id` FOREIGN KEY (`device_id`) REFERENCES `config_device` (`device_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=290000029 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state_cmd`
--

LOCK TABLES `state_cmd` WRITE;
/*!40000 ALTER TABLE `state_cmd` DISABLE KEYS */;
/*!40000 ALTER TABLE `state_cmd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state_device`
--

DROP TABLE IF EXISTS `state_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state_device` (
  `state_device_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(11) unsigned NOT NULL,
  `ip` int(11) NOT NULL,
  `status` varchar(512) NOT NULL,
  `bt` bigint(20) unsigned NOT NULL,
  `nonce` varchar(128) DEFAULT NULL,
  `apikey` varchar(128) DEFAULT NULL,
  `row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `btstatus` varchar(128) NOT NULL,
  PRIMARY KEY (`state_device_id`),
  KEY `state_device_device_id` (`device_id`),
  CONSTRAINT `state_device_config_device_device_id` FOREIGN KEY (`device_id`) REFERENCES `config_device` (`device_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=280000002 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state_device`
--

LOCK TABLES `state_device` WRITE;
/*!40000 ALTER TABLE `state_device` DISABLE KEYS */;
INSERT INTO `state_device` VALUES (280000000,270000006,-1062731372,'[ /hfp/001A7DDA7111_3CD0F83FC333 ]\\n',0,'1c060272a1f9b05791e5bc7767be9124','9E8787A0-3F8A-3B55-B2ED-1D13CECCB84E','2015-08-02 05:51:23',''),(280000001,270000017,0,'[ /hfp/001A7DDA7113_F85F2ACC58F0 ]\\n',0,'131486dd28d9357355f7b17da42434e7','24351A0E-F404-873B-21F4-0CB914720AB2','2015-08-02 05:44:30','\"Error: Invalid XML element: url~Discovering services...~~[RECORD:0]~SrvClassIDList: \\\"SDServer\\\"~ProtocolDescList: ~    \\\"L2CAP');
/*!40000 ALTER TABLE `state_device` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-01 22:51:56
