/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : oiteam

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2018-01-07 01:01:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_achievement
-- ----------------------------
DROP TABLE IF EXISTS `tbl_achievement`;
CREATE TABLE `tbl_achievement` (
  `Achi_ID` varchar(64) NOT NULL,
  `Achi_Date` varchar(20) DEFAULT NULL,
  `Achi_Name` text,
  `Achi_Identity` varchar(30) DEFAULT NULL,
  `Achi_Type` varchar(20) DEFAULT NULL,
  `Achi_DetailPath` text,
  `Achi_GrMe_ID` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`Achi_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_album
-- ----------------------------
DROP TABLE IF EXISTS `tbl_album`;
CREATE TABLE `tbl_album` (
  `Albu_ID` varchar(64) NOT NULL,
  `Albu_Title` varchar(30) DEFAULT NULL,
  `Albu_Date` varchar(20) DEFAULT NULL,
  `Albu_Introduction` varchar(100) DEFAULT NULL,
  `Albu_Path` text,
  PRIMARY KEY (`Albu_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_education
-- ----------------------------
DROP TABLE IF EXISTS `tbl_education`;
CREATE TABLE `tbl_education` (
  `Educ_ID` varchar(64) NOT NULL,
  `Educ_Date` varchar(20) DEFAULT NULL,
  `Educ_School` varchar(50) DEFAULT NULL,
  `Educ_Major` varchar(50) DEFAULT NULL,
  `Educ_Degree` varchar(20) DEFAULT NULL,
  `Educ_GrMe_ID` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`Educ_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_grouphonour
-- ----------------------------
DROP TABLE IF EXISTS `tbl_grouphonour`;
CREATE TABLE `tbl_grouphonour` (
  `GrHo_ID` varchar(64) NOT NULL,
  `GrHo_Title` varchar(50) DEFAULT NULL,
  `GrHo_Member` varchar(50) DEFAULT NULL,
  `GrHo_Date` varchar(20) DEFAULT NULL,
  `GrHo_Introduction` text,
  `GrHo_Path` text,
  PRIMARY KEY (`GrHo_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_groupmember
-- ----------------------------
DROP TABLE IF EXISTS `tbl_groupmember`;
CREATE TABLE `tbl_groupmember` (
  `GrMe_ID` varchar(64) NOT NULL,
  `GrMe_Name` varchar(20) DEFAULT NULL,
  `GrMe_Type` varchar(20) DEFAULT NULL,
  `GrMe_Title` varchar(50) DEFAULT NULL,
  `GrMe_EnrolDate` varchar(10) DEFAULT NULL,
  `GrMe_Education` varchar(20) DEFAULT NULL,
  `GrMe_School` varchar(30) DEFAULT NULL,
  `GrMe_IsGraduated` varchar(10) DEFAULT NULL,
  `GrMe_Job` varchar(30) DEFAULT NULL,
  `GrMe_Major` varchar(200) DEFAULT NULL,
  `GrMe_Phone` varchar(50) DEFAULT NULL,
  `GrMe_Email` varchar(100) DEFAULT NULL,
  `GrMe_Skill` varchar(100) DEFAULT NULL,
  `GrMe_Class` varchar(100) DEFAULT NULL,
  `GrMe_Requirement` text,
  `GrMe_Path` text,
  PRIMARY KEY (`GrMe_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_honour
-- ----------------------------
DROP TABLE IF EXISTS `tbl_honour`;
CREATE TABLE `tbl_honour` (
  `Hono_ID` varchar(64) NOT NULL,
  `Hono_Date` varchar(20) DEFAULT NULL,
  `Hono_Name` varchar(200) DEFAULT NULL,
  `Hono_GrMe_ID` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`Hono_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_news
-- ----------------------------
DROP TABLE IF EXISTS `tbl_news`;
CREATE TABLE `tbl_news` (
  `News_ID` varchar(64) NOT NULL,
  `News_Type` varchar(20) DEFAULT NULL,
  `News_Title` varchar(100) DEFAULT NULL,
  `News_Date` varchar(50) DEFAULT NULL,
  `News_ReleaseDate` varchar(20) DEFAULT NULL,
  `News_Publisher` varchar(50) DEFAULT NULL,
  `News_Introduction` text,
  `News_Detail` text,
  `News_Path` text,
  PRIMARY KEY (`News_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_others
-- ----------------------------
DROP TABLE IF EXISTS `tbl_others`;
CREATE TABLE `tbl_others` (
  `Othe_ID` varchar(64) NOT NULL,
  `Othe_Name` varchar(50) DEFAULT NULL,
  `Othe_Value` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Othe_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_resource
-- ----------------------------
DROP TABLE IF EXISTS `tbl_resource`;
CREATE TABLE `tbl_resource` (
  `Reso_ID` varchar(64) NOT NULL,
  `Reso_Type` varchar(20) DEFAULT NULL,
  `Reso_Name` varchar(50) DEFAULT NULL,
  `Reso_Date` varchar(20) DEFAULT NULL,
  `Reso_Introduction` text,
  `Reso_Downlands` int(255) DEFAULT NULL,
  `Reso_Path` text,
  `Reso_Passward` varchar(30) DEFAULT NULL,
  `Reso_GrMe_ID` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`Reso_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_workexperience
-- ----------------------------
DROP TABLE IF EXISTS `tbl_workexperience`;
CREATE TABLE `tbl_workexperience` (
  `WoEx_ID` varchar(64) NOT NULL,
  `WoEx_Date` varchar(20) DEFAULT NULL,
  `WoEx_Location` varchar(50) DEFAULT NULL,
  `WoEx_Position` varchar(50) DEFAULT NULL,
  `WoEx_Introduction` text,
  `WoEx_GrMe_ID` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`WoEx_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
